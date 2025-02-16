<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang masih kosong!'); window.location='transaksi.php';</script>";
    exit();
}

$total_harga = 0;
foreach ($_SESSION['keranjang'] as $produk) {
    $total_harga += $produk['subtotal'];
}

$tanggal = date('Y-m-d H:i:s');

// Buat kode transaksi otomatis berdasarkan ID terakhir
$result = mysqli_query($koneksi, "SELECT MAX(id) AS last_id FROM transaksi");
$row = mysqli_fetch_assoc($result);
$last_id = $row['last_id'] ? $row['last_id'] + 1 : 1;

$kode_transaksi = "TRX-" . date("Ymd") . "-" . str_pad($last_id, 4, "0", STR_PAD_LEFT);

// Simpan transaksi utama ke database
$query_transaksi = "INSERT INTO transaksi (kode_transaksi, total_harga, tanggal) VALUES ('$kode_transaksi', '$total_harga', '$tanggal')";
if (mysqli_query($koneksi, $query_transaksi)) {
    $transaksi_id = mysqli_insert_id($koneksi);

    // Simpan detail transaksi dan kurangi stok
    foreach ($_SESSION['keranjang'] as $produk) {
        $produk_id = mysqli_real_escape_string($koneksi, $produk['id']);
        $jumlah = mysqli_real_escape_string($koneksi, $produk['jumlah']);
        $subtotal = mysqli_real_escape_string($koneksi, $produk['subtotal']);

        // Simpan ke detail_transaksi
        $query_detail = "INSERT INTO detail_transaksi (transaksi_id, produk_id, jumlah, subtotal) 
                         VALUES ('$transaksi_id', '$produk_id', '$jumlah', '$subtotal')";
        mysqli_query($koneksi, $query_detail);

        // Update stok produk
        mysqli_query($koneksi, "UPDATE produk SET stok = stok - $jumlah WHERE id = '$produk_id'");
    }

    // Kosongkan keranjang setelah transaksi sukses
    unset($_SESSION['keranjang']);

    echo "<script>alert('Transaksi Berhasil!'); window.location='transaksi.php';</script>";
} else {
    echo "<script>alert('Gagal menyimpan transaksi.'); window.location='transaksi.php';</script>";
}
?>
