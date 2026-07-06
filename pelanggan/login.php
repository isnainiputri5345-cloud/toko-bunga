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
<link rel="stylesheet" href="../assets/css/admin.css">
<style>
.login-admin {
    width: 450px;
    background: white;
    padding: 40px;
    margin: 50px auto;
    border-radius: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,.1);
    text-align: center;
}

.login-admin h1 {
    color: #ff4fa3;
    margin-bottom: 10px;
    font-size: 28px;
}

.login-admin h3 {
    color: #666;
    margin-bottom: 30px;
    font-weight: 400;
}

.login-admin input {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: Segoe UI;
    font-size: 14px;
    box-sizing: border-box;
}

.login-admin input:focus {
    outline: none;
    border-color: #ff4fa3;
    box-shadow: 0 0 5px rgba(255, 79, 163, 0.3);
}

.login-admin button {
    width: 100%;
    padding: 12px;
    background: #ff4fa3;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 15px;
    transition: background 0.3s ease;
}

.login-admin button:hover {
    background: #ff2c91;
}

.login-admin .login-link {
    margin-top: 20px;
    font-size: 14px;
    color: #666;
}

.login-admin .login-link a {
    color: #ff4fa3;
    text-decoration: none;
    font-weight: bold;
}

.login-admin .login-link a:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<div class="login-admin">
    <h1>ERLISNA FLORIST</h1>
    <h3>Login Pelanggan</h3>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login" type="submit">Masuk</button>
        <div class="login-link">
            Belum punya akun? <a href="register.php">Daftar Disini</a>
        </div>
    </form>
</div>

</body>
</html>