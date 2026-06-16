<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Users (4 Role)
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@alazfa.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'alamat' => 'Kantor Pusat Alazfa',
            'role' => 'admin',
            'status_akun' => 'aktif',
        ]);

        $penjual = User::create([
            'name' => 'Bapak Budi (Penjual)',
            'email' => 'penjual@alazfa.com',
            'password' => Hash::make('password'),
            'no_hp' => '081298765432',
            'alamat' => 'Jl. Kuliner Nusantara No. 1',
            'role' => 'penjual',
            'status_akun' => 'aktif',
        ]);

        $kurir = User::create([
            'name' => 'Andi (Kurir)',
            'email' => 'kurir@alazfa.com',
            'password' => Hash::make('password'),
            'no_hp' => '081311112222',
            'alamat' => 'Jl. Cepat Sampai No. 9',
            'role' => 'kurir',
            'status_akun' => 'aktif',
        ]);

        $pelanggan = User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'pelanggan@alazfa.com',
            'password' => Hash::make('password'),
            'no_hp' => '081255556666',
            'alamat' => 'Jl. Rumah Nyaman No. 5',
            'role' => 'pelanggan',
            'status_akun' => 'aktif',
        ]);

        // 2. Buat Toko untuk Penjual
        $store = Store::create([
            'id_user' => $penjual->id,
            'nama_toko' => 'Warung Nasi Padang Bundo',
            'alamat_toko' => 'Jl. Minangkabau No. 12',
            'deskripsi_toko' => 'Menyediakan masakan khas Padang asli dengan bumbu rempah pilihan.',
            'status_verifikasi' => 'disetujui',
        ]);

        // 3. Buat Kategori Kuliner
        $kategori_makanan = Category::create([
            'nama_kategori' => 'Makanan Berat',
            'deskripsi' => 'Aneka masakan tradisional mengenyangkan',
        ]);

        $kategori_minuman = Category::create([
            'nama_kategori' => 'Minuman Tradisional',
            'deskripsi' => 'Minuman segar dan menyehatkan',
        ]);

        $kategori_jajanan = Category::create([
            'nama_kategori' => 'Jajanan Pasar',
            'deskripsi' => 'Kue dan camilan tradisional',
        ]);

        // 4. Buat Produk / Menu
        Product::create([
            'id_toko' => $store->id_toko,
            'id_kategori' => $kategori_makanan->id_kategori,
            'nama_produk' => 'Rendang Sapi',
            'deskripsi_produk' => 'Rendang sapi empuk dengan bumbu meresap hasil dimasak 8 jam.',
            'resep' => 'Daging sapi segar, santan kelapa murni, cabai, bawang merah, bawang putih, lengkuas, serai, daun jeruk.',
            'harga' => 25000,
            'stok' => 50,
            'foto_produk' => null,
        ]);

        Product::create([
            'id_toko' => $store->id_toko,
            'id_kategori' => $kategori_makanan->id_kategori,
            'nama_produk' => 'Sate Padang Pariaman',
            'deskripsi_produk' => 'Sate daging dan lidah sapi dengan kuah kental pedas khas Pariaman.',
            'resep' => 'Daging sapi, tepung beras, cabai giling, ketumbar, jintan, kunyit.',
            'harga' => 20000,
            'stok' => 30,
            'foto_produk' => null,
        ]);

        Product::create([
            'id_toko' => $store->id_toko,
            'id_kategori' => $kategori_minuman->id_kategori,
            'nama_produk' => 'Es Tebak',
            'deskripsi_produk' => 'Es campur khas Minang dengan isian tebak (olahan tepung beras).',
            'resep' => 'Tebak, cincau hitam, kolang-kaling, tape singkong, sirup merah, susu kental manis, es serut.',
            'harga' => 12000,
            'stok' => 100,
            'foto_produk' => null,
        ]);
        
        echo "Database Berhasil di Seed! \n";
    }
}
