<?php
session_start();
include 'koneksi.php';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_POST['kode_produk'])) {
    $kode_produk = mysqli_real_escape_string($koneksi, $_POST['kode_produk']);
    $query = "SELECT * FROM produk WHERE kode_produk = '$kode_produk'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $produk = mysqli_fetch_assoc($result);

        // Cek apakah produk sudah ada di keranjang
        if (isset($_SESSION['keranjang'][$produk['id']])) {
            $_SESSION['keranjang'][$produk['id']]['jumlah'] += 1;
            $_SESSION['keranjang'][$produk['id']]['subtotal'] = $_SESSION['keranjang'][$produk['id']]['jumlah'] * $produk['harga'];
        } else {
            $_SESSION['keranjang'][$produk['id']] = [
                'id' => $produk['id'],
                'kode_produk' => $produk['kode_produk'],
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'jumlah' => 1,
                'subtotal' => $produk['harga']
            ];
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'produk' => $_SESSION['keranjang'][$produk['id']]
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan.'
        ]);
    }
}
?>
