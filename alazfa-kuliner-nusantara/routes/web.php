<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================================
// RUTE PUBLIK (Bisa diakses Guest)
// ==========================================
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/penjual', [\App\Http\Controllers\HomeController::class, 'sellers'])->name('sellers.index');
Route::get('/toko/{id}', [\App\Http\Controllers\HomeController::class, 'showSeller'])->name('sellers.show');

Route::get('/menu', [\App\Http\Controllers\ProductController::class, 'index'])->name('menu.index');
Route::get('/menu/search', [\App\Http\Controllers\ProductController::class, 'search'])->name('menu.search');
Route::get('/menu/diskon', [\App\Http\Controllers\ProductController::class, 'diskon'])->name('menu.diskon');
Route::get('/menu/populer', [\App\Http\Controllers\ProductController::class, 'populer'])->name('menu.populer');
Route::get('/menu/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('menu.show');


// ==========================================
// RUTE SETELAH LOGIN UMUM (Breeze)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifikasi (Semua Role)
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Laporan Umum (Bisa diakses Pelanggan, Penjual, Kurir)
    Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
});


// ==========================================
// ROUTE DASHBOARD (PENGARAHAN BERDASARKAN ROLE)
// ==========================================
Route::middleware('auth')->get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'penjual') return redirect()->route('penjual.dashboard');
    if ($role === 'kurir') return redirect()->route('kurir.dashboard');
    
    // Default: pelanggan
    return redirect()->route('pelanggan.dashboard');
})->name('dashboard');

// ==========================================
// RUTE PELANGGAN
// ==========================================
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', [\App\Http\Controllers\HomeController::class, 'pelangganDashboard'])->name('pelanggan.dashboard');
    
    // Keranjang
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    // Pesanan
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/payment', [\App\Http\Controllers\OrderController::class, 'uploadPayment'])->name('orders.payment');

    // Favorit
    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites', [\App\Http\Controllers\FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [\App\Http\Controllers\FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Ulasan
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');


});


// ==========================================
// RUTE PENJUAL (UMKM)
// ==========================================
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Penjual\DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Menu
    Route::resource('products', \App\Http\Controllers\Penjual\ProductController::class);

    // Manajemen Pesanan
    Route::get('/orders', [\App\Http\Controllers\Penjual\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Penjual\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [\App\Http\Controllers\Penjual\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{id}/payment', [\App\Http\Controllers\Penjual\OrderController::class, 'verifyPayment'])->name('orders.payment');
    Route::get('/orders/{id}/receipt', [\App\Http\Controllers\Penjual\OrderController::class, 'printReceipt'])->name('orders.receipt');

    // Profil Toko
    Route::get('/store', [\App\Http\Controllers\Penjual\StoreController::class, 'index'])->name('store.index');
    Route::get('/store/edit', [\App\Http\Controllers\Penjual\StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [\App\Http\Controllers\Penjual\StoreController::class, 'update'])->name('store.update');

    // Wallet / Saldo
    Route::get('/withdraw', [\App\Http\Controllers\WalletController::class, 'withdrawForm'])->name('withdraw');
    Route::post('/withdraw', [\App\Http\Controllers\WalletController::class, 'storeWithdraw'])->name('withdraw.store');

    // Laporan
    Route::get('/reports', [\App\Http\Controllers\Penjual\ReportController::class, 'index'])->name('reports.index');
});


// ==========================================
// RUTE KURIR
// ==========================================
Route::middleware(['auth', 'role:kurir'])->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Kurir\DashboardController::class, 'index'])->name('dashboard');
    
    // Pengantaran
    Route::get('/deliveries', [\App\Http\Controllers\Kurir\DeliveryController::class, 'index'])->name('deliveries.index');
    Route::post('/deliveries/{id}/accept', [\App\Http\Controllers\Kurir\DeliveryController::class, 'accept'])->name('deliveries.accept');
    Route::post('/deliveries/{id}/reject', [\App\Http\Controllers\Kurir\DeliveryController::class, 'reject'])->name('deliveries.reject');
    Route::post('/deliveries/{id}/status', [\App\Http\Controllers\Kurir\DeliveryController::class, 'updateStatus'])->name('deliveries.status');
    Route::get('/deliveries/history', [\App\Http\Controllers\Kurir\DeliveryController::class, 'history'])->name('deliveries.history');

    // Wallet / Saldo
    Route::get('/withdraw', [\App\Http\Controllers\WalletController::class, 'withdrawForm'])->name('withdraw');
    Route::post('/withdraw', [\App\Http\Controllers\WalletController::class, 'storeWithdraw'])->name('withdraw.store');
});


// ==========================================
// RUTE ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // User
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/status', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('users.status');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Verifikasi Toko
    Route::get('/stores', [\App\Http\Controllers\Admin\StoreController::class, 'index'])->name('stores.index');
    Route::post('/stores/{id}/verify', [\App\Http\Controllers\Admin\StoreController::class, 'verify'])->name('stores.verify');

    // Kategori
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['create', 'show', 'edit']);

    // Menu / Produk
    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Transaksi & Laporan
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/{id}/resolve', [\App\Http\Controllers\Admin\ReportController::class, 'resolve'])->name('reports.resolve');

    // Laporan Sistem
    Route::get('/system-reports', [\App\Http\Controllers\Admin\SystemReportController::class, 'index'])->name('system-reports.index');

    // Pengaturan
    Route::post('/settings/qris', [\App\Http\Controllers\Admin\DashboardController::class, 'updateQris'])->name('settings.qris');

    // Penarikan Dana
    Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{id}/status', [\App\Http\Controllers\Admin\WithdrawalController::class, 'update'])->name('withdrawals.update');
});

require __DIR__.'/auth.php';
