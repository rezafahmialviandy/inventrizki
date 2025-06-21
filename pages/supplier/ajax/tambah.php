<?php 
    include '../../../config/database.php';

    $kode_supplier=addslashes(trim($_POST["kode_supplier"]));
    $nama_supplier=ucwords(addslashes(trim($_POST["nama_supplier"])));
    $no_telp=addslashes(trim($_POST["no_telp"]));
    $alamat=addslashes(trim($_POST["alamat"]));
    $status=addslashes(trim($_POST["status"]));

    //Query input menginput data kedalam tabel supplier
    $sql="insert into supplier (kode_supplier,nama_supplier,no_telp,alamat_supplier,status) values
    ('$kode_supplier','$nama_supplier','$no_telp','$alamat','$status')";

    //Mengeksekusi query 
    mysqli_query($kon,$sql);
?>