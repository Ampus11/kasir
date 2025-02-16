<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
    $row = mysqli_fetch_assoc($query);
}

if (isset($_POST['update'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Cek apakah ada file gambar yang diupload
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $folder = "assets/";

        // Pindahkan gambar ke folder assets
        move_uploaded_file($tmp_name, $folder.$gambar);

        // Update database dengan gambar baru
        mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok', gambar='$gambar' WHERE id=$id");
    } else {
        // Update database tanpa mengubah gambar
        mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok' WHERE id=$id");
    }

    header("Location: data_produk.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Produk</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?php echo $row['nama_produk']; ?>" required>
            
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?php echo $row['harga']; ?>" required>
            
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="<?php echo $row['stok']; ?>" required>
            
            <label>Gambar Produk</label>
            <input type="file" name="gambar" class="form-control">
            <p>Gambar Saat Ini:</p>
            <img src="assets/<?php echo $row['gambar']; ?>" width="100">

            <button type="submit" name="update" class="btn btn-primary mt-3">Simpan Perubahan</button>
            <a href="data_produk.php" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</body>
</html>
