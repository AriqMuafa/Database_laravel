<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function confirm(Denda $denda)
    {
        return view('fines.confirm', compact('denda'));
    }

    public function process(Denda $denda)
    {
        $expiredHours = (int) config('services.payment.expired_hours', 24);
        \Log::info('Debug Denda', [
            'denda_object' => $denda->toArray(),
            'getKey' => $denda->getKey(),
            'keyName' => $denda->getKeyName(),
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'denda_id' => $denda->getKey(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'amount' => $denda->jumlah,
            'payment_status' => 'pending',
            'expired_at' => now()->addHours($expiredHours),
        ]);

        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept' => 'application/json',
            ])->post(config('services.payment.base_url') . '/virtual-account/create', [
                        'external_id' => $order->order_number,
                        'amount' => $order->amount,
                        'customer_name' => auth()->user()->name,
                        'customer_email' => auth()->user()->email,
                        'customer_phone' => auth()->user()->phone ?? '081234567890',
                        'description' => 'Pembayaran Denda ' . $denda->peminjaman->judul_buku,
                        'expired_duration' => $expiredHours,
                        'callback_url' => route('fines.success', $order),
                        'metadata' => [
                            'denda_id' => $denda->getkey(),
                            'user_id' => auth()->id(),
                        ],
                    ]);
            // \Log::info('Response dari payment gateway:', $response->json());
            // \Log::info('Status:', ['status_code' => $response->status()]);

            // dd($response->json(), $response->status());


            if ($response->successful()) {
                $data = $response->json();

                // Pastikan data valid
                $order->update([
                    'va_number' => $data['data']['va_number'] ?? null,
                    'payment_url' => $data['data']['payment_url'] ?? null,
                ]);

                // Redirect ke halaman menunggu pembayaran
                return redirect()->route('fines.waiting', $order)
                    ->with('success', 'Pembayaran berhasil dibuat. Silakan lanjutkan ke gateway.');
            } else {
                // Simpan log agar bisa dicek di storage/logs/laravel.log
                \Log::error('Payment gateway error response:', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                $order->update(['payment_status' => 'failed']);

                return redirect()->route('menu.peminjaman')
                    ->with('error', 'Gagal membuat pembayaran. Silakan coba lagi nanti.');
            }

        } catch (\Exception $e) {
            \Log::error('Payment gateway exception:', ['message' => $e->getMessage()]);
            $order->update(['payment_status' => 'failed']);

            return redirect()->route('menu.peminjaman')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    public function waiting(Order $order)
    {
        if ($order->user_id !== auth()->id())
            abort(403);

        if ($order->isPaid())
            return redirect()->route('fines.success', $order);

        if ($order->isExpired()) {
            return redirect()->route('menu.peminjaman')
                ->with('error', 'Pembayaran telah expired.');
        }

        return view('fines.waiting', compact('order'));
    }

    public function checkStatus(Order $order)
    {
        if ($order->user_id !== auth()->id())
            abort(403);

        return response()->json([
            'status' => $order->payment_status,
            'paid_at' => $order->paid_at?->toISOString(),
        ]);
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id())
            abort(403);

        if (!$order->isPaid()) {
            if ($order->denda_id) {
                $denda = Denda::find($order->denda_id);
                if ($denda && $denda->status !== 'lunas') {
                    $denda->update(['status' => 'lunas']);
                }
            }
            return redirect()->route('fines.waiting', $order);


        }

        return view('fines.success', compact('order'));
    }
}