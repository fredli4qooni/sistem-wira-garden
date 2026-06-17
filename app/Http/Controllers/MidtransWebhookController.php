<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        $order = Order::where('order_code', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $order->update(['status' => 'PAID']);
            }
        } else if ($transactionStatus == 'settlement') {
            $order->update(['status' => 'PAID']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $order->update(['status' => 'CANCELLED']);
        }

        Payment::updateOrCreate(
            ['order_id' => $order->id, 'midtrans_transaction_id' => $notification->transaction_id],
            [
                'payment_type' => $notification->payment_type,
                'status' => $transactionStatus,
                'paid_at' => ($transactionStatus == 'settlement' || $transactionStatus == 'capture') ? now() : null,
                'response_payload' => json_encode($notification),
            ]
        );

        return response()->json(['message' => 'Webhook handled']);
    }
}
