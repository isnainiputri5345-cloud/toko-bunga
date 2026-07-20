<?php

session_start();

include "../config/koneksi.php";


if(!isset($_SESSION['pelanggan'])){
header("Location:login.php");
exit;
}


$id_pelanggan=$_SESSION['pelanggan'];



// kirim pesan

if(isset($_POST['kirim'])){


$pesan=$_POST['pesan'];


mysqli_query($koneksi,

"
INSERT INTO chat

(id_pelanggan,pengirim,pesan)

VALUES

('$id_pelanggan',
'Pelanggan',
'$pesan')

"

);


}


?>


<!DOCTYPE html>
<html>

<head>

<title>
Konsultasi Buket
</title>

<link rel="stylesheet"
href="../assets/css/style.css">

</head>


<body>



<h2>
💐 Konsultasi Buket Erlisna Florist
</h2>



<div class="chat-box">


<?php


$data=mysqli_query($koneksi,


"
SELECT *

FROM chat

WHERE id_pelanggan='$id_pelanggan'

ORDER BY tanggal ASC

"

);



while($c=mysqli_fetch_assoc($data)){


?>


<p>

<b>
<?= $c['pengirim']; ?>
</b>

:

<?= $c['pesan']; ?>


</p>


<?php } ?>


</div>





<form method="POST">


<input 
type="text"
name="pesan"
placeholder="Tanyakan buket yang kamu inginkan..."
required>


<button name="kirim">

Kirim

</button>


</form>




</body>

</html>