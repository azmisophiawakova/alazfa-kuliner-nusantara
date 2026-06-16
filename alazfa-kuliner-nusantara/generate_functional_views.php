<?php

$views = [
    // ==========================================
    // GLOBAL & PELANGGAN
    // ==========================================
    'resources/views/home.blade.php' => "
<h1>Beranda (Featured Products)</h1>
<a href=\"/menu\">Lihat Semua Menu</a> | <a href=\"/penjual\">Daftar Toko</a> | <a href=\"/login\">Login</a> | <a href=\"/dashboard\">Dashboard User</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif
<table border=\"1\" cellpadding=\"5\">
    <tr><th>ID</th><th>Toko</th><th>Menu</th><th>Kategori</th><th>Harga</th><th>Aksi</th></tr>
    @foreach(\$featured_products as \$p)
    <tr>
        <td>{{ \$p->id_produk }}</td>
        <td>{{ \$p->store->nama_toko ?? '-' }}</td>
        <td>{{ \$p->nama_produk }}</td>
        <td>{{ \$p->category->nama_kategori ?? '-' }}</td>
        <td>Rp {{ \$p->harga }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('cart.store') }}\" style=\"display:inline;\">
                @csrf
                <input type=\"hidden\" name=\"id_produk\" value=\"{{ \$p->id_produk }}\">
                <input type=\"number\" name=\"jumlah\" value=\"1\" min=\"1\" style=\"width:50px;\">
                <button type=\"submit\">+ Keranjang</button>
            </form>
            <a href=\"{{ route('menu.show', \$p->id_produk) }}\">Detail</a>
        </td>
    </tr>
    @endforeach
</table>
",
    'resources/views/products/index.blade.php' => "
<h1>Katalog Menu</h1>
<a href=\"/\">Kembali</a> | <a href=\"/cart\">Lihat Keranjang</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Menu</th><th>Toko</th><th>Harga</th><th>Aksi</th></tr>
    @foreach(\$products as \$p)
    <tr>
        <td>{{ \$p->nama_produk }}</td>
        <td>{{ \$p->store->nama_toko ?? '-' }}</td>
        <td>Rp {{ \$p->harga }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('cart.store') }}\" style=\"display:inline;\">
                @csrf
                <input type=\"hidden\" name=\"id_produk\" value=\"{{ \$p->id_produk }}\">
                <input type=\"number\" name=\"jumlah\" value=\"1\" min=\"1\" style=\"width:50px;\">
                <button type=\"submit\">+ Keranjang</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
",
    'resources/views/cart/index.blade.php' => "
<h1>Keranjang Belanja</h1>
<a href=\"/dashboard\">Dashboard</a> | <a href=\"/menu\">Lanjut Belanja</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif
@if(session('error')) <div style=\"color:red; font-weight:bold;\">{{ session('error') }}</div><br> @endif

<table border=\"1\" cellpadding=\"5\">
    <tr><th>Menu</th><th>Toko</th><th>Harga Satuan</th><th>Jumlah</th><th>Total</th><th>Aksi</th></tr>
    @php \$grandTotal = 0; @endphp
    @foreach(\$carts as \$c)
    @php \$total = \$c->product->harga * \$c->jumlah; \$grandTotal += \$total; @endphp
    <tr>
        <td>{{ \$c->product->nama_produk }}</td>
        <td>{{ \$c->product->store->nama_toko ?? '-' }}</td>
        <td>Rp {{ \$c->product->harga }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('cart.update', \$c->id_keranjang) }}\" style=\"display:inline;\">
                @csrf @method('PUT')
                <input type=\"number\" name=\"jumlah\" value=\"{{ \$c->jumlah }}\" min=\"1\" style=\"width:50px;\">
                <button type=\"submit\">Update</button>
            </form>
        </td>
        <td>Rp {{ \$total }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('cart.destroy', \$c->id_keranjang) }}\" style=\"display:inline;\">
                @csrf @method('DELETE')
                <button type=\"submit\">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<h3>Grand Total: Rp {{ \$grandTotal }}</h3>
