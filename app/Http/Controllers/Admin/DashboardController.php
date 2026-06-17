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
        
        return view('admin.dashboard', compact('totalOrders', 'paidOrders', 'totalRevenue', 'recentOrders'));
    }
}
