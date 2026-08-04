<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";


// ===============================
// UPDATE STATUS PESANAN
// ===============================

if(isset($_POST['update_status'])){


    $id_pesanan = $_POST['id_pesanan'];

    $status = $_POST['status'];



    mysqli_query($koneksi,

    "
    UPDATE pesanan

    SET status='$status'

    WHERE id_pesanan='$id_pesanan'

    "

    );


    echo "
    <script>
    alert('Status pesanan berhasil diubah');
    window.location='pesanan.php';
    </script>
    ";


}



?>


<!DOCTYPE html>

<html lang="id">

<head>


<meta charset="UTF-8">

<title>
Data Pesanan
</title>


<link rel="stylesheet"
href="../assets/css/admin.css">


</head>



<body>



<?php include "sidebar.php"; ?>



<div class="content">



<h1>
Data Pesanan
</h1>





<table>


<tr>

<th>
ID Pesanan
</th>


<th>
Nama Pelanggan
</th>


<th>
Tanggal
</th>


<th>
Total Harga
</th>


<th>
Status
</th>


<th>
Aksi
</th>


</tr>





<?php


$data=mysqli_query($koneksi,


"
SELECT

pesanan.id_pesanan,
pesanan.tanggal,
pesanan.total,
pesanan.status,

pelanggan.nama


FROM pesanan


LEFT JOIN pelanggan

ON pesanan.id_pelanggan =
pelanggan.id_pelanggan


ORDER BY pesanan.id_pesanan DESC

"
);



if(mysqli_num_rows($data)>0){


while($d=mysqli_fetch_assoc($data)){


?>



<tr>



<td>

#<?= $d['id_pesanan']; ?>

</td>




<td>

<?= $d['nama'] ?? 'Pelanggan'; ?>

</td>




<td>

<?= date(
"d-m-Y",
strtotime($d['tanggal'])
); ?>


</td>




<td>

Rp <?= number_format(
$d['total'],
0,
",",
"."
); ?>


</td>






<td>


<form method="POST">


<input type="hidden"
name="id_pesanan"
value="<?= $d['id_pesanan']; ?>">



<select name="status">


<option value="Menunggu"

<?= ($d['status']=="Menunggu")?'selected':''; ?>

>

Menunggu

</option>




<option value="Diproses"

<?= ($d['status']=="Diproses")?'selected':''; ?>

>

Diproses

</option>




<option value="Selesai"

<?= ($d['status']=="Selesai")?'selected':''; ?>

>

Selesai

</option>



<option value="Dikirim"

<?= ($d['status']=="Dikirim")?'selected':''; ?>

>

Dikirim

</option>



<option value="Dibatalkan"

<?= ($d['status']=="Dibatalkan")?'selected':''; ?>

>

Dibatalkan

</option>



</select>



</td>





<td>


<button 
type="submit"
name="update_status">

Update

</button>


</form>


</td>




</tr>



<?php


}


}else{


?>

<tr>

<td colspan="6">

Belum ada data pesanan

</td>

</tr>


<?php

}


?>



</table>




</div>



</body>

</html>