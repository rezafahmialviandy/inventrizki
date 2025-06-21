<?php 

    include '../../../config/database.php';
    $id_pengguna=addslashes(trim($_POST['id_pengguna']));
    $password_lama=$_POST['password_lama'];
    $password_baru=md5($_POST['password_baru']);

    if ($password_baru!=$password_lama){
        $sql="update pengguna set
        password='$password_baru'
        where id_pengguna=$id_pengguna";

        mysqli_query($kon,$sql);
    }

?>