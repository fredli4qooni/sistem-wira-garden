<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use App\Models\Destination;
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

    public function create(Request $request)
    {
        $destinations = Destination::all()->map(function($dest) {
            $dest->image_url = \Illuminate\Support\Facades\Storage::url($dest->image_path ?? 'default.jpg');
            return $dest;
        });
        
        if ($destinations->isEmpty()) {
            return redirect()->route('destinations.index')->with('error', 'Belum ada destinasi yang tersedia untuk direservasi.');
        }

        $selectedDestinationId = $request->query('destination_id');
        $selectedDestination = null;

        if ($selectedDestinationId) {
            $selectedDestination = $destinations->firstWhere('id', $selectedDestinationId);
        }

        // If no valid destination_id passed, default to the first one
        if (!$selectedDestination) {
            $selectedDestination = $destinations->first();
        }
        
        return view('reservations.create', compact('destinations', 'selectedDestination'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'visit_date' => 'required|date|after_or_equal:today',
            'cart_items' => 'required|string',
        ]);

        $cartItems = json_decode($request->cart_items, true);
        if (empty($cartItems) || !is_array($cartItems)) {
            return back()->withInput()->withErrors(['cart' => 'Keranjang pesanan tidak boleh kosong.']);
        }

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $totalTickets = 0;
            $itemsToCreate = [];
            $destinationQuantities = [];

            foreach ($cartItems as $item) {
                if (!isset($item['destination_id'])) continue;
                
                $destination = Destination::findOrFail($item['destination_id']);
                
                $qtyAdult = isset($item['tickets_adult']) ? (int) $item['tickets_adult'] : 0;
                $qtyChild = isset($item['tickets_child']) ? (int) $item['tickets_child'] : 0;
                
                if ($qtyAdult <= 0 && $qtyChild <= 0) continue;

                if ($destination->pricing_type === 'per_package') {
                    $itemTotal = $destination->price_adult * $qtyAdult;
                    $totalTickets += $qtyAdult; // Package qty
                    
                    if (!isset($destinationQuantities[$destination->id])) $destinationQuantities[$destination->id] = 0;
                    $destinationQuantities[$destination->id] += $qtyAdult;

                    $itemsToCreate[] = [
                        'destination_id' => $destination->id,
                        'ticket_type_id' => null,
                        'ticket_name' => 'Paket / Tenda (' . $destination->name . ')',
                        'quantity' => $qtyAdult,
                        'unit_price' => $destination->price_adult,
                        'subtotal' => $itemTotal,
                    ];
                } else {
                    $itemTotal = ($destination->price_adult * $qtyAdult) + ($destination->price_child * $qtyChild);
                    $totalTickets += ($qtyAdult + $qtyChild);
                    
                    if (!isset($destinationQuantities[$destination->id])) $destinationQuantities[$destination->id] = 0;
                    $destinationQuantities[$destination->id] += ($qtyAdult + $qtyChild);

                    if ($qtyAdult > 0) {
                        $itemsToCreate[] = [
                            'destination_id' => $destination->id,
                            'ticket_type_id' => null,
                            'ticket_name' => 'Dewasa (' . $destination->name . ')',
                            'quantity' => $qtyAdult,
                            'unit_price' => $destination->price_adult,
                            'subtotal' => $destination->price_adult * $qtyAdult,
                        ];
                    }
                    if ($qtyChild > 0) {
                        $itemsToCreate[] = [
                            'destination_id' => $destination->id,
                            'ticket_type_id' => null,
                            'ticket_name' => 'Anak-anak (' . $destination->name . ')',
                            'quantity' => $qtyChild,
                            'unit_price' => $destination->price_child,
                            'subtotal' => $destination->price_child * $qtyChild,
                        ];
                    }
                }
                
                $totalAmount += $itemTotal;
            }

            if (empty($itemsToCreate)) {
                return back()->withInput()->withErrors(['cart' => 'Item pesanan tidak valid atau belum ditambahkan.']);
            }

            // Check Quota
            $quota = VisitQuota::where('date', $request->visit_date)->first();
            if ($quota && $quota->is_blocked) {
                return back()->withInput()->withErrors(['visit_date' => 'Maaf, tanggal ini tidak tersedia untuk kunjungan.']);
            }
            if ($quota && ($quota->used_quota + $totalTickets > $quota->max_quota)) {
                return back()->withInput()->withErrors(['visit_date' => 'Maaf, kuota kunjungan pada tanggal ini penuh.']);
            }

            // Check Stock for each destination
            foreach ($destinationQuantities as $destId => $qtyRequested) {
                $destination = Destination::findOrFail($destId);
                if (!is_null($destination->total_stock)) {
                    $availableStock = $destination->getAvailableStock($request->visit_date);
                    if ($qtyRequested > $availableStock) {
                        return back()->withInput()->withErrors(['visit_date' => 'Maaf, sisa ketersediaan ' . $destination->name . ' untuk tanggal ini hanya ' . $availableStock . ' unit.']);
                    }
                }
            }

            // Update Quota if exists
            if ($quota) {
                $quota->increment('used_quota', $totalTickets);
            }

            $orderCode = 'WG-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => auth()->id(),
                'visitor_name' => $request->visitor_name,
                'phone' => $request->phone,
                'email' => $request->email ?? '',
                'visit_date' => $request->visit_date,
                'total_amount' => $totalAmount,
                'status' => 'PENDING',
            ]);

            foreach ($itemsToCreate as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::create($itemData);
            }

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
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        if ($order->status !== 'PENDING') {
            return redirect()->route('reservations.success', $order->order_code);
        }

        $clientKey = config('midtrans.client_key');
        return view('reservations.payment', compact('order', 'clientKey'));
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        return view('reservations.success', compact('order'));
    }
}
