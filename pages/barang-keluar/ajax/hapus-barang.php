<?php
    include '../../../config/database.php';
    $kode_transaksi=$_POST['kode_transaksi'];
    $kode_barang=$_POST['kode_barang'];
    mysqli_query($kon,"delete from detail_barang_keluar where kode_transaksi='$kode_transaksi' and kode_barang='$kode_barang'");
?>