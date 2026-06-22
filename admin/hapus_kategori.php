<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id=$_GET['id'];

mysqli_query($koneksi,"
DELETE FROM kategori
WHERE id_kategori='$id'
");

header("Location:kategori.php");
exit;
?>