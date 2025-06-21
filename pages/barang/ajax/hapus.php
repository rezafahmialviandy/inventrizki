<?php
    include '../../../config/database.php';
    $id_barang=$_POST['id_barang'];
    mysqli_query($kon,"delete from barang where id_barang='$id_barang'");
   
?>