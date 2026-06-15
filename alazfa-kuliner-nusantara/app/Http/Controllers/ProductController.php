<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category'])->withAvg('reviews', 'rating')->withCount('reviews');

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->has('provinsi') && $request->provinsi != '') {
            $query->whereHas('store', function($q) use ($request) {
                $q->where('provinsi', $request->provinsi);
            });
        }

        $products = $query->paginate(12);
        
        $page_title = 'Katalog Menu';
        $page_desc = 'Temukan berbagai hidangan khas nusantara yang lezat dan otentik.';
        
        if ($request->wantsJson()) return response()->json($products);
        return view('products.index', compact('products', 'page_title', 'page_desc'));
    }

    public function diskon(Request $request)
    {
        // Mock diskon logic (menampilkan produk acak atau berdasarkan id tertentu)
        // Di aplikasi riil, tambahkan kolom diskon di tabel produk.
        $products = Product::with(['store', 'category'])->withAvg('reviews', 'rating')->withCount('reviews')->inRandomOrder()->paginate(12);
        
        $page_title = 'Promo & Diskon';
        $page_desc = 'Nikmati berbagai hidangan lezat dengan harga spesial.';
        
        if ($request->wantsJson()) return response()->json($products);
        return view('products.index', compact('products', 'page_title', 'page_desc'));
    }

    public function populer(Request $request)
    {
        // Menampilkan produk yang populer, misalnya dengan mengurutkannya secara acak untuk sementara
        // Di aplikasi riil, bisa diurutkan dari rating atau jumlah pesanan
        $products = Product::with(['store', 'category'])->withAvg('reviews', 'rating')->withCount('reviews')->orderByDesc('reviews_avg_rating')->paginate(12);
        
        $page_title = 'Menu Terpopuler';
        $page_desc = 'Pilihan hidangan favorit pelanggan kami yang paling sering dipesan.';
        
        if ($request->wantsJson()) return response()->json($products);
        return view('products.index', compact('products', 'page_title', 'page_desc'));
    }

    public function show(Request $request, $id)
    {
        $product = Product::with(['store', 'category', 'reviews.user'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($product);
        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $products = Product::with(['store', 'category'])->withAvg('reviews', 'rating')->withCount('reviews')
            ->where('nama_produk', 'LIKE', "%{$keyword}%")
            ->orWhereHas('store', function($q) use ($keyword) {
                $q->where('nama_toko', 'LIKE', "%{$keyword}%");
            })
            ->paginate(12);

        if ($request->wantsJson()) return response()->json($products);
        $page_title = 'Hasil Pencarian: ' . $keyword;
        $page_desc = 'Menampilkan hasil pencarian produk.';
        return view('products.index', compact('products', 'page_title', 'page_desc'));
    }
}
