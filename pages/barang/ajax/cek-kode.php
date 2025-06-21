<?php
    $kode_barang=$_POST['kode_barang'];
    include "../../../config/database.php";
    $hasil = mysqli_query ($kon,"select * from barang where kode_barang='".$kode_barang."' limit 1");
    $jumlah = mysqli_num_rows($hasil);

    if ($jumlah>=1){
        echo "<div class='alert alert-danger'> Kode barang telah digunakan</div>";
        echo "<script>  $('#submit').prop('disabled', true); </script>";
    }else {
        echo "<div class='alert alert-success'> Kode barang Tersedia</div>";
        echo "<script>  $('#submit').prop('disabled', false); </script>";
    }
?>
