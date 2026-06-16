<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, Store};

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Tampilkan produk terbaru atau unggulan
        $featured_products = Product::with(['store', 'category'])->withAvg('reviews', 'rating')->withCount('reviews')->latest()->take(6)->get();
        $categories = \App\Models\Category::all();
        if ($request->wantsJson()) return response()->json($featured_products);
        return view('home', compact('featured_products', 'categories'));
    }

    public function sellers(Request $request)
    {
        // Tampilkan daftar UMKM yang sudah diverifikasi
        $query = Store::where('status_verifikasi', 'disetujui')->with('user');
        
        if ($request->sort === 'terpopuler') {
            $query->withCount('products')->orderByDesc('products_count');
        } elseif ($request->sort === 'rating') {
            // Placeholder untuk sort rating
            $query->inRandomOrder();
        } else {
            $query->latest();
        }
        
        $sellers = $query->get();
        if ($request->wantsJson()) return response()->json($sellers);
        return view('sellers.index', compact('sellers'));
    }

    public function showSeller(Request $request, $id)
    {
        $seller = Store::with(['user', 'products'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($seller);
        return view('sellers.show', compact('seller'));
    }

    public function pelangganDashboard(Request $request)
    {
        $featured_products = Product::with(['store', 'category'])->withAvg('reviews', 'rating')->withCount('reviews')->latest()->take(6)->get();
        if ($request->wantsJson()) return response()->json($featured_products);
        return view('pelanggan.dashboard', compact('featured_products'));
    }
}
