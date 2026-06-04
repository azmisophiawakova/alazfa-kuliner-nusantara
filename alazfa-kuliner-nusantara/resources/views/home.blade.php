<h1>Beranda (Featured Products)</h1>
<a href="/menu">Lihat Semua Menu</a> | <a href="/penjual">Daftar Toko</a>

@auth
    | <a href="/dashboard">Dashboard ({{ auth()->user()->role }})</a>
    | <form method="POST" action="/logout" style="display:inline;">@csrf<button type="submit" style="background:none; border:none; color:blue; text-decoration:underline; cursor:pointer;">Logout</button></form>
@else
    | <a href="/login">Login</a>
    | Register: <a href="/register/pelanggan">Pelanggan</a> - <a href="/register/penjual">Penjual</a> - <a href="/register/kurir">Kurir</a>
@endauth

<hr>
@if(session('success')) <div style="color:green; font-weight:bold;">{{ session('success') }}</div><br> @endif
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Toko</th><th>Menu</th><th>Kategori</th><th>Harga</th><th>Aksi</th></tr>
    @foreach($featured_products as $p)
    <tr>
        <td>{{ $p->id_produk }}</td>
        <td>{{ $p->store->nama_toko ?? '-' }}</td>
        <td>{{ $p->nama_produk }}</td>
        <td>{{ $p->category->nama_kategori ?? '-' }}</td>
        <td>Rp {{ $p->harga }}</td>
        <td>
            <form method="POST" action="{{ route('cart.store') }}" style="display:inline;">
                @csrf
                <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                <input type="number" name="jumlah" value="1" min="1" style="width:50px;">
                <button type="submit">+ Keranjang</button>
            </form>
            <a href="{{ route('menu.show', $p->id_produk) }}">Detail</a>
        </td>
    </tr>
    @endforeach
</table>
