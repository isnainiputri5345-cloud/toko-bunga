<?php
session_start();
include "../config/koneksi.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $cek = mysqli_query($koneksi, "
        SELECT * FROM admin
        WHERE username='$username'
        LIMIT 1
    ");

    if ($cek && mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        $passwordDb = $data['password'];

        if ($passwordDb === md5($password) || $passwordDb === $password) {
            $_SESSION['admin'] = true;
            $_SESSION['admin_username'] = $data['username'];

            header("Location: dashboard.php");
            exit;
        }
    }

    echo "<script>alert('Login Gagal');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<div class="login-admin">
<h1>ERLISNA FLORIST</h1>
<h3>Admin Login</h3>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Masuk</button>
</form>
</div>
</body>
</html>