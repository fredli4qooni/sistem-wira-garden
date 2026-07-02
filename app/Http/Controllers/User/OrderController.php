<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.orders.index', compact('orders'));
    }
    
    public function show(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('user.orders.show', compact('order'));
    }
}
