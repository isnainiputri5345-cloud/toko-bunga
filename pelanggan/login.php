<?php
session_start();
include "../config/koneksi.php";

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = md5($_POST['password']);

$cek = mysqli_query($koneksi,"
SELECT *
FROM pelanggan
WHERE email='$email'
AND password='$password'
");

if(mysqli_num_rows($cek)>0){

$data = mysqli_fetch_assoc($cek);

$_SESSION['id_pelanggan'] = $data['id_pelanggan'];
$_SESSION['nama'] = $data['nama'];

header("Location:../index.php");

}else{

echo "<script>
alert('Email atau Password Salah');
</script>";

}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Pelanggan</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="login-box">

<h2>Login Pelanggan</h2>

<form method="POST">

<input
type="email"
name="email"
placeholder="Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button name="login">
Masuk
</button>

</form>

<p>
Belum punya akun?
<a href="register.php">
Daftar Disini
</a>
</p>

</div>

</body>
</html>