<form method=\"POST\" action=\"{{ route('orders.store') }}\">
    @csrf
    <div style=\"margin-bottom: 15px;\">
        <label for=\"metode_pembayaran\"><strong>Pilih Metode Pembayaran:</strong></label><br>
        <select name=\"metode_pembayaran\" id=\"metode_pembayaran\" required style=\"padding: 5px; font-size: 16px;\">
            <option value=\"COD\">Cash On Delivery (COD)</option>
            <option value=\"Dana\">Dana</option>
            <option value=\"GoPay\">GoPay</option>
            <option value=\"ShopeePay\">ShopeePay</option>
            <option value=\"OVO\">OVO</option>
        </select>
    </div>
    <button type=\"submit\" style=\"font-size:20px; font-weight:bold; background:yellow; padding: 10px 20px; cursor: pointer;\">CHECKOUT SEKARANG</button>
</form>
",
    'resources/views/orders/index.blade.php' => "
<h1>Riwayat Pesanan Pelanggan</h1>
<a href=\"/dashboard\">Dashboard</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif
<table border=\"1\" cellpadding=\"5\">
    <tr><th>ID Pesanan</th><th>Toko</th><th>Total Harga</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
    @foreach(\$orders as \$o)
    <tr>
        <td>#{{ \$o->id_pesanan }}</td>
        <td>{{ \$o->store->nama_toko ?? '-' }}</td>
        <td>Rp {{ \$o->total_harga }}</td>
        <td><strong>{{ strtoupper(\$o->status_pesanan) }}</strong></td>
        <td>{{ \$o->created_at }}</td>
        <td>
            <a href=\"{{ route('orders.show', \$o->id_pesanan) }}\">Detail</a>
        </td>
    </tr>
    @endforeach
</table>
",
    'resources/views/orders/show.blade.php' => "
<h1>Detail Pesanan #{{ \$order->id_pesanan }}</h1>
<a href=\"/orders\">Kembali ke Riwayat</a>
<hr>
<p>Status: <strong>{{ strtoupper(\$order->status_pesanan) }}</strong></p>
<p>Toko: {{ \$order->store->nama_toko ?? '-' }}</p>
<p>Kurir: {{ \$order->kurir->name ?? 'Belum ada kurir' }}</p>

<h3>Item Pesanan:</h3>
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Menu</th><th>Harga</th><th>Jumlah</th><th>Total</th></tr>
    @foreach(\$order->orderDetails as \$d)
    <tr>
         <td>{{ \$d->product->nama_produk }}</td>
         <td>Rp {{ \$d->harga }}</td>
         <td>{{ \$d->jumlah }}</td>
         <td>Rp {{ \$d->subtotal }}</td>
    </tr>
    @endforeach
</table>
<h3>Total Bayar: Rp {{ \$order->total_harga }}</h3>
",

    // ==========================================
    // ADMIN
    // ==========================================
    'resources/views/admin/dashboard.blade.php' => "
<h1>Dashboard Admin</h1>
<a href=\"/admin/users\">Manajemen User</a> | <a href=\"/admin/stores\">Verifikasi Toko</a> | <a href=\"/admin/categories\">Kategori</a>
| <form method=\"POST\" action=\"/logout\" style=\"display:inline;\">@csrf<button>Logout</button></form>
<hr>
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Total Users</th><td>{{ \$data['total_users'] }}</td></tr>
    <tr><th>Total Toko</th><td>{{ \$data['total_stores'] }}</td></tr>
    <tr><th>Total Produk</th><td>{{ \$data['total_products'] }}</td></tr>
    <tr><th>Total Transaksi</th><td>{{ \$data['total_orders'] }}</td></tr>
</table>
",
    'resources/views/admin/stores/index.blade.php' => "
