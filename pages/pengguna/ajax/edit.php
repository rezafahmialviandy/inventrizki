<?php 

    include '../../../config/database.php';
    $id_pengguna=addslashes(trim($_POST['id_pengguna']));
    $nama_pengguna=ucwords(addslashes(trim($_POST["nama_pengguna"])));
    $username=addslashes(trim($_POST["username"]));
    $level=addslashes(trim($_POST["level"]));
    $foto_lama=$_POST['foto_lama'];

    //Upload pas foto
    $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
    $pas_foto = $_FILES['pas_foto']['name'];
    $x = explode('.', $pas_foto);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['pas_foto']['tmp_name'];

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
        //Upload foto
        move_uploaded_file($file_tmp, '../foto/'.$pas_foto);

        //Hapus foto lama
        unlink("../foto/".$foto_lama);

        $sql="update pengguna set
        nama_pengguna='$nama_pengguna',
        username='$username',
        level='$level',
        foto='$pas_foto'
        where id_pengguna=$id_pengguna";

        //Menjalankan query 
        mysqli_query($kon,$sql);

    }else {

        $sql="update pengguna set
        nama_pengguna='$nama_pengguna',
        username='$username',
        level='$level'
        where id_pengguna=$id_pengguna";

        //Menjalankan query 
        mysqli_query($kon,$sql);
    }

?>