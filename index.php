<?php

session_start();


  if (!$_SESSION["username"]){
        header("Location:login.php?auth=harus_login");
      
  }else {

    include 'config/database.php';
    $username=$_SESSION["username"];

    $hasil=mysqli_query($kon,"select * from pengguna where username='$username'");
    $pengguna = mysqli_fetch_array($hasil); 
    $username_db=$pengguna['username'];
    $nama_pengguna=$pengguna['nama_pengguna'];
    $foto=$pengguna['foto'];

    if ($username!=$username_db){
        session_unset();
        session_destroy();
        header("Location:login.php?auth=tidak_valid");
    }
  }

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>APLIKASI INVENTORY BARANG</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- ChartJS -->
<script src="plugins/chartjs/Chart.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="dist/font/font.css">
  <style type="text/css">
    .preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background-color: #fff;
    }
    .preloader .loading {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%,-50%);
      font: 14px arial;
    }
  </style>

  <script>
    $(document).ready(function(){
      $(".preloader").fadeOut();
    })
  </script>

</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Aplikasi Inventory</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="pages/pengguna/foto/<?php echo $foto; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"> <?php echo ucfirst($nama_pengguna); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="pages/pengguna/foto/<?php echo $foto; ?>" class="img-circle" alt="User Image">

                <p>
                <?php echo ucfirst($nama_pengguna); ?>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="index.php?page=ubah-password" class="btn btn-default btn-flat">Ubah Password</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" id="logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="pages/pengguna/foto/<?php echo $foto; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo ucfirst($nama_pengguna); ?></p>

          <?php
          //buat fungsi untuk cek internet
          function cek_internet(){
            $connected = @fsockopen("www.google.com", 80);
            if ($connected){
              $is_conn = true; //jika koneksi tersambung
              fclose($connected);
            }else{
              $is_conn = false; //jika koneksi gagal
            }
            return $is_conn;
          }
          ?>
          <?php
            if (cek_internet() == true) echo "<a href='#'><i class='fa fa-circle text-success'></i> Online</a>"; else echo "<a href='#'><i class='fa fa-circle text-danger'></i> Offline</a>";
          ?>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="index.php?page=dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-basket"></i>
            <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="index.php?page=barang-masuk"><i class="fa fa-sign-in"></i> <span>Barang Masuk</span></a></li>
              <li><a href="index.php?page=barang-keluar"><i class="fa fa-sign-out"></i> <span>Barang Keluar</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-archive"></i>
            <span>Stok</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="index.php?page=stok-saat-ini"><i class="fa fa-info-circle"></i> <span>Stok Saat Ini</span></a></li>
              <li><a href="index.php?page=riwayat-stok"><i class="fa fa-random"></i> <span>Riwayat Stok</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th-large"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="index.php?page=laporan-barang"><i class="fa fa-retweet"></i> <span>Barang Masuk & Keluar</span></a></li>
          </ul>
        </li>
        <?php if ($_SESSION["level"]=="admin"): ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="index.php?page=barang"><i class="fa fa-briefcase"></i> <span>Barang</span></a></li>
              <li><a href="index.php?page=supplier"><i class="fa fa-user"></i> <span>Supplier</span></a></li>
              <li><a href="index.php?page=kategori"><i class="fa fa-bars"></i> <span>Kategori</span></a></li>
              <li><a href="index.php?page=pengguna"><i class="fa fa-user-o"></i> <span>Pengguna</span></a></li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

 
  <?php  if (cek_internet() == false): ?>
  <section class="content-header">
    <div class="alert alert-warning">
      Komputer anda sedang tidak terkoneksi dengan internet! Untuk dapat menjalankan aplikasi membutuhkan koneksi internet.
  </div>
  </section>
  <?php endif; ?>




  <?php 
      if(isset($_GET['page'])){
        $page = $_GET['page'];
    
        switch ($page) {
              case 'dashboard':
                include "pages/dashboard/index.php";
                break;
              case 'barang-masuk':
                include "pages/barang-masuk/index.php";
                break;
              case 'barang-keluar':
                include "pages/barang-keluar/index.php";
                break;
              case 'input-barang-masuk':
                include "pages/barang-masuk/input.php";
                break;
              case 'input-barang-keluar':
                include "pages/barang-keluar/input.php";
                break;
              case 'stok-saat-ini':
                include "pages/stok/saat-ini.php";
                break;
              case 'riwayat-stok':
                include "pages/stok/riwayat.php";
                break;
              case 'laporan-barang':
                include "pages/laporan/barang.php";
                break;
              case 'barang':
                include "pages/barang/index.php";
                break;
              case 'supplier':
                include "pages/supplier/index.php";
                break;
              case 'kategori':
                include "pages/kategori/index.php";
                break;
              case 'pengguna':
                include "pages/pengguna/index.php";
                break;
              case 'ubah-password':
                include "pages/pengguna/ubah-password.php";
                break;
          default:
            echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
            break;
        }
      }
  ?>


    <div class="preloader">
      <div class="loading">
        <img src="dist/img/loading.gif">
      </div>
    </div>


    <div id='ajax-wait'>
      <img src="dist/img/loading.gif">   
    </div>

    <style>
        #ajax-wait {
        display: none;
        position: fixed;
        z-index: 1999
        }
    </style>
    <script>

    $(document).ready( function () {
        loading();
    });

    //Fungsi untuk efek loading
    function loading(){
        $( document ).ajaxStart(function() {
        $( "#ajax-wait" ).css({
            left: ( $( window ).width() - 32 ) / 2 + "px", // 32 = lebar gambar
            top: ( $( window ).height() - 32 ) / 2 + "px", // 32 = tinggi gambar
            display: "block"
        })
        })
        .ajaxComplete( function() {
            $( "#ajax-wait" ).fadeOut();
        });
    }
    </script>

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y');?> <?php //echo $aplikasi['nama_aplikasi'];?>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">

        <!-- /.control-sidebar-menu -->


        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->

      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="bower_components/datatables/dataTables.buttons.min.js"></script>
<script src="bower_components/datatables/jszip.min.js"></script>
<script src="bower_components/datatables/vfs_fonts.js"></script>
<script src="bower_components/datatables/pdfmake.min.js"></script>
<script src="bower_components/datatables/buttons.html5.min.js"></script>
<script src="bower_components/datatables/buttons.print.min.js"></script>


</body>
</html>



<script>
   // fungsi hapus jadwal
   $('#logout').on('click',function(){
        konfirmasi=confirm("Apakah anda yakin ingin keluar?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>
