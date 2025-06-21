<?php
    include '../../../config/database.php';
    $id_supplier=$_POST['id_supplier'];
    mysqli_query($kon,"delete from supplier where id_supplier='$id_supplier'");
   
?>