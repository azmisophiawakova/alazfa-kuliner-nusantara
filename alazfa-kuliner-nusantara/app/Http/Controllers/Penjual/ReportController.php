<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->stores()->first();
        if (!$store) return response()->json(['message' => 'Toko tidak ditemukan'], 404);

        $query = Order::where('id_toko', $store->id_toko)
                      ->where('status_pesanan', 'selesai');

        $filter = $request->get('filter', 'semua');
        
        if ($filter == 'mingguan') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        // Get total sales completed
        $total_sales = $query->sum('total_harga');
        $orders_completed = $query->count();
        $orders_list = $query->latest()->get();

        $data = [
            'total_sales' => $total_sales,
            'orders_completed' => $orders_completed,
            'filter' => $filter,
            'orders_list' => $orders_list
        ];

        if ($request->wantsJson()) return response()->json($data);
        return view('penjual.reports.index', compact('data'));
    }
}
