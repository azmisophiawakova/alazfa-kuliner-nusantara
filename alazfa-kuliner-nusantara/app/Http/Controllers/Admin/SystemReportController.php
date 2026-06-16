<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;

class SystemReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data Penjualan Seluruh Sistem
        $total_revenue = Order::where('status_pesanan', 'selesai')->sum('total_harga');
        $total_orders = Order::count();
        $completed_orders = Order::where('status_pesanan', 'selesai')->count();
        $canceled_orders = Order::where('status_pesanan', 'dibatalkan')->count();

        // 2. Data Pengguna
        $total_users = User::count();
        $total_pelanggan = User::where('role', 'pelanggan')->count();
        $total_penjual = User::where('role', 'penjual')->count();
        $total_kurir = User::where('role', 'kurir')->count();

        // 3. Data Toko
        $total_stores = Store::count();
        $approved_stores = Store::where('status_verifikasi', 'disetujui')->count();

        // 4. Penjualan Mingguan (7 Hari Terakhir)
        $weekly_sales = Order::where('status_pesanan', 'selesai')
            ->where('created_at', '>=', now()->subDays(7))
            ->sum('total_harga');

        $data = [
            'total_revenue' => $total_revenue,
            'total_orders' => $total_orders,
            'completed_orders' => $completed_orders,
            'canceled_orders' => $canceled_orders,
            'total_users' => $total_users,
            'total_pelanggan' => $total_pelanggan,
            'total_penjual' => $total_penjual,
            'total_kurir' => $total_kurir,
            'total_stores' => $total_stores,
            'approved_stores' => $approved_stores,
            'weekly_sales' => $weekly_sales
        ];

        if ($request->wantsJson()) return response()->json($data);
        return view('admin.reports.system', compact('data'));
    }
}
