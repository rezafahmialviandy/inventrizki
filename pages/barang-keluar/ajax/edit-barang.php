<?php 
    include '../../../config/database.php';
    $kode_transaksi=addslashes(trim($_POST['kode_transaksi']));
    $kode_barang_lama=addslashes(trim($_POST['kode_barang_lama']));
    $kode_barang=addslashes(trim($_POST['kode_barang']));
    $qty=addslashes(trim($_POST['qty']));


    //Ambil harga barang
    include '../../../config/database.php';
    $sql="select * from barang where kode_barang='$kode_barang' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
    $harga=$data['harga_beli'];


    //Query update kategori
    $sql="update detail_barang_keluar set
    kode_barang='$kode_barang',
    qty='$qty',
    harga='$harga'
    where kode_barang='$kode_barang_lama' and kode_transaksi='$kode_transaksi' ";

    //Menjalankan query 
    mysqli_query($kon,$sql);
?>