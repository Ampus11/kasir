<?php
session_start();
include 'koneksi.php';

// Hapus transaksi
if (isset($_GET['hapus'])) {
    $transaksi_id = $_GET['hapus'];

    // Hapus detail transaksi terlebih dahulu
    $query_hapus_detail = "DELETE FROM detail_transaksi WHERE transaksi_id = '$transaksi_id'";
    mysqli_query($koneksi, $query_hapus_detail);

    // Hapus transaksi
    $query_hapus_transaksi = "DELETE FROM transaksi WHERE id = '$transaksi_id'";
    if (mysqli_query($koneksi, $query_hapus_transaksi)) {
        echo "<script>alert('Transaksi berhasil dihapus!'); window.location='laporan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus transaksi.'); window.location='laporan.php';</script>";
    }
}

// Ambil data transaksi dari database
$query_transaksi = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$result_transaksi = mysqli_query($koneksi, $query_transaksi);

if (!$result_transaksi) {
    die("Error fetching transactions: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Media print untuk tampilan cetak */
        @media print {
            .btn, .container {
                display: none; /* Sembunyikan tombol dan container utama saat cetak */
            }
        }
    </style>
</head>
<?php include 'navbar.php'; ?>
<body>
    <div class="container mt-5">
        <h3>Laporan Transaksi</h3>

        <!-- Tabel Laporan Transaksi -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($transaksi = mysqli_fetch_assoc($result_transaksi)): ?>
                    <tr>
                        <td><?= $transaksi['kode_transaksi']; ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($transaksi['tanggal'])); ?></td>
                        <td>Rp <?= number_format($transaksi['total_harga'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="detail_transaksi.php?id=<?= $transaksi['id']; ?>" class="btn btn-info">Detail</a>
                            <!-- Tombol Hapus -->
                            <a href="?hapus=<?= $transaksi['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tombol Cetak Laporan -->
        <button class="btn btn-success mt-3" onclick="window.print()">Cetak Laporan</button>

        <!-- Tombol Kembali ke Dashboard -->
        <div class="mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
