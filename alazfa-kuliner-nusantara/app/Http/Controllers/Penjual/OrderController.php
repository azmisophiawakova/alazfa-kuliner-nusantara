<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, Notification};
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function getStore() {
        return Auth::user()->stores()->first();
    }

    public function index(Request $request)
    {
        $orders = Order::where('id_toko', $this->getStore()->id_toko)->with(['user', 'orderDetails.product'])->get();
        if ($request->wantsJson()) return response()->json($orders);
        return view('penjual.orders.index', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $order = Order::where('id_toko', $this->getStore()->id_toko)->with(['user', 'orderDetails.product', 'payment'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($order);
        return view('penjual.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id_toko', $this->getStore()->id_toko)->findOrFail($id);
        $request->validate(['status_pesanan' => 'required|in:menunggu,diproses,dikirim,selesai,dibatalkan']);
        
        // Cek jika status berubah jadi selesai untuk pertama kalinya
        if ($request->status_pesanan == 'selesai' && $order->status_pesanan != 'selesai') {
            \Illuminate\Support\Facades\DB::transaction(function () use ($order, $request) {
                // 1. Tambah saldo penjual
                $penjual = Auth::user();
                $penjual->saldo += $order->total_harga;
                $penjual->save();

                // 2. Tambah saldo kurir (jika ada)
                if ($order->id_kurir) {
                    $kurir = \App\Models\User::find($order->id_kurir);
                    if ($kurir) {
                        $kurir->saldo += $order->ongkos_kirim;
                        $kurir->save();
                    }
                }

                $order->update(['status_pesanan' => 'selesai']);
            });
        } else {
            $order->update(['status_pesanan' => $request->status_pesanan]);
        }

        Notification::create([
            'id_user' => $order->id_user,
            'judul' => 'Status Pesanan Diperbarui',
            'pesan' => 'Pesanan Anda dari ' . $this->getStore()->nama_toko . ' sekarang berstatus: ' . strtoupper($request->status_pesanan)
        ]);

        if ($request->wantsJson()) return response()->json(['message' => 'Status pesanan diperbarui', 'order' => $order]);
        return redirect()->back()->with('success', 'Status pesanan diperbarui');
    }

    public function verifyPayment(Request $request, $id)
    {
        $order = Order::where('id_toko', $this->getStore()->id_toko)->with(['payment', 'user'])->findOrFail($id);
        $request->validate(['status_pembayaran' => 'required|in:berhasil,gagal']);
        
        $order->payment->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        Notification::create([
            'id_user' => $order->id_user,
            'judul' => 'Verifikasi Pembayaran',
            'pesan' => 'Pembayaran Anda untuk pesanan #' . $order->id_pesanan . ' telah ' . strtoupper($request->status_pembayaran) . ' oleh penjual.'
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diverifikasi');
    }

    public function printReceipt(Request $request, $id)
    {
        $order = Order::where('id_toko', $this->getStore()->id_toko)->with(['user', 'orderDetails.product', 'payment'])->findOrFail($id);
        // Usually returns a view styled for printing or PDF
        return view('penjual.orders.receipt', compact('order'));
    }
}
