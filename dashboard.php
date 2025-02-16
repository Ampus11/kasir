<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="main-content">
    <div class="container mt-4">
        <h3>Selamat Datang di Sistem Kasir</h3>
        
        <div class="row">
            <!-- Total Produk -->
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>Total Produk</h5>
                        <?php 
                            $result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM produk");
                            $data = mysqli_fetch_assoc($result);
                            echo "<h3>" . ($data['total'] ?? 0) . "</h3>"; // Jika NULL, tampilkan 0
                        ?>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Total Transaksi</h5>
                        <?php 
                            $result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM transaksi");
                            $data = mysqli_fetch_assoc($result);
                            echo "<h3>" . ($data['total'] ?? 0) . "</h3>";
                        ?>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Hari Ini -->
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Pendapatan Hari Ini</h5>
                        <?php 
                            $result = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total FROM transaksi WHERE DATE(tanggal) = CURDATE()");
                            $data = mysqli_fetch_assoc($result);
                            $total_pendapatan = $data['total'] ?? 0; // Default jika NULL
                            echo "<h3>Rp " . number_format($total_pendapatan, 0, ',', '.') . "</h3>";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terbaru -->
        <div class="mt-4">
            <h4>Produk Terbaru</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC LIMIT 5");
                    if(mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['kode_produk']}</td>
                                    <td>{$row['nama_produk']}</td>
                                    <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>Tidak ada produk terbaru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="mt-4">
            <h4>Transaksi Terbaru</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY id DESC LIMIT 5");
                    if(mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['kode_transaksi']}</td>
                                    <td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                                    <td>{$row['tanggal']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>Tidak ada transaksi terbaru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
