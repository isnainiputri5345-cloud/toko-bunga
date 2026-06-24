<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "erlisna_florist";

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