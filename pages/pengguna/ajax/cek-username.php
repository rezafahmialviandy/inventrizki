<?php
    $username=$_POST['username'];
    include "../../../config/database.php";
    $hasil = mysqli_query ($kon,"select * from pengguna where username='".$username."' limit 1");
    $jumlah = mysqli_num_rows($hasil);

    if ($jumlah>=1){
        echo "<div class='alert alert-danger'> Kode pengguna telah digunakan</div>";
        echo "<script>  $('#submit').prop('disabled', true); </script>";
    }else {
        echo "<div class='alert alert-success'> Kode pengguna Tersedia</div>";
        echo "<script>  $('#submit').prop('disabled', false); </script>";
    }
?>
