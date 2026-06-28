<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $paidOrders = Order::where('status', 'PAID')->count();
        $totalRevenue = Order::whereIn('status', ['PAID', 'CONFIRMED', 'COMPLETED'])->sum('total_amount');
        
        $recentOrders = Order::latest()->take(5)->get();

        // Chart Data (Current Month)
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00');
        $endOfMonth = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d 23:59:59');
        $monthlyOrders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        $reservationsPerDay = $monthlyOrders->groupBy(function($order) {
            return \Carbon\Carbon::parse($order->created_at)->format('d M');
        })->map(function($dayOrders) {
            return $dayOrders->count();
        })->sortKeys();

        $statusCounts = [
            'Menunggu' => $monthlyOrders->whereIn('status', ['PENDING', 'PAID'])->count(),
            'Dikonfirmasi' => $monthlyOrders->where('status', 'CONFIRMED')->count(),
            'Selesai' => $monthlyOrders->where('status', 'COMPLETED')->count(),
            'Dibatalkan' => $monthlyOrders->where('status', 'CANCELLED')->count(),
        ];
        
        return view('admin.dashboard', compact(
            'totalOrders', 'paidOrders', 'totalRevenue', 'recentOrders',
            'reservationsPerDay', 'statusCounts'
        ));
    }
}
