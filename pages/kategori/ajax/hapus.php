<?php
    include '../../../config/database.php';
    $id_kategori=$_POST['id_kategori'];
    mysqli_query($kon,"delete from kategori where id_kategori='$id_kategori'");
   
?>