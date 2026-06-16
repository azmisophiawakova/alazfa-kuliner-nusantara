<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Store, Product, Order};

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status_pesanan', 'selesai')->sum('biaya_admin'),
        ];
        if ($request->wantsJson()) return response()->json($data);
        return view('admin.dashboard', compact('data'));
    }
    public function updateQris(Request $request)
    {
        $request->validate([
            'qris_image' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('qris_image')) {
            $file = $request->file('qris_image');
            // Store directly as qris.jpg to easily overwrite and reference it
            $file->storeAs('', 'qris.jpg', 'public');
        }

        return redirect()->back()->with('success', 'Gambar QRIS berhasil diperbarui!');
    }
}
