<?php 
    include '../../../config/database.php';

    $kode_barang=addslashes(trim($_POST['kode_barang']));
    $nama_barang=ucwords(addslashes(trim($_POST['nama_barang'])));
    $satuan=addslashes(trim($_POST['satuan']));
    $kategori=addslashes(trim($_POST['kategori']));
    $supplier=addslashes(trim($_POST['supplier']));
    $harga_beli=addslashes(trim($_POST['harga_beli']));
    $harga_jual=addslashes(trim($_POST['harga_jual']));
    $keterangan=addslashes(trim($_POST['keterangan']));


    $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
    $foto_barang = $_FILES['foto_barang']['name'];
    $x = explode('.', $foto_barang);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['foto_barang']['tmp_name'];

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
        //Upload foto
        move_uploaded_file($file_tmp, '../foto/'.$foto_barang);
        //Catatan: kode barang harus diawali dengan huruf, Jika tidak akan error pada saat ditambahkan di keranjang 
        $sql="insert into barang (kode_barang,nama_barang,satuan,kategori_barang,supplier,harga_beli,harga_jual,keterangan_barang,foto_barang) values
        ('B$kode_barang','$nama_barang','$satuan','$kategori','$supplier','$harga_beli','$harga_jual','$keterangan','$foto_barang')";
    
    }else {
 
        $sql="insert into barang (kode_barang,nama_barang,satuan,kategori_barang,supplier,harga_beli,harga_jual,keterangan_barang) values
        ('B$kode_barang','$nama_barang','$satuan','$kategori','$supplier','$harga_beli','$harga_jual','$keterangan')";
    }


    mysqli_query($kon,$sql);
  
?>