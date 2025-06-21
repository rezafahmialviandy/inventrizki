<?php
    session_start();
    $id_pengguna = $_SESSION["id_pengguna"];
    $password_lama=md5($_POST['password_lama']);

    include "../../config/database.php";
    $hasil = mysqli_query ($kon,"select password from pengguna where id_pengguna='".$id_pengguna."' limit 1");
    $data = mysqli_fetch_array($hasil); 
    $password=$data['password'];

    if ($password_lama!=$password){
        echo "<div class='alert alert-danger'> Password salah</div>";
        echo "<script> $('#status').val(0); </script>";
        echo "<script>  $('#password_baru').prop('disabled', true); </script>";
        echo "<script>  $('#konfirmasi_password').prop('disabled', true); </script>";
        echo "<script>  $('#submit').prop('disabled', true); </script>";
    }else {
        echo "<div class='alert alert-success'> Password Benar</div>";
        echo "<script> $('#status').val(1); </script>";
        echo "<script>  $('#password_baru').prop('disabled', false); </script>";
        echo "<script>  $('#konfirmasi_password').prop('disabled', false); </script>";
        echo "<script>  $('#submit').prop('disabled', false); </script>";
    }
?>
