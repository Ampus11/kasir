<?php
session_start();

// Menampilkan error untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cek apakah kode_produk dikirim dan keranjang tidak kosong
if (isset($_GET['kode_produk']) && !empty($_SESSION['keranjang'])) {
    $kode_produk = $_GET['kode_produk'];
    $produk_ditemukan = false;

    foreach ($_SESSION['keranjang'] as $key => $produk) {
        if ($produk['kode_produk'] === $kode_produk) {
            // Hapus produk dari keranjang
            unset($_SESSION['keranjang'][$key]);
            $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // Reset indeks array
            $produk_ditemukan = true;
            break;
        }
    }

    if ($produk_ditemukan) {
        $_SESSION['success'] = "Produk berhasil dihapus.";
        header("Location: keranjang.php");
        exit;
    } else {
        $_SESSION['error'] = "Produk tidak ditemukan di keranjang.";
        header("Location: keranjang.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Keranjang kosong atau terjadi kesalahan.";
    header("Location: keranjang.php");
    exit;
}
?>
