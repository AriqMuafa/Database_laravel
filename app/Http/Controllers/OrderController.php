<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function confirm($denda_id)
    {
        $denda = Denda::with('peminjaman.buku')->findOrFail($denda_id);

        // Validasi: Jangan bayar kalau sudah lunas
        if ($denda->status == 'lunas') {
            return redirect()->route('menu.peminjaman')->with('success', 'Denda ini sudah lunas.');
        }

        return view('fines.confirm', compact('denda'));
    }

    public function process($denda_id)
    {
        $denda = Denda::findOrFail($denda_id);

        // 1. Cek apakah sudah ada Order yang masih pending untuk denda ini?
        $existingOrder = Order::where('denda_id', $denda_id)
            ->where('payment_status', 'pending')
            ->first();

        // Jika sudah ada order pending, langsung arahkan ke halaman waiting
        if ($existingOrder) {
            return redirect()->route('fines.waiting', $existingOrder->id);
        }

        // 2. Setting Expiry Time (misal 24 jam)
        $expiredHours = (int) config('services.payment.expired_hours', 24);

        // 3. Buat Data Order Baru di Database Lokal
        $order = Order::create([
            'user_id' => Auth::id(),
            'denda_id' => $denda->denda_id, // Pastikan nama kolom primary key denda benar
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'amount' => $denda->jumlah,
            'payment_status' => 'pending',
            'expired_at' => now()->addHours($expiredHours),
        ]);

        // 4. Kirim Request ke API Payment Gateway (Simulasi / Real)
        try {
            // Contoh request ke API luar (sesuaikan dengan dokumentasi Payment Gateway kamu)
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'), // Pastikan ada di .env
                'Accept' => 'application/json',
            ])->post(config('services.payment.base_url') . '/virtual-account/create', [
                'external_id' => $order->order_number,
                'amount' => $order->amount,
                'payer_name' => Auth::user()->name,
                'description' => 'Pembayaran Denda Peminjaman ID: ' . $denda->peminjaman_id
            ]);

            // Jika API Error
            if ($response->failed()) {
                throw new \Exception('Gagal menghubungi Payment Gateway: ' . $response->body());
            }

            // Simpan respon dari gateway (misal nomor VA) jika perlu
            $responseData = $response->json();
            // $order->update(['checkout_link' => $responseData['payment_url'] ?? null]);

            return redirect()->route('fines.waiting', $order->id);
        } catch (\Exception $e) {
            Log::error('Payment Error: ' . $e->getMessage());
            $order->update(['payment_status' => 'failed']);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }

    public function waiting(Order $order)
    {
        if ($order->user_id !== auth()->id())
            abort(403);

        if ($order->payment_status == 'paid') {
            return redirect()->route('fines.success', $order->id);
        }

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
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status == 'paid') {

            // Cari denda terkait
            $denda = Denda::find($order->denda_id);

            if ($denda && $denda->status !== 'lunas') {
                $denda->update([
                    'status' => 'lunas',
                    'tanggal_pembayaran' => now()
                ]);
            }
        }

        return view('fines.success', compact('order'));
    }
}