<h1>Verifikasi Toko</h1>
<a href=\"/admin/dashboard\">Dashboard</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Toko</th><th>Pemilik</th><th>Status Saat Ini</th><th>Aksi Verifikasi</th></tr>
    @foreach(\$stores as \$s)
    <tr>
        <td>{{ \$s->nama_toko }}</td>
        <td>{{ \$s->user->name ?? '-' }}</td>
        <td>{{ \$s->status_verifikasi }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('admin.stores.verify', \$s->id_toko) }}\" style=\"display:inline;\">
                @csrf
                <input type=\"hidden\" name=\"status\" value=\"terverifikasi\">
                <button type=\"submit\">Setujui</button>
            </form>
            <form method=\"POST\" action=\"{{ route('admin.stores.verify', \$s->id_toko) }}\" style=\"display:inline;\">
                @csrf
                <input type=\"hidden\" name=\"status\" value=\"ditolak\">
                <button type=\"submit\">Tolak</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
",
    'resources/views/admin/categories/index.blade.php' => "
<h1>Manajemen Kategori</h1>
<a href=\"/admin/dashboard\">Dashboard</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif

<h3>Tambah Kategori Baru:</h3>
<form method=\"POST\" action=\"{{ route('admin.categories.store') }}\">
    @csrf
    <input type=\"text\" name=\"nama_kategori\" placeholder=\"Nama Kategori\" required>
    <input type=\"text\" name=\"deskripsi\" placeholder=\"Deskripsi\">
    <button type=\"submit\">Tambah</button>
</form>
<br>
<table border=\"1\" cellpadding=\"5\">
    <tr><th>ID</th><th>Kategori</th><th>Deskripsi</th><th>Aksi</th></tr>
    @foreach(\$categories as \$c)
    <tr>
        <td>{{ \$c->id_kategori }}</td>
        <td>{{ \$c->nama_kategori }}</td>
        <td>{{ \$c->deskripsi }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('admin.categories.destroy', \$c->id_kategori) }}\" style=\"display:inline;\">
                @csrf @method('DELETE')
                <button type=\"submit\">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
",

    // ==========================================
    // PENJUAL
    // ==========================================
    'resources/views/penjual/dashboard.blade.php' => "
<h1>Dashboard Penjual</h1>
<a href=\"/penjual/products\">Kelola Menu</a> | <a href=\"/penjual/orders\">Pesanan Masuk</a> | <a href=\"/penjual/store\">Profil Toko</a>
| <form method=\"POST\" action=\"/logout\" style=\"display:inline;\">@csrf<button>Logout</button></form>
<hr>
<h3>Toko Anda: {{ \$data['store']->nama_toko ?? 'Belum ada' }}</h3>
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Total Produk</th><td>{{ \$data['total_products'] }}</td></tr>
    <tr><th>Total Pesanan Masuk</th><td>{{ \$data['total_orders'] }}</td></tr>
    <tr><th>Pesanan Menunggu</th><td>{{ \$data['pending_orders'] }}</td></tr>
</table>
",
    'resources/views/penjual/products/index.blade.php' => "
<h1>Katalog Menu Toko</h1>
<a href=\"/penjual/dashboard\">Dashboard</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif

<h3>Tambah Menu Baru:</h3>
<form method=\"POST\" action=\"{{ route('penjual.products.store') }}\" enctype=\"multipart/form-data\">
    @csrf
    <input type=\"number\" name=\"id_kategori\" placeholder=\"ID Kategori (1/2/3)\" required> <br><br>
    <input type=\"text\" name=\"nama_produk\" placeholder=\"Nama Menu\" required> <br><br>
    <input type=\"number\" name=\"harga\" placeholder=\"Harga\" required> <br><br>
    <input type=\"number\" name=\"stok\" placeholder=\"Stok\" required> <br><br>
    <textarea name=\"deskripsi_produk\" placeholder=\"Deskripsi\"></textarea> <br><br>
    <textarea name=\"resep\" placeholder=\"Resep Makanan / Detail Kuliner\"></textarea> <br><br>
    <input type=\"file\" name=\"foto_produk\"> <br><br>
    <button type=\"submit\">Simpan Produk</button>
</form>
<br>

<table border=\"1\" cellpadding=\"5\">
    <tr><th>Menu</th><th>Harga</th><th>Stok</th><th>Kategori</th><th>Aksi</th></tr>
    @foreach(\$products as \$p)
    <tr>
        <td>{{ \$p->nama_produk }}</td>
        <td>Rp {{ \$p->harga }}</td>
        <td>{{ \$p->stok }}</td>
        <td>{{ \$p->category->nama_kategori ?? '-' }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('penjual.products.destroy', \$p->id_produk) }}\" style=\"display:inline;\">
                @csrf @method('DELETE')
                <button type=\"submit\">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
