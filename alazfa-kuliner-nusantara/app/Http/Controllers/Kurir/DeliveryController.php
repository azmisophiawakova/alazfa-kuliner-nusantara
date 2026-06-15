<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, Notification};
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        // Lihat daftar pesanan yang butuh kurir dan tokonya berada di provinsi yang sama dengan kurir
        $available_orders = Order::whereIn('status_pesanan', ['diproses', 'dikirim'])
                                 ->whereNull('id_kurir')
                                 ->whereHas('store', function($query) {
                                     $query->where('provinsi', Auth::user()->provinsi);
                                 })
                                 ->with(['store', 'user'])
                                 ->get();
        
        // Pesanan yang sedang ditangani kurir ini
        $my_deliveries = Order::where('id_kurir', Auth::id())
                              ->whereIn('status_pesanan', ['diambil', 'dikirim'])
                              ->with(['store', 'user'])
                              ->get();

        if ($request->wantsJson()) return response()->json(compact('available_orders', 'my_deliveries'));
        return view('kurir.deliveries.index', compact('available_orders', 'my_deliveries'));
    }

    public function accept(Request $request, $id)
    {
        $order = Order::whereIn('status_pesanan', ['diproses', 'dikirim'])->whereNull('id_kurir')->findOrFail($id);
        $order->update([
            'id_kurir' => Auth::id(),
            'status_pesanan' => 'diambil'
        ]);

        Notification::create([
            'id_user' => $order->id_user,
            'judul' => 'Pesanan Diambil Kurir',
            'pesan' => 'Kurir ' . Auth::user()->name . ' telah mengambil pesanan Anda dan akan segera mengantarkannya.'
        ]);

        if ($request->wantsJson()) return response()->json(['message' => 'Tugas diterima', 'order' => $order]);
        return redirect()->back()->with('success', 'Tugas diterima');
    }

    public function reject(Request $request, $id)
    {
        $order = Order::where('id_kurir', Auth::id())->where('status_pesanan', 'diambil')->findOrFail($id);
        // Batalkan penerimaan tugas
        $order->update([
            'id_kurir' => null,
            'status_pesanan' => 'diproses'
        ]);

        if ($request->wantsJson()) return response()->json(['message' => 'Tugas dibatalkan']);
        return redirect()->back()->with('success', 'Tugas dibatalkan');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id_kurir', Auth::id())->findOrFail($id);
        $request->validate(['status_pesanan' => 'required|in:dikirim,selesai']);
        $order->update(['status_pesanan' => $request->status_pesanan]);

        Notification::create([
            'id_user' => $order->id_user,
            'judul' => 'Status Pengantaran',
            'pesan' => 'Pesanan Anda sekarang berstatus: ' . strtoupper($request->status_pesanan)
        ]);

        if ($request->wantsJson()) return response()->json(['message' => 'Status pengiriman diperbarui']);
        return redirect()->back()->with('success', 'Status pengiriman diperbarui');
    }

    public function history(Request $request)
    {
        $deliveries = Order::where('id_kurir', Auth::id())->where('status_pesanan', 'selesai')->with(['store', 'user'])->get();
        if ($request->wantsJson()) return response()->json($deliveries);
        return view('kurir.deliveries.history', compact('deliveries'));
    }
}
