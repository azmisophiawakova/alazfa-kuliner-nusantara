<?php
$models = [
    'Category' => 'id_kategori',
    'Store' => 'id_toko',
    'Product' => 'id_produk',
    'Cart' => 'id_keranjang',
    'Order' => 'id_pesanan',
    'OrderDetail' => 'id_detail',
    'Payment' => 'id_pembayaran',
    'Review' => 'id_ulasan',
    'Favorite' => 'id_favorit',
    'Notification' => 'id_notifikasi',
    'Verification' => 'id_verifikasi',
    'Monitoring' => 'id_log',
];
foreach($models as $model => $pk) {
    $file = 'app/Models/' . $model . '.php';
    if(file_exists($file)) {
        $content = file_get_contents($file);
        $insert = "\n    protected \$primaryKey = '$pk';\n    protected \$guarded = [];\n";
        $content = preg_replace('/use HasFactory;/', 'use HasFactory;' . $insert, $content);
        file_put_contents($file, $content);
        echo "Updated $model\n";
    }
}
