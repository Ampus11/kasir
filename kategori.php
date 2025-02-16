<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center mb-4">Data Kategori</h2>

    <!-- Tombol Kembali ke Dashboard -->
    <a href="dashboard.php" class="btn btn-dark mb-3">⬅ Kembali ke Dashboard</a>

    <!-- Tombol kategori -->
    <div class="mb-3">
        <a href="kategori.php" class="btn btn-secondary">Semua</a>
        <?php
        $result = mysqli_query($koneksi, "SELECT * FROM kategori");
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <a href="kategori.php?kategori=<?= $row['id']; ?>" class="btn btn-primary">
                <?= htmlspecialchars($row['nama_kategori']); ?>
            </a>
        <?php } ?>
    </div>

    <?php
    $kategori_id = isset($_GET['kategori']) ? intval($_GET['kategori']) : 0;

    // Ambil produk berdasarkan kategori
    if ($kategori_id > 0) {
        $query = "SELECT produk.*, kategori.nama_kategori FROM produk 
                  JOIN kategori ON produk.kategori_id = kategori.id 
                  WHERE kategori_id = $kategori_id";
    } else {
        $query = "SELECT produk.*, kategori.nama_kategori FROM produk 
                  JOIN kategori ON produk.kategori_id = kategori.id";
    }

    $result = mysqli_query($koneksi, $query);
    ?>

    <!-- Table Produk -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['kode_produk']); ?></td>
                                <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td><?= $row['stok']; ?></td>
                                <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center text-danger">Tidak ada produk dalam kategori ini.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
