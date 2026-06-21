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
alert('Login Gagal');
</script>";

}
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>

<div class="login-admin">

<h1>ERLISNA FLORIST</h1>

<h3>Admin Login</h3>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button
name="login">

Masuk

</button>

</form>

</div>

</body>
</html>