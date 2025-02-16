<?php
session_start();

// Data user yang diperbolehkan masuk (gantilah dengan database nanti)
$users = [
    'kasir1' => '123456',
    'kasir2' => 'password'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username] == $password) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: index.php?error=Username atau password salah!");
        exit();
    }
}
?>
