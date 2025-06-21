<?php 
    include '../../../config/database.php';

    $nama_kategori=ucwords(addslashes(trim($_POST["nama_kategori"])));
    //Query input menginput data kedalam tabel kategori
    $sql="insert into kategori (nama_kategori) values
    ('$nama_kategori')";

    //Mengeksekusi query 
    mysqli_query($kon,$sql);
?>