",
    'resources/views/penjual/orders/index.blade.php' => "
<h1>Pesanan Masuk</h1>
<a href=\"/penjual/dashboard\">Dashboard</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif

<table border=\"1\" cellpadding=\"5\">
    <tr><th>ID Pesanan</th><th>Pelanggan</th><th>Total Bayar</th><th>Status Saat Ini</th><th>Ubah Status</th></tr>
    @foreach(\$orders as \$o)
    <tr>
        <td>#{{ \$o->id_pesanan }}</td>
        <td>{{ \$o->user->name ?? '-' }}</td>
        <td>Rp {{ \$o->total_harga }}</td>
        <td><strong>{{ strtoupper(\$o->status_pesanan) }}</strong></td>
        <td>
            <form method=\"POST\" action=\"{{ route('penjual.orders.status', \$o->id_pesanan) }}\">
                @csrf
                <select name=\"status_pesanan\">
                    <option value=\"menunggu\">Menunggu</option>
                    <option value=\"diproses\">Diproses</option>
                    <option value=\"dikirim\">Diserahkan Kurir</option>
                    <option value=\"dibatalkan\">Batal</option>
                </select>
                <button type=\"submit\">Update</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
",

    // ==========================================
    // KURIR
    // ==========================================
    'resources/views/kurir/dashboard.blade.php' => "
<h1>Dashboard Kurir</h1>
<a href=\"/kurir/deliveries\">Tugas Pengantaran</a>
| <form method=\"POST\" action=\"/logout\" style=\"display:inline;\">@csrf<button>Logout</button></form>
<hr>
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Tugas Baru Tersedia</th><td>{{ \$data['new_tasks'] }}</td></tr>
    <tr><th>Tugas Sedang Diantar</th><td>{{ \$data['active_deliveries'] }}</td></tr>
    <tr><th>Tugas Selesai</th><td>{{ \$data['completed_deliveries'] }}</td></tr>
</table>
",
    'resources/views/kurir/deliveries/index.blade.php' => "
<h1>Tugas Pengantaran</h1>
<a href=\"/kurir/dashboard\">Dashboard</a>
<hr>
@if(session('success')) <div style=\"color:green; font-weight:bold;\">{{ session('success') }}</div><br> @endif

<h3>Daftar Pesanan Tersedia (Menunggu Kurir):</h3>
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Toko</th><th>Pelanggan</th><th>Aksi</th></tr>
    @foreach(\$available_orders as \$o)
    <tr>
        <td>{{ \$o->store->nama_toko ?? '-' }}</td>
        <td>{{ \$o->user->name ?? '-' }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('kurir.deliveries.accept', \$o->id_pesanan) }}\">
                @csrf
                <button type=\"submit\">Ambil Tugas Ini</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<hr>
<h3>Tugas Saya (Sedang Diantar):</h3>
<table border=\"1\" cellpadding=\"5\">
    <tr><th>Toko</th><th>Pelanggan</th><th>Status Saat Ini</th><th>Update Status</th></tr>
    @foreach(\$my_deliveries as \$o)
    <tr>
        <td>{{ \$o->store->nama_toko ?? '-' }}</td>
        <td>{{ \$o->user->name ?? '-' }}</td>
        <td>{{ strtoupper(\$o->status_pesanan) }}</td>
        <td>
            <form method=\"POST\" action=\"{{ route('kurir.deliveries.status', \$o->id_pesanan) }}\">
                @csrf
                <select name=\"status_pesanan\">
                    <option value=\"dikirim\">Sedang Di Perjalanan (Dikirim)</option>
                    <option value=\"selesai\">Pesanan Selesai / Sampai</option>
                </select>
                <button type=\"submit\">Update</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
",
];

foreach ($views as $path => $content) {
    file_put_contents($path, $content);
    echo "Updated $path\n";
}
