<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "toko_bunga";

$koneksi = mysqli_connect(
$host,
$user,
$pass,
$db
);

if(!$koneksi){
    die("Koneksi gagal");
}
?>