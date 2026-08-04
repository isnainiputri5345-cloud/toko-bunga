<?php

// cek posisi folder
$is_pelanggan = strpos($_SERVER['SCRIPT_NAME'],'pelanggan') !== false;

$base = $is_pelanggan ? '../' : '';

?>


<footer>


<div class="container">


<div class="footer-grid">



<!-- LOGO -->

<div class="footer-item">


<img 
src="<?= $base; ?>assets/images/logo.png"
class="footer-logo"
alt="Erlisna Florist">



<h2>
ERLISNA FLORIST
</h2>



<p>

Kami menyediakan berbagai rangkaian bunga segar
berkualitas untuk wisuda, ulang tahun,
pernikahan, standing flower, papan bunga,
dan berbagai momen spesial lainnya.

</p>


</div>





<!-- MENU -->


<div class="footer-item">


<h3>
Menu
</h3>



<a href="<?= $base; ?>index.php">

Beranda

</a>



<a href="<?= $base; ?>produk.php">

Produk

</a>



<a href="<?= $base; ?>tentang.php">

Tentang Kami

</a>



<a href="<?= $base; ?>kontak.php">

Kontak Kami

</a>


</div>





<!-- KATEGORI -->


<div class="footer-item">


<h3>
Kategori
</h3>



<?php


$kategori_footer=mysqli_query($koneksi,"
SELECT *
FROM kategori
ORDER BY nama_kategori ASC
");


while($k=mysqli_fetch_assoc($kategori_footer)){


?>


<a href="<?= $base; ?>produk.php?kategori=
<?= $k['id_kategori']; ?>">


<?= $k['nama_kategori']; ?>


</a>



<?php } ?>



</div>







<!-- KONTAK -->


<div class="footer-item">


<h3>
Hubungi Kami
</h3>



<p>

<i class="fa-solid fa-location-dot"></i>

Jl. Pelor Mas Raya No.III, Kekalik Jaya, Sekarbela, Mataram, NTB

</p>




<p>

<i class="fa-solid fa-phone"></i>

0819-4671-6865

</p>




<p>

<i class="fa-solid fa-envelope"></i>

erlisnaflorist@gmail.com

</p>




<p>

<i class="fa-brands fa-instagram"></i>

@erlisnaflorist

</p>



</div>




</div>




<hr>




<div class="copyright">


© <?= date("Y"); ?>

ERLISNA FLORIST

|

All Rights Reserved.


</div>



</div>


</footer>





<!-- ===========================
 JAVASCRIPT DROPDOWN NAVBAR
=========================== -->


<script>


document.addEventListener("DOMContentLoaded",function(){



/* =========================
 DROPDOWN PRODUK
========================= */


const produkBtn =
document.querySelector(".dropbtn");



if(produkBtn){


produkBtn.addEventListener("click",function(e){


e.preventDefault();

e.stopPropagation();



let dropdown =
this.closest(".dropdown");



dropdown.classList.toggle("active");



});

}




/* =========================
 DROPDOWN PROFIL
========================= */


const akunBtn =
document.querySelector(".akun-btn");



if(akunBtn){


akunBtn.addEventListener("click",function(e){


e.preventDefault();

e.stopPropagation();



let akun =
this.closest(".akun");



akun.classList.toggle("active");



});


}





/* =========================
 KLIK MENU TIDAK MENUTUP
========================= */


document.querySelectorAll(
".dropdown-content a, .akun-menu a"
)

.forEach(function(menu){


menu.addEventListener("click",function(e){


e.stopPropagation();


});


});







/* =========================
 KLIK LUAR TUTUP DROPDOWN
========================= */


document.addEventListener("click",function(){



document.querySelectorAll(
".dropdown,.akun"
)

.forEach(function(item){


item.classList.remove("active");


});



});


/* =========================
 SMOOTH SCROLL
========================= */


document.querySelectorAll('a[href^="#"]')
.forEach(function(anchor){


anchor.addEventListener("click",function(e){



let tujuan =
document.querySelector(
this.getAttribute("href")
);



if(tujuan){


e.preventDefault();


tujuan.scrollIntoView({

behavior:"smooth"

});


}


});


});



});

</script>



</body>

</html>

