<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Store, Notification};

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user');
        
        if ($request->has('status') && $request->status !== 'semua') {
            $query->where('status_verifikasi', $request->status);
        }
        
        $stores = $query->latest()->get();
        if ($request->wantsJson()) return response()->json($stores);
        return view('admin.stores.index', compact('stores'));
    }

    public function verify(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $status = $request->input('status', 'disetujui');
        $store->update(['status_verifikasi' => $status]);

        Notification::create([
            'id_user' => $store->id_user,
            'judul' => 'Pembaruan Status Toko',
            'pesan' => 'Pengajuan toko Anda ("' . $store->nama_toko . '") telah ' . strtoupper($status) . ' oleh Admin.'
        ]);

        if ($request->wantsJson()) return response()->json(['message' => 'Toko diverifikasi', 'store' => $store]);
        return redirect()->back()->with('success', 'Status toko diperbarui');
    }
}
