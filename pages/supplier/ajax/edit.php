<?php 
    include '../../../config/database.php';
    $id_supplier=addslashes(trim($_POST['id_supplier']));
    $nama_supplier=ucwords(addslashes(trim($_POST["nama_supplier"])));
    $no_telp=addslashes(trim($_POST["no_telp"]));
    $alamat=addslashes(trim($_POST["alamat"]));
    $status=addslashes(trim($_POST["status"]));

    //Query update supplier
    $sql="update supplier set
    nama_supplier='$nama_supplier',
    no_telp='$no_telp',
    alamat_supplier='$alamat',
    status='$status'
    where id_supplier=$id_supplier";

    //Menjalankan query 
    mysqli_query($kon,$sql);
?>