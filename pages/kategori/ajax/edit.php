<?php 
    include '../../../config/database.php';
    $id_kategori=addslashes(trim($_POST['id_kategori']));
    $nama_kategori=ucwords(addslashes(trim($_POST["nama_kategori"])));


    //Query update kategori
    $sql="update kategori set
    nama_kategori='$nama_kategori'
    where id_kategori=$id_kategori";

    //Menjalankan query 
    mysqli_query($kon,$sql);
?>