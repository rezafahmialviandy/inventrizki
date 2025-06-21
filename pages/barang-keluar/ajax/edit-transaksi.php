<?php 
    include '../../../config/database.php';
    $kode_transaksi=addslashes(trim($_POST['kode_transaksi']));
    $tanggal=addslashes(trim($_POST['tanggal']));
    $jam=addslashes(trim($_POST['jam']));

    $waktu=$tanggal." ".$jam;

    //Query update barang_keluar
    $sql="update barang_keluar set
    tanggal='$waktu'
    where  kode_transaksi='$kode_transaksi' ";

    //Menjalankan query 
    mysqli_query($kon,$sql);
?>