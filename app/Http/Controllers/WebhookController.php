<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handlePayment(Request $request)
    {
        Log::info('Webhook received', $request->all());

        $signature = $request->header('X-Webhook-Signature');
        $webhookSecret = config('services.payment.webhook_secret');

        $payload = $request->all();
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $webhookSecret);

        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Invalid webhook signature', [
                'expected' => $expectedSignature,
                'received' => $signature,
            ]);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        $order = Order::where('order_number', $data['external_id'] ?? '')->first();

        if (!$order) {
            Log::warning('Order not found', ['external_id' => $data['external_id'] ?? '']);
            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($order->isPaid()) {
            Log::info('Payment already processed', ['order_id' => $order->id]);
            return response()->json(['message' => 'Already processed'], 200);
        }

        if ($event === 'payment.success') {
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
            Log::info('Payment success processed', ['order_id' => $order->id, 'amount' => $order->amount]);
        } elseif ($event === 'payment.failed') {
            $order->update(['payment_status' => 'failed']);
            Log::info('Payment failed processed', ['order_id' => $order->id]);
        } elseif ($event === 'payment.expired') {
            $order->update(['payment_status' => 'expired']);
            Log::info('Payment expired processed', ['order_id' => $order->id]);
        }

        return response()->json(['message' => 'Webhook processed'], 200);
    }
}
