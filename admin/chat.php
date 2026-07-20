<?php

session_start();

if(!isset($_SESSION['admin'])){
header("Location:login.php");
exit;
}


include "../config/koneksi.php";



// balas chat

if(isset($_POST['kirim'])){


$id=$_POST['id_pelanggan'];

$pesan=$_POST['pesan'];



mysqli_query($koneksi,


"
INSERT INTO chat

(id_pelanggan,pengirim,pesan)

VALUES

('$id',
'Admin',
'$pesan')

"

);


}



?>


<!DOCTYPE html>
<html>


<head>

<title>
Live Chat Pelanggan
</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

</head>


<body>


<?php include "sidebar.php"; ?>


<div class="content">


<h1>
Live Chat Konsultasi Buket
</h1>



<?php


$pelanggan=mysqli_query($koneksi,


"
SELECT DISTINCT

pelanggan.id_pelanggan,

pelanggan.nama


FROM chat


JOIN pelanggan

ON chat.id_pelanggan=
pelanggan.id_pelanggan

"

);



while($p=mysqli_fetch_assoc($pelanggan)){


?>


<div class="chat-admin">


<h3>

<?= $p['nama']; ?>

</h3>




<?php


$chat=mysqli_query($koneksi,


"
SELECT *

FROM chat

WHERE id_pelanggan='{$p['id_pelanggan']}'

ORDER BY tanggal ASC

"

);



while($c=mysqli_fetch_assoc($chat)){


?>


<p>

<b>
<?= $c['pengirim']; ?>
</b>

:

<?= $c['pesan']; ?>

</p>



<?php } ?>





<form method="POST">


<input type="hidden"
name="id_pelanggan"
value="<?= $p['id_pelanggan']; ?>">



<input type="text"
name="pesan"
placeholder="Balas pelanggan..."
required>


<button name="kirim">

Balas

</button>


</form>


</div>


<hr>


<?php } ?>


</div>


</body>


</html>