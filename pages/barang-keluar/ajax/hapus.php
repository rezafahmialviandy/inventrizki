<?php
    include '../../../config/database.php';
    $kode_transaksi=$_POST['kode_transaksi'];
    mysqli_query($kon,"delete from barang_keluar where kode_transaksi='$kode_transaksi'");
    mysqli_query($kon,"delete from detail_barang_keluar where kode_transaksi='$kode_transaksi'");
?>