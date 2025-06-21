<?php
    $kode_supplier=$_POST['kode_supplier'];
    include "../../../config/database.php";
    $hasil = mysqli_query ($kon,"select * from supplier where kode_supplier='".$kode_supplier."' limit 1");
    $jumlah = mysqli_num_rows($hasil);

    if ($jumlah>=1){
        echo "<div class='alert alert-danger'> Kode supplier telah digunakan</div>";
        echo "<script>  $('#submit').prop('disabled', true); </script>";
    }else {
        echo "<div class='alert alert-success'> Kode supplier Tersedia</div>";
        echo "<script>  $('#submit').prop('disabled', false); </script>";
    }
?>
