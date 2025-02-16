<?php
include 'koneksi.php';

// Ambil data pengaturan
$query = mysqli_query($koneksi, "SELECT * FROM pengaturan LIMIT 1");
$data = mysqli_fetch_assoc($query);

// Update Pengaturan
if (isset($_POST['update'])) {
    $nama_toko = $_POST['nama_toko'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $logo = $data['logo']; // Default logo lama

    // Cek jika ada upload logo baru
    if ($_FILES['logo']['name'] != '') {
        $target_dir = "uploads/";
        $logo = $target_dir . basename($_FILES["logo"]["name"]);
        move_uploaded_file($_FILES["logo"]["tmp_name"], $logo);
    }

    // Update database
    $update_query = "UPDATE pengaturan SET 
                     nama_toko='$nama_toko', 
                     logo='$logo', 
                     alamat='$alamat', 
                     kontak='$kontak' 
                     WHERE id=1";
    mysqli_query($koneksi, $update_query);
    header("Location: pengaturan.php");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Toko</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h3>Pengaturan Toko</h3>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Toko</label>
            <input type="text" name="nama_toko" class="form-control" value="<?= $data['nama_toko'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Logo Toko</label>
            <input type="file" name="logo" class="form-control">
            <?php if ($data['logo']) { ?>
                <img src="<?= $data['logo'] ?>" class="mt-2" style="max-width: 150px;">
            <?php } ?>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required><?= $data['alamat'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="kontak" class="form-control" value="<?= $data['kontak'] ?>" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Simpan Pengaturan</button>
        <div class="mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
