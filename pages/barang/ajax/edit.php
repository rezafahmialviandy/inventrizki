<?php 
    include '../../../config/database.php';
    $id_barang=addslashes(trim($_POST['id_barang']));
    $kode_barang=addslashes(trim($_POST['kode_barang']));
    $nama_barang=ucwords(addslashes(trim($_POST['nama_barang'])));
    $satuan=addslashes(trim($_POST['satuan']));
    $kategori=addslashes(trim($_POST['kategori']));
    $supplier=addslashes(trim($_POST['supplier']));
    $harga_beli=addslashes(trim($_POST['harga_beli']));
    $harga_jual=addslashes(trim($_POST['harga_jual']));
    $keterangan=addslashes(trim($_POST['keterangan']));
    $foto_lama=$_POST['foto_lama'];

    $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
    $foto_barang = $_FILES['foto_barang']['name'];
    $x = explode('.', $foto_barang);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['foto_barang']['tmp_name'];

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){

        //Upload foto baru
        move_uploaded_file($file_tmp, '../foto/'.$foto_barang);
        
        //Hapus foto lama
        unlink("../foto/".$foto_lama);

        $sql="update barang set
        nama_barang='$nama_barang',
        satuan='$satuan',
        kategori_barang='$kategori',
        supplier='$supplier',
        harga_beli='$harga_beli',
        harga_jual='$harga_jual',
        keterangan_barang='$keterangan',
        foto_barang='$foto_barang'
        where id_barang='$id_barang'";
    
    }else {
        $sql="update barang set
        nama_barang='$nama_barang',
        satuan='$satuan',
        kategori_barang='$kategori',
        supplier='$supplier',
        harga_beli='$harga_beli',
        harga_jual='$harga_jual',
        keterangan_barang='$keterangan'
        where id_barang='$id_barang'";
    }

    mysqli_query($kon,$sql);

?>