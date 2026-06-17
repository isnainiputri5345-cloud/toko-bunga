<?php
session_start();
include "../config/koneksi.php";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi,"
    SELECT * FROM admin
    WHERE username='$username'
    AND password='$password'
    ");

    if(mysqli_num_rows($cek)>0){

        $_SESSION['admin']=true;

        header("Location:dashboard.php");

    }else{

        echo "<script>
        alert('Login gagal');
        window.location='login.php';
        </script>";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Admin</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

<div class="login-box">

<h2>Login Admin</h2>

<form method="POST">

<input type="text"
name="username"
placeholder="Username"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<button name="login">
Masuk
</button>

</form>

</div>

</body>
</html>