<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2><span class="highlight">TOKO</span> Berkah Selalu</h2>
        <img src="assets/Lova.jpg" alt="Profile" class="profile-img">
        
        <?php if (isset($_GET['error'])): ?>
            <p class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-primary">
                🔑 Login
            </button>
            <button type="reset" class="btn btn-secondary">
                🔄 Reset
            </button>
        </form>
    </div>
</body>
</html>
