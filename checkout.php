<?php

session_start();

if(!isset($_SESSION['id_pelanggan'])){

echo "<script>
alert('Silahkan login terlebih dahulu');
window.location='pelanggan/login.php';
</script>";

exit;
}
?>

<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="checkout-box">

<h1>Checkout Pesanan</h1>

<form action="selesai.php" method="POST">

<input type="text"
name="nama"
placeholder="Nama Lengkap"
required>

<input type="text"
name="telepon"
placeholder="No HP"
required>

<textarea
name="alamat"
placeholder="Alamat Lengkap"
required>
</textarea>

<button type="submit">
Buat Pesanan
</button>

</form>

</div>

</body>
</html>