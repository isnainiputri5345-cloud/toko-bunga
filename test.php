<?php

$koneksi = mysqli_connect("localhost","root","","toko_bunga");

if($koneksi){
    echo "Koneksi Berhasil";
}else{
    echo mysqli_connect_error();
}

?>