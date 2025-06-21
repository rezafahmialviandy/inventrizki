<?php
    include '../../../config/database.php';
    $id_pengguna=$_POST['id_pengguna'];
    mysqli_query($kon,"delete from pengguna where id_pengguna='$id_pengguna'");
   
?>