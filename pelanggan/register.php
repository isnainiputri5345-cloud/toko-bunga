<?php
include "../config/koneksi.php";

if(isset($_POST['daftar'])){

$password = md5($_POST['password']);

mysqli_query($koneksi,"
INSERT INTO pelanggan(
nama,
email,
password,
alamat,
telepon
)
VALUES(
'$_POST[nama]',
'$_POST[email]',
'$password',
'$_POST[alamat]',
'$_POST[telepon]'
)
");

echo "<script>
alert('Registrasi Berhasil');
window.location='login.php';
</script>";
}
?>

<form method="POST">

<h2>Daftar Akun</h2>

<input type="text" name="nama" placeholder="Nama">

<input type="email" name="email" placeholder="Email">

<input type="password" name="password" placeholder="Password">

<input type="text" name="telepon" placeholder="Telepon">

<textarea name="alamat"></textarea>

<button name="daftar">
Daftar
</button>

</form>