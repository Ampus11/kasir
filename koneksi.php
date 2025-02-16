<?php
$host = "localhost";
$user = "root"; // Sesuaikan dengan user database kamu
$pass = ""; // Jika ada password, isi di sini
$db = "kasir_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
