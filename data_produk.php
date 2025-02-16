<?php
include 'koneksi.php';

// Periksa apakah koneksi ke database berhasil
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Proses hapus produk dan pindahkan ke keranjang
if (isset($_GET['hapus_produk'])) {
    $id_produk = $_GET['hapus_produk'];

    // Ambil data produk berdasarkan id_produk
    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$id_produk'");
    $produk = mysqli_fetch_assoc($query);

    if ($produk) {
        // Tambahkan produk ke dalam keranjang session
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }
        // Cek jika produk sudah ada di keranjang
        $produk_ada = false;
        foreach ($_SESSION['keranjang'] as $item) {
            if ($item['kode_produk'] == $produk['kode_produk']) {
                $produk_ada = true;
                break;
            }
        }

        // Jika produk belum ada di keranjang, tambahkan
        if (!$produk_ada) {
            $_SESSION['keranjang'][] = [
                'id' => $produk['id'],
                'kode_produk' => $produk['kode_produk'],
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'stok' => 1,  // Misalnya menambahkan 1 stok ke keranjang
                'gambar' => $produk['gambar']
            ];
        }

        // Hapus produk dari database
        $delete_query = mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$id_produk'");

        if ($delete_query) {
            $_SESSION['success'] = "Produk berhasil dipindahkan ke keranjang dan dihapus dari database.";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan saat menghapus produk.";
        }
    } else {
        $_SESSION['error'] = "Produk tidak ditemukan.";
    }

    // Redirect ke halaman data produk setelah proses selesai
    header("Location: data_produk.php");
    exit;
}

?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Data Produk</h2>

        <!-- Menampilkan pesan sukses jika produk berhasil dihapus -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Tombol kembali ke dashboard -->
        <a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Kembali ke Dashboard</a>
        <a href="tambah_produk.php" class="btn btn-primary mb-3">+ Tambah Produk</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil semua data produk
                $query = mysqli_query($koneksi, "SELECT * FROM produk");
                $no = 1;

                // Cek apakah ada data produk
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        // Pastikan gambar ada, jika tidak gunakan gambar default
                        $gambar = !empty($row['gambar']) ? "assets/{$row['gambar']}" : "assets/default.jpg";
                        
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['kode_produk']}</td>
                            <td>{$row['nama_produk']}</td>
                            <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                            <td>{$row['stok']}</td>
                            <td><img src='{$gambar}' width='50' alt='Gambar {$row['nama_produk']}'></td>
                            <td>
                                <a href='edit_produk.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='data_produk.php?hapus_produk={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin memindahkan produk ini ke keranjang dan menghapusnya?\")'>Hapus dan Pindah ke Keranjang</a>
                            </td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Data produk masih kosong</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>