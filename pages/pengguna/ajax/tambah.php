<?php 
    include '../../../config/database.php';

    $nama_pengguna=ucwords(addslashes(trim($_POST["nama_pengguna"])));
    $username=addslashes(trim($_POST["username"]));
    $password=md5(addslashes(trim($_POST["password"])));
    $level=addslashes(trim($_POST["level"]));

    //Upload pas foto
    $ekstensi_diperbolehkan	= array('png','jpg','jpeg','gif');
    $pas_foto = $_FILES['pas_foto']['name'];
    $x = explode('.', $pas_foto);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['pas_foto']['tmp_name'];

    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
        //Upload foto
        move_uploaded_file($file_tmp, '../foto/'.$pas_foto);

        $sql="insert into pengguna (nama_pengguna,username,password,level,foto) values
        ('$nama_pengguna','$username','$password','$level','$pas_foto')";
    
    }else {
        //Jika pengguna tidak memasukan foto
        $sql="insert into pengguna (nama_pengguna,username,password,level) values
        ('$nama_pengguna','$username','$password','$level')";
    }

    //Mengeksekusi query 
    mysqli_query($kon,$sql);
?>