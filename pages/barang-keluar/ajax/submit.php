<?php
    session_start();
    include '../../../config/database.php';

    mysqli_query($kon,"START TRANSACTION");

    //Membuat kode transaksi
    $query = mysqli_query($kon, "SELECT max(id_barang_keluar) as max_id FROM barang_keluar");
    $get = mysqli_fetch_array($query);
    $id_barang_keluar = $get['max_id'];
    $id_barang_keluar++;
    $tahun = date('y');
    $bulan = date('m');
    $kode_transaksi = "1".$tahun.$bulan.sprintf("%03s", $id_barang_keluar);

    $tanggal=date("Y-m-d H:i:s");
    $kode_pengguna=$_SESSION['username'];

  //Inser pada tabel barang_keluar
    $sql="insert into barang_keluar (kode_transaksi,tanggal,kode_pengguna) values
    ('$kode_transaksi','$tanggal','$kode_pengguna')";
    $insert_barang_keluar=mysqli_query($kon,$sql);

    //Insert pada tabel transaksi
    $tipe='2'; // untuk tipe barang keluar
    $sql="insert into transaksi (tanggal,tipe) values
    ('$tanggal','$tipe')";
    $insert_transaksi=mysqli_query($kon,$sql);

    //Insert pada tabel detail_barang_masuk
    if(!empty($_SESSION["cart_barang_keluar"])):
        foreach ($_SESSION["cart_barang_keluar"] as $item):
            $kode_barang=$item["kode_barang"];
            $qty=$item["jumlah"];
            $harga_jual=$item["harga_jual"];
            //Submit ke database
            $insert_detail=mysqli_query($kon,"insert into detail_barang_keluar (kode_transaksi,kode_barang,harga,qty) values ('$kode_transaksi','$kode_barang','$harga_jual','$qty')");
        endforeach;
    endif;

    if ($insert_barang_keluar and $insert_transaksi and $insert_detail) {
        mysqli_query($kon,"COMMIT");
        //Kosongkan keranjang
        unset($_SESSION["cart_barang_keluar"]);
    }
    else {
        mysqli_query($kon,"ROLLBACK");
    }



?>
