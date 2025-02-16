<?php
session_start();

// Inisialisasi session keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Menampilkan pesan error jika ada
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']); // Menghapus pesan setelah ditampilkan
}

// Debugging: Cek isi session keranjang
echo "<pre>";
print_r($_SESSION['keranjang']);
echo "</pre>";
?>
