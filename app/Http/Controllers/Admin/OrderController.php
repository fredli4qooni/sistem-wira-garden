<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Order;

class OrderController extends Controller
{
    private function getFilteredOrders(Request $request)
    {
        $query = Order::with('destination');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('visitor_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        if ($request->filled('status') && $request->status !== 'ALL') {
            $query->where('status', $request->status);
        }

        return $query->latest();
    }

    public function index(Request $request)
    {
        $orders = $this->getFilteredOrders($request)->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function exportPdf(Request $request)
    {
        $orders = $this->getFilteredOrders($request)->get();
        
        $pdf = Pdf::loadView('admin.orders.pdf', compact('orders', 'request'))
                  ->setPaper('a4', 'landscape');
                  
        return $pdf->download('Laporan_Pemesanan_Wira_Garden_' . date('Y-m-d') . '.pdf');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:PENDING,PAID,CONFIRMED,COMPLETED,CANCELLED']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }
}
