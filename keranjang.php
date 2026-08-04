<?php
session_start();

include "config/koneksi.php";


/*=================================
BUAT SESSION KERANJANG
=================================*/

if(!isset($_SESSION['keranjang'])){

    $_SESSION['keranjang'] = [];

}



/*=================================
TAMBAH PRODUK KE KERANJANG
=================================*/

if(isset($_POST['beli']) || isset($_POST['tambah'])){


    $id_produk = intval($_POST['id_produk']);

    $jumlah = intval($_POST['jumlah']);


    if($jumlah < 1){

        $jumlah = 1;

    }



    if(isset($_SESSION['keranjang'][$id_produk])){


        $_SESSION['keranjang'][$id_produk] += $jumlah;


    }else{


        $_SESSION['keranjang'][$id_produk] = $jumlah;


    }



    // jika tombol "Beli Sekarang" -> langsung checkout
    if(isset($_POST['beli'])){

        header("Location: checkout.php");
        exit;

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
UPDATE JUMLAH
=================================*/


if(isset($_POST['update'])){


    foreach($_POST['jumlah'] as $id=>$qty){


        if($qty <= 0){


            unset($_SESSION['keranjang'][$id]);


        }else{


            $_SESSION['keranjang'][$id] = $qty;


        }


    }


    echo "
    <script>
    alert('Keranjang berhasil diperbarui');
    window.location='keranjang.php';
    </script>
    ";

    exit;

}





/*=================================
HAPUS PRODUK
=================================*/


if(isset($_GET['hapus'])){


    $id = $_GET['hapus'];


    unset($_SESSION['keranjang'][$id]);


    echo "
    <script>
    window.location='keranjang.php';
    </script>
    ";


    exit;

}



?>


<!DOCTYPE html>

<html lang="id">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">


<title>Keranjang Belanja | Erlisna Florist</title>


<link rel="stylesheet" href="assets/css/style.css">


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


</head>


<body>


<?php include "includes/header.php"; ?>



<section class="page-header">


<div class="container">


<h1>

<i class="fa fa-shopping-cart"></i>

Keranjang Belanja


</h1>


<p>

Produk pilihan Anda

</p>


</div>


</section>





<div class="container">



<?php



if(empty($_SESSION['keranjang'])){


?>



<div class="cart-empty">


<i class="fa fa-cart-shopping"></i>


<h2>

Keranjang Masih Kosong

</h2>


<p>

Silakan pilih produk bunga terlebih dahulu.

</p>



<a href="produk.php" class="btn-primary">

Belanja Sekarang

</a>


</div>



<?php



}else{



?>




<form method="POST">



<table class="cart-table">



<tr>


<th>No</th>

<th>Produk</th>

<th>Harga</th>

<th>Jumlah</th>

<th>Subtotal</th>

<th>Aksi</th>


</tr>



<?php



$no=1;

$total=0;



foreach($_SESSION['keranjang'] as $id_produk=>$jumlah){



$query=mysqli_query($koneksi,

"

SELECT *

FROM produk

WHERE id_produk='$id_produk'

"

);



$p=mysqli_fetch_assoc($query);



if(!$p){

continue;

}



$subtotal = $p['harga'] * $jumlah;


$total += $subtotal;



?>



<tr>



<td>

<?= $no++; ?>

</td>



<td>


<div class="cart-product">


<img 
src="uploads/<?= $p['gambar']; ?>"
class="cart-img"
>



<div>


<h4>

<?= $p['nama_bunga']; ?>

</h4>


</div>


</div>



</td>




<td>


Rp <?= number_format($p['harga'],0,",","."); ?>


</td>




<td>


<input

type="number"

name="jumlah[<?= $id_produk; ?>]"

value="<?= $jumlah; ?>"

min="1"

class="qty-input"


>


</td>




<td>


Rp <?= number_format($subtotal,0,",","."); ?>


</td>




<td>


<a

href="keranjang.php?hapus=<?= $id_produk; ?>"

onclick="return confirm('Hapus produk ini?')"

class="btn-delete"


>


<i class="fa fa-trash"></i>


</a>


</td>


</tr>



<?php } ?>





<tr class="cart-total">


<td colspan="4">


<b>

Total Belanja

</b>


</td>



<td colspan="2">


<b>

Rp <?= number_format($total,0,",","."); ?>

</b>


</td>


</tr>



</table>





<div class="cart-action">



<button

type="submit"

name="update"

class="btn-secondary">


<i class="fa fa-refresh"></i>


Update Keranjang


</button>





<a href="produk.php"

class="btn-outline">


<i class="fa fa-arrow-left"></i>


Lanjut Belanja


</a>





<a href="checkout.php"

class="btn-primary">


<i class="fa fa-credit-card"></i>


Checkout


</a>




</div>




</form>




<?php } ?>



</div>





<?php include "includes/footer.php"; ?>



</body>

</html>