<?php
  session_start();
  if  (isset($_SESSION["id_pengguna"])){
    header("Location:index.php?page=dashboard");
  }
  $pesan="";

  //Cek apakah ada kiriman form dari method post
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "config/database.php";
  
    $username = addslashes(trim($_POST["username"]));
    $password = addslashes(trim(md5($_POST["password"])));
    
    $hasil = mysqli_query ($kon,"select * from pengguna where username='".$username."' and password='".$password."' limit 1");
    $jumlah = mysqli_num_rows($hasil);
    $row = mysqli_fetch_assoc($hasil); 

    if ($jumlah>0){
 
      $_SESSION["id_pengguna"]=$row["id_pengguna"];
      $_SESSION["nama_pengguna"]=$row["nama_pengguna"];
      $_SESSION["username"]=$row["username"];
      $_SESSION["level"]=$row["level"];
      $_SESSION["foto"]=$row["foto"];

      header("Location:index.php?page=dashboard");  

    }else {
      $pesan="<div class='alert alert-danger'><strong>Error!</strong> Username dan password salah.</div>";
    }

  }

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Login</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  <?php 	if ($_SERVER["REQUEST_METHOD"] == "POST") echo $pesan; ?>
  <?php
    if (isset($_GET['daftar'])) {
        if ($_GET['daftar']=='berhasil'){
            echo"<div class='alert alert-success'>Pendaftaran berhasil. Login sekarang!</div>";
        } 
    }

    if (isset($_GET['auth'])) {
      if ($_GET['auth']=='harus_login'){
          echo"<div class='alert alert-danger'>Harus login terlebih dahulu</div>";
      } 
    }

    if (isset($_GET['auth'])) {
      if ($_GET['auth']=='tidak_valid'){
          echo"<div class='alert alert-danger'>User tidak valid</div>";
      } 
    }
  ?>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
