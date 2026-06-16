<?php

$views = [
    // ----------------- PUBLIK & PELANGGAN -----------------
    'resources/views/home.blade.php' => "<h1>Halaman Beranda Publik</h1>\n<a href=\"/menu\">Lihat Menu</a> | <a href=\"/penjual\">Daftar Toko</a> | <a href=\"/login\">Login</a>\n<hr>\n<h3>Data Featured Products:</h3>\n@dump(\$featured_products)",
    'resources/views/sellers/index.blade.php' => "<h1>Daftar Penjual (UMKM)</h1>\n<a href=\"/\">Kembali ke Beranda</a>\n<hr>\n<h3>Data Sellers:</h3>\n@dump(\$sellers)",
    'resources/views/products/index.blade.php' => "<h1>Katalog Menu Kuliner</h1>\n<a href=\"/\">Kembali ke Beranda</a>\n<hr>\n<h3>Data Products:</h3>\n@dump(\$products)",
    'resources/views/products/show.blade.php' => "<h1>Detail Menu Kuliner</h1>\n<a href=\"/menu\">Kembali ke Katalog</a>\n<hr>\n<h3>Data Product:</h3>\n@dump(\$product)",
    'resources/views/cart/index.blade.php' => "<h1>Keranjang Belanja</h1>\n<a href=\"/dashboard\">Dashboard Pelanggan</a>\n<hr>\n<h3>Data Carts:</h3>\n@dump(\$carts)",
    'resources/views/orders/index.blade.php' => "<h1>Riwayat Pesanan Pelanggan</h1>\n<a href=\"/dashboard\">Dashboard Pelanggan</a>\n<hr>\n<h3>Data Orders:</h3>\n@dump(\$orders)",
    'resources/views/orders/show.blade.php' => "<h1>Lacak Status Pesanan</h1>\n<a href=\"/orders\">Kembali ke Riwayat</a>\n<hr>\n<h3>Data Order:</h3>\n@dump(\$order)",
    'resources/views/favorites/index.blade.php' => "<h1>Menu Favorit</h1>\n<a href=\"/dashboard\">Dashboard Pelanggan</a>\n<hr>\n<h3>Data Favorites:</h3>\n@dump(\$favorites)",
    'resources/views/notifications/index.blade.php' => "<h1>Notifikasi Anda</h1>\n<a href=\"/dashboard\">Dashboard Pelanggan</a>\n<hr>\n<h3>Data Notifications:</h3>\n@dump(\$notifications)",

    // ----------------- ADMIN -----------------
    'resources/views/admin/dashboard.blade.php' => "<h1>Dashboard Admin</h1>\n<a href=\"/admin/users\">Kelola User</a> | <a href=\"/admin/stores\">Verifikasi Toko</a> | <form method=\"POST\" action=\"/logout\">@csrf<button>Logout</button></form>\n<hr>\n<h3>Data Statistik:</h3>\n@dump(\$data)",
    'resources/views/admin/users/index.blade.php' => "<h1>Manajemen User</h1>\n<a href=\"/admin/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Users:</h3>\n@dump(\$users)",
    'resources/views/admin/stores/index.blade.php' => "<h1>Verifikasi Toko UMKM</h1>\n<a href=\"/admin/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Stores:</h3>\n@dump(\$stores)",
    'resources/views/admin/categories/index.blade.php' => "<h1>Manajemen Kategori</h1>\n<a href=\"/admin/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Categories:</h3>\n@dump(\$categories)",
    'resources/views/admin/products/index.blade.php' => "<h1>Moderasi Produk/Menu</h1>\n<a href=\"/admin/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Products:</h3>\n@dump(\$products)",
    'resources/views/admin/orders/index.blade.php' => "<h1>Pantau Transaksi</h1>\n<a href=\"/admin/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Orders:</h3>\n@dump(\$orders)",
    'resources/views/admin/orders/show.blade.php' => "<h1>Detail Transaksi</h1>\n<a href=\"/admin/orders\">Kembali</a>\n<hr>\n<h3>Data Order:</h3>\n@dump(\$order)",
    'resources/views/admin/reviews/index.blade.php' => "<h1>Moderasi Ulasan</h1>\n<a href=\"/admin/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Reviews:</h3>\n@dump(\$reviews)",
    'resources/views/admin/reports/index.blade.php' => "<h1>Laporan Pengguna</h1>\n<a href=\"/admin/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Reports:</h3>\n@dump(\$reports)",

    // ----------------- PENJUAL -----------------
    'resources/views/penjual/dashboard.blade.php' => "<h1>Dashboard Penjual (UMKM)</h1>\n<a href=\"/penjual/products\">Kelola Menu</a> | <a href=\"/penjual/orders\">Pesanan Masuk</a> | <form method=\"POST\" action=\"/logout\">@csrf<button>Logout</button></form>\n<hr>\n<h3>Data Statistik Toko:</h3>\n@dump(\$data)",
    'resources/views/penjual/products/index.blade.php' => "<h1>Katalog Menu Toko</h1>\n<a href=\"/penjual/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Products:</h3>\n@dump(\$products)",
    'resources/views/penjual/orders/index.blade.php' => "<h1>Pesanan Masuk</h1>\n<a href=\"/penjual/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Orders:</h3>\n@dump(\$orders)",
    'resources/views/penjual/orders/show.blade.php' => "<h1>Detail Pesanan Masuk</h1>\n<a href=\"/penjual/orders\">Kembali</a>\n<hr>\n<h3>Data Order:</h3>\n@dump(\$order)",
    'resources/views/penjual/store/index.blade.php' => "<h1>Profil Toko</h1>\n<a href=\"/penjual/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Store:</h3>\n@dump(\$store)",
    'resources/views/penjual/reports/index.blade.php' => "<h1>Laporan Penjualan</h1>\n<a href=\"/penjual/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Laporan:</h3>\n@dump(\$data)",

    // ----------------- KURIR -----------------
    'resources/views/kurir/dashboard.blade.php' => "<h1>Dashboard Kurir</h1>\n<a href=\"/kurir/deliveries\">Tugas Pengantaran</a> | <form method=\"POST\" action=\"/logout\">@csrf<button>Logout</button></form>\n<hr>\n<h3>Data Statistik Kurir:</h3>\n@dump(\$data)",
    'resources/views/kurir/deliveries/index.blade.php' => "<h1>Daftar Tugas Pengantaran</h1>\n<a href=\"/kurir/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Pesanan Tersedia:</h3>\n@dump(\$available_orders)\n<hr>\n<h3>Pesanan Sedang Diantar:</h3>\n@dump(\$my_deliveries)",
    'resources/views/kurir/deliveries/history.blade.php' => "<h1>Riwayat Pengantaran</h1>\n<a href=\"/kurir/dashboard\">Kembali ke Dashboard</a>\n<hr>\n<h3>Data Deliveries:</h3>\n@dump(\$deliveries)",
];

foreach ($views as $path => $content) {
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents($path, $content);
    echo "Created $path\n";
}
