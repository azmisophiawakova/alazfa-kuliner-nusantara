<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Order, OrderDetail, Cart, Payment, Notification, Store};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('id_user', Auth::id())->with(['store', 'orderDetails.product'])->orderBy('created_at', 'desc')->get();
        if ($request->wantsJson()) return response()->json($orders);
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        // Ambil keranjang user
        $carts = Cart::where('id_user', Auth::id())->with('product')->get();
        if ($carts->isEmpty()) {
            if ($request->wantsJson()) return response()->json(['message' => 'Keranjang kosong'], 400);
            return redirect()->back()->with('error', 'Keranjang Anda kosong');
        }

        // Kita kelompokkan pesanan berdasarkan toko (1 pesanan = 1 toko)
        $cartsByStore = $carts->groupBy('product.id_toko');
        $createdOrders = [];

        DB::beginTransaction();
        try {
            foreach ($cartsByStore as $id_toko => $items) {
                $total_harga = $items->sum(function ($item) {
                    return $item->product->harga * $item->jumlah;
                });

                $ongkir = 10000; // Misal ongkir statis 10rb per toko
                $biaya_admin = 3000; // Biaya aplikasi / admin
                $order = Order::create([
                    'id_user' => Auth::id(),
                    'id_toko' => $id_toko,
                    'total_harga' => $total_harga, 
                    'ongkos_kirim' => $ongkir,
                    'biaya_admin' => $biaya_admin,
                    'status_pesanan' => 'menunggu',
                    'alamat_pengiriman' => (Auth::user()->alamat ?? 'Alamat Belum Diatur') . ', ' . (Auth::user()->kota ?? '') . ', ' . (Auth::user()->provinsi ?? '')
                ]);

                Payment::create([
                    'id_pesanan' => $order->id_pesanan,
                    'metode_pembayaran' => $request->input('metode_pembayaran', 'QRIS'),
                    'jumlah_pembayaran' => $order->total_harga + $order->ongkos_kirim + $order->biaya_admin,
                    'status_pembayaran' => 'pending'
                ]);

                foreach ($items as $item) {
                    OrderDetail::create([
                        'id_pesanan' => $order->id_pesanan,
                        'id_produk' => $item->id_produk,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->product->harga,
                        'subtotal' => $item->product->harga * $item->jumlah
                    ]);
                }
                
                // Ambil toko
                $store = Store::find($id_toko);
                if ($store) {
                    Notification::create([
                        'id_user' => $store->id_user,
                        'judul' => 'Pesanan Baru Masuk!',
                        'pesan' => 'Ada pesanan baru senilai Rp ' . number_format($total_harga, 0, ',', '.') . ' dari ' . Auth::user()->name . '. Segera cek menu pesanan masuk!'
                    ]);
                }

                $createdOrders[] = $order;
            }
            
            // Kosongkan keranjang setelah checkout
            Cart::where('id_user', Auth::id())->delete();
            DB::commit();

            if ($request->wantsJson()) return response()->json(['message' => 'Checkout berhasil', 'orders' => $createdOrders], 201);
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) return response()->json(['message' => 'Terjadi kesalahan sistem', 'error' => $e->getMessage()], 500);
            return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $order = Order::where('id_user', Auth::id())->with(['store', 'orderDetails.product', 'kurir', 'payment'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($order);
        return view('orders.show', compact('order'));
    }

    public function uploadPayment(Request $request, $id)
    {
        $order = Order::where('id_user', Auth::id())->with('payment')->findOrFail($id);
        
        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('payments', 'public');
            
            $order->payment->update([
                'bukti_pembayaran' => $path
            ]);

            // Notify seller
            Notification::create([
                'id_user' => $order->store->id_user,
                'judul' => 'Bukti Pembayaran Diunggah',
                'pesan' => 'Pelanggan ' . Auth::user()->name . ' telah mengunggah bukti pembayaran untuk pesanan #' . $order->id_pesanan . '. Silakan verifikasi.'
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi penjual.');
    }
}

