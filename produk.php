<?php
session_start();

include "config/koneksi.php";



/*=================================
TAMBAH KERANJANG
=================================*/


if(isset($_POST['beli'])){


    $id_produk = intval($_POST['id_produk']);

    $jumlah = intval($_POST['jumlah']);


    if(!isset($_SESSION['keranjang'])){

        $_SESSION['keranjang'] = [];

    }


    if(isset($_SESSION['keranjang'][$id_produk])){


        $_SESSION['keranjang'][$id_produk] += $jumlah;


    }else{


        $_SESSION['keranjang'][$id_produk] = $jumlah;


    }



    echo "

    <script>

    alert('Produk berhasil ditambahkan ke keranjang');

    window.location='produk.php';

    </script>

    ";


    exit;

}





/*=================================
SEARCH
=================================*/


$cari="";


if(isset($_GET['cari'])){


    $cari=mysqli_real_escape_string(
        $koneksi,
        $_GET['cari']
    );


}





/*=================================
FILTER KATEGORI
=================================*/


$where="WHERE 1";



if(isset($_GET['kategori']) && $_GET['kategori']!=""){


    $kategori=intval($_GET['kategori']);


    $where .= " AND id_kategori='$kategori'";


}





if($cari!=""){


    $where .= "

    AND nama_bunga LIKE '%$cari%'

    ";


}





/*=================================
SORTING
=================================*/


$order="ORDER BY id_produk DESC";



if(isset($_GET['sort'])){


    switch($_GET['sort']){


        case "murah":

        $order="ORDER BY harga ASC";

        break;



        case "mahal":

        $order="ORDER BY harga DESC";

        break;



        case "nama":

        $order="ORDER BY nama_bunga ASC";

        break;



    }

}





/*=================================
AMBIL PRODUK
=================================*/


$data=mysqli_query($koneksi,

"

SELECT *

FROM produk

$where

$order

"

);



?>



<!DOCTYPE html>

<html lang="id">


<head>


<meta charset="UTF-8">


<meta name="viewport"
content="width=device-width, initial-scale=1.0">


<title>
Produk Erlisna Florist
</title>



<link rel="stylesheet"
href="assets/css/style.css">



<link rel="stylesheet"

href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


</head>



<body>



<?php include "includes/header.php"; ?>





<section class="page-header">


<div class="container">


<h1>

🌸 Produk Erlisna Florist

</h1>


<p>

Temukan buket bunga terbaik untuk setiap momen spesial.

</p>


</div>


</section>






<!-- FILTER -->


<div class="container">



<form method="GET" class="filter-box">



<input

type="text"

name="cari"

placeholder="Cari bunga..."

value="<?= $cari; ?>"

>



<select name="kategori">



<option value="">

Semua Kategori

</option>



<?php


$kat=mysqli_query($koneksi,

"

SELECT *

FROM kategori

ORDER BY nama_kategori ASC

"

);



while($k=mysqli_fetch_assoc($kat)){



?>



<option

value="<?= $k['id_kategori']; ?>"

<?php

if(isset($_GET['kategori']) 
&& $_GET['kategori']==$k['id_kategori']){

echo "selected";

}

?>

>


<?= $k['nama_kategori']; ?>


</option>



<?php } ?>



</select>






<select name="sort">


<option value="">

Urutkan

</option>


<option value="murah">

Harga Termurah

</option>


<option value="mahal">

Harga Termahal

</option>


<option value="nama">

Nama Produk

</option>



</select>





<button type="submit">


<i class="fa fa-search"></i>

Cari


</button>



</form>


</div>







<!-- PRODUK -->


<section class="section">


<div class="container">



<div class="product-grid">





<?php while($p=mysqli_fetch_assoc($data)){ ?>




<div class="card">





<?php

if($p['stok']<=5){

?>


<span class="badge">

Stok Terbatas

</span>



<?php

}else{

?>

<span class="badge">

Ready

</span>


<?php } ?>







<img

src="uploads/<?= $p['gambar']; ?>"

alt="<?= $p['nama_bunga']; ?>"

>






<div class="card-body">



<h3>

<?= $p['nama_bunga']; ?>

</h3>





<div class="price">


Rp <?= number_format(
$p['harga'],
0,
",",
"."
); ?>


</div>





<p>

Stok :

<b>

<?= $p['stok']; ?>

</b>


</p>







<div class="produk-button">





<a

href="detail_produk.php?id=<?= $p['id_produk']; ?>"

class="btn-detail">


<i class="fa fa-eye"></i>

Detail


</a>






<form method="POST"
action="produk.php">





<input

type="hidden"

name="id_produk"

value="<?= $p['id_produk']; ?>"

>




<input

type="hidden"

name="jumlah"

value="1"

>






<button

type="submit"

name="beli"

class="btn-cart">


<i class="fa fa-cart-plus"></i>


Tambah Keranjang


</button>





</form>





</div>




</div>



</div>




<?php } ?>






</div>


</div>


</section>






<?php include "includes/footer.php"; ?>



</body>


</html>