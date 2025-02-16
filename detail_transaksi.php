<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    die("Transaksi tidak ditemukan.");
}

$transaksi_id = $_GET['id'];

// Hapus detail transaksi
if (isset($_GET['hapus_detail'])) {
    $detail_id = $_GET['hapus_detail'];

    // Hapus detail transaksi dari tabel detail_transaksi
    $query_hapus_detail = "DELETE FROM detail_transaksi WHERE id = '$detail_id' AND transaksi_id = '$transaksi_id'";
    if (mysqli_query($koneksi, $query_hapus_detail)) {
        echo "<script>alert('Detail transaksi berhasil dihapus!'); window.location='detail_transaksi.php?id=$transaksi_id';</script>";
    } else {
        echo "<script>alert('Gagal menghapus detail transaksi.'); window.location='detail_transaksi.php?id=$transaksi_id';</script>";
    }
}

// Ambil data transaksi
$query_transaksi = "SELECT * FROM transaksi WHERE id = '$transaksi_id'";
$result_transaksi = mysqli_query($koneksi, $query_transaksi);
$transaksi = mysqli_fetch_assoc($result_transaksi);

if (!$transaksi) {
    die("Transaksi tidak ditemukan.");
}

// Ambil detail produk dalam transaksi
$query_detail = "SELECT dt.*, p.nama_produk, p.harga FROM detail_transaksi dt 
                 JOIN produk p ON dt.produk_id = p.id 
                 WHERE dt.transaksi_id = '$transaksi_id'";
$result_detail = mysqli_query($koneksi, $query_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Media print untuk tampilan cetak */
        @media print {
            .btn, .container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3>Detail Transaksi - <?= $transaksi['kode_transaksi']; ?></h3>

        <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($transaksi['tanggal'])); ?></p>
        <p><strong>Total Harga:</strong> Rp <?= number_format($transaksi['total_harga'], 0, ',', '.'); ?></p>

        <h4>Daftar Produk</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = mysqli_fetch_assoc($result_detail)): ?>
                    <tr>
                        <td><?= $detail['nama_produk']; ?></td>
                        <td>Rp <?= number_format($detail['harga'], 0, ',', '.'); ?></td>
                        <td><?= $detail['jumlah']; ?></td>
                        <td>Rp <?= number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                        <td>
                            <!-- Tombol Hapus Detail -->
                            <a href="?hapus_detail=<?= $detail['id']; ?>&id=<?= $transaksi_id; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus detail transaksi ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tombol Cetak Detail Transaksi -->
        <button class="btn btn-success mt-3" onclick="window.print()">Cetak Detail</button>

        <div class="mt-3">
            <a href="laporan.php" class="btn btn-secondary">Kembali ke Laporan</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
