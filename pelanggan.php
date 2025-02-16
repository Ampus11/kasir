<?php
include 'koneksi.php';

// Tambah Pelanggan
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $tanggal_daftar = date('Y-m-d');

    $query = "INSERT INTO pelanggan (nama, kontak, tanggal_daftar) VALUES ('$nama', '$kontak', '$tanggal_daftar')";
    mysqli_query($koneksi, $query);
    header("Location: pelanggan.php");
}

// Edit Pelanggan
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];

    $query = "UPDATE pelanggan SET nama='$nama', kontak='$kontak' WHERE id=$id";
    mysqli_query($koneksi, $query);
    header("Location: pelanggan.php");
}

// Hapus Pelanggan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id=$id");
    header("Location: pelanggan.php");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h3>Data Pelanggan</h3>

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Pelanggan</button>

    <!-- Filter Tanggal -->
    <input type="date" id="filterTanggal" class="form-control mb-3" placeholder="Filter berdasarkan tanggal daftar">

    <!-- Tabel Pelanggan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kontak</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>
                    <td>{$row['nama']}</td>
                    <td>{$row['kontak']}</td>
                    <td>{$row['tanggal_daftar']}</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEdit{$row['id']}'>Edit</button>
                        <a href='pelanggan.php?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus pelanggan ini?\")'>Hapus</a>
                        <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modalHistori{$row['id']}'>Lihat Histori</button>
                    </td>
                </tr>";

                // Modal Edit
                echo "<div class='modal fade' id='modalEdit{$row['id']}' tabindex='-1'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Pelanggan</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <form method='POST'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <div class='mb-3'>
                                            <label>Nama</label>
                                            <input type='text' name='nama' class='form-control' value='{$row['nama']}' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label>Kontak</label>
                                            <input type='text' name='kontak' class='form-control' value='{$row['kontak']}' required>
                                        </div>
                                        <button type='submit' name='edit' class='btn btn-primary'>Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                      </div>";

                // Modal Histori
                echo "<div class='modal fade' id='modalHistori{$row['id']}' tabindex='-1'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Histori Transaksi - {$row['nama']}</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Kode Transaksi</th>
                                                <th>Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                $id_pelanggan = $row['id'];
                $histori = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_pelanggan = $id_pelanggan ORDER BY tanggal DESC");
                
                while ($trx = mysqli_fetch_assoc($histori)) {
                    echo "<tr>
                            <td>{$trx['tanggal']}</td>
                            <td>{$trx['kode_transaksi']}</td>
                            <td>Rp " . number_format($trx['total_harga'], 0, ',', '.') . "</td>
                          </tr>";
                }

                echo "      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                      </div>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kontak</label>
                        <input type="text" name="kontak" class="form-control" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
