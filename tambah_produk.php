<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp_name, "assets/" . $gambar);

    $query = "INSERT INTO produk (kode_produk, nama_produk, harga, stok, gambar) VALUES ('$kode_produk', '$nama_produk', '$harga', '$stok', '$gambar')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: data_produk.php");
    } else {
        echo "Gagal menambahkan produk!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Produk</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Kode Produk</label>
                <input type="text" name="kode_produk" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Gambar Produk</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="data_produk.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
