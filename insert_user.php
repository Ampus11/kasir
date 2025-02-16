<?php
include 'koneksi.php'; // Koneksi ke database

// Hash password di PHP (bukan di SQL!)
$password1 = password_hash('123456', PASSWORD_DEFAULT);
$password2 = password_hash('password', PASSWORD_DEFAULT);

// Query untuk menambahkan user kasir
$query = "INSERT INTO pengguna (username, password, nama) VALUES 
    ('kasir1', ?, 'Kasir Satu'),
    ('kasir2', ?, 'Kasir Dua')";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $password1, $password2);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "User berhasil ditambahkan!";
} else {
    echo "Gagal menambahkan user: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
