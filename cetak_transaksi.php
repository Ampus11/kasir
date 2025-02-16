<?php
session_start();
include 'koneksi.php';

// Cek jika keranjang ada dan memiliki produk
if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
    $total_harga = 0;
    foreach ($_SESSION['keranjang'] as $produk) {
        // Pastikan setiap produk memiliki data yang diperlukan
        if (isset($produk['nama'], $produk['harga'], $produk['jumlah'], $produk['subtotal'])) {
            $total_harga += $produk['subtotal'];
        }
    }
} else {
    $total_harga = 0; // Jika keranjang kosong
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi</title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .text-center {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #000;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center">Struk Transaksi</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])): ?>
                    <?php foreach ($_SESSION['keranjang'] as $produk): ?>
                        <tr>
                            <td><?= isset($produk['nama']) ? $produk['nama'] : 'Tidak Ditemukan'; ?></td>
                            <td>Rp <?= isset($produk['harga']) ? number_format($produk['harga'], 0, ',', '.') : '0'; ?></td>
                            <td><?= isset($produk['jumlah']) ? $produk['jumlah'] : '0'; ?></td>
                            <td>Rp <?= isset($produk['subtotal']) ? number_format($produk['subtotal'], 0, ',', '.') : '0'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Keranjang Belanja Kosong</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-center total">
            <span>Total Harga: </span>
            <span>Rp <?= number_format($total_harga, 0, ',', '.'); ?></span>
        </div>
    </div>

    <script>
        // Otomatis memanggil print setelah halaman dimuat
        window.print();
    </script>
</body>
</html>
