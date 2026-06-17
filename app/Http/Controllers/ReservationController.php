<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use App\Models\VisitQuota;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class ReservationController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function create()
    {
        $ticketTypes = TicketType::where('is_active', true)->get();
        return view('reservations.create', compact('ticketTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'visit_date' => 'required|date|after_or_equal:today',
            'tickets' => 'required|array',
            'tickets.*' => 'integer|min:0',
        ]);

        $totalTickets = array_sum($request->tickets);
        if ($totalTickets <= 0) {
            return back()->withInput()->withErrors(['tickets' => 'Silakan pilih minimal 1 tiket.']);
        }

        // Check Quota
        $quota = VisitQuota::where('date', $request->visit_date)->first();
        if ($quota && $quota->is_blocked) {
            return back()->withInput()->withErrors(['visit_date' => 'Maaf, tanggal ini tidak tersedia untuk kunjungan.']);
        }
        if ($quota && ($quota->used_quota + $totalTickets > $quota->max_quota)) {
            return back()->withInput()->withErrors(['visit_date' => 'Maaf, kuota kunjungan pada tanggal ini penuh.']);
        }

        DB::beginTransaction();
        try {
            // Update Quota if exists
            if ($quota) {
                $quota->increment('used_quota', $totalTickets);
            }

            $orderCode = 'WG-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $order = Order::create([
                'order_code' => $orderCode,
                'visitor_name' => $request->visitor_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'visit_date' => $request->visit_date,
                'total_amount' => 0, // will calculate below
                'status' => 'PENDING',
            ]);

            $totalAmount = 0;
            foreach ($request->tickets as $ticketId => $qty) {
                if ($qty > 0) {
                    $ticket = TicketType::find($ticketId);
                    $subtotal = $ticket->price * $qty;
                    $totalAmount += $subtotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'ticket_type_id' => $ticket->id,
                        'quantity' => $qty,
                        'unit_price' => $ticket->price,
                        'subtotal' => $subtotal,
                    ]);
                }
            }

            $order->update(['total_amount' => $totalAmount]);

            // Request Snap Token
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $order->visitor_name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return redirect()->route('reservations.payment', $order->order_code);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem, silakan coba lagi. ' . $e->getMessage()]);
        }
    }

    public function payment(Order $order)
    {
        if ($order->status !== 'PENDING') {
            return redirect()->route('reservations.success', $order->order_code);
        }

        $clientKey = config('midtrans.client_key');
        return view('reservations.payment', compact('order', 'clientKey'));
    }

    public function success(Order $order)
    {
        return view('reservations.success', compact('order'));
    }
}
