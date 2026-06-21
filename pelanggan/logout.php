<?php

session_start();

/* hapus semua session */
session_unset();

/* hancurkan session */
session_destroy();

/* kembali ke halaman utama */
header("Location: ../index.php");
exit();

?>