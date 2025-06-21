<?php
    session_start();
    include '../../../config/database.php';

    mysqli_query($kon,"START TRANSACTION");

    //Membuat kode transaksi
    $query = mysqli_query($kon, "SELECT max(id_barang_masuk) as max_id FROM barang_masuk");
    $get = mysqli_fetch_array($query);
    $id_barang_masuk = $get['max_id'];
    $id_barang_masuk++;
    $tahun = date('y');
    $bulan = date('m');
    $kode_transaksi = "1".$tahun.$bulan.sprintf("%03s", $id_barang_masuk);

    $tanggal=date("Y-m-d H:i:s");
    $supplier=$_POST["supplier"];
    $kode_pengguna=$_SESSION['username'];

    //Inser pada tabel barang_masuk
    $sql="insert into barang_masuk (kode_transaksi,tanggal,supplier,kode_pengguna) values
    ('$kode_transaksi','$tanggal','$supplier','$kode_pengguna')";
    $insert_barang_masuk=mysqli_query($kon,$sql);

    //Insert pada tabel transaksi
    $tipe='1'; // untuk tipe barang masuk
    $sql="insert into transaksi (tanggal,tipe) values
    ('$tanggal','$tipe')";
    $insert_transaksi=mysqli_query($kon,$sql);


    //Insert pada tabel detail_barang_masuk
    if(!empty($_SESSION["cart_barang_masuk"])):
        foreach ($_SESSION["cart_barang_masuk"] as $item):
            $kode_barang=$item["kode_barang"];
            $qty=$item["jumlah"];
            $harga_beli=$item["harga_beli"];
            //Submit ke database
            $insert_detail=mysqli_query($kon,"insert into detail_barang_masuk (kode_transaksi,kode_barang,harga,qty) values ('$kode_transaksi','$kode_barang','$harga_beli','$qty')");
        endforeach;
    endif;

    if ($insert_barang_masuk and  $insert_transaksi and $insert_detail) {
        mysqli_query($kon,"COMMIT");
        //Kosongkan keranjang
        unset($_SESSION["cart_barang_masuk"]);
    }
    else {
        mysqli_query($kon,"ROLLBACK");
    }



?>
