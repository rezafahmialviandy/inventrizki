<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Dashboard
    <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-archive"></i></span>
        <?php
            include 'config/database.php';
            $hasil1=mysqli_query($kon,"select sum(qty) as total_qty from detail_barang_masuk ");
            $data1 = mysqli_fetch_array($hasil1);

            $hasil2=mysqli_query($kon,"select sum(qty) as total_qty from detail_barang_keluar ");
            $data2 = mysqli_fetch_array($hasil2);
        ?>
        <div class="info-box-content">
            <span class="info-box-text">TOTAL BARANG MASUK</span>
            <span class="info-box-number"><?php echo number_format($data1['total_qty'],0,',','.'); ?> Item</span>
            <span class="info-box-text">TOTAL BARANG KELUAR</span>
            <span class="info-box-number"><?php echo number_format($data2['total_qty'],0,',','.'); ?> Item </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
        <?php
               include 'config/database.php';
               $hasil1=mysqli_query($kon,"select * from barang_masuk");
               $jumlah1 = mysqli_num_rows($hasil1);
   
               $hasil2=mysqli_query($kon,"select * from barang_keluar");
               $jumlah2 = mysqli_num_rows($hasil2);
        ?>
        <div class="info-box-content">
            <span class="info-box-text">Total Transaksi Barang Masuk</span>
            <span class="info-box-number"><?php echo $jumlah1; ?> Kali</span>
            <span class="info-box-text">Total Transaksi Barang Keluar</span>
            <span class="info-box-number"><?php echo $jumlah2; ?> Kali</span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
        <?php
               include 'config/database.php';
               $hasil1=mysqli_query($kon,"select sum(qty*harga) as total_pembelian from detail_barang_masuk ");
               $data1 = mysqli_fetch_array($hasil1);
   
               $hasil2=mysqli_query($kon,"select sum(qty*harga) as total_penjualan from detail_barang_keluar ");
               $data2 = mysqli_fetch_array($hasil2);
        ?>
        <div class="info-box-content">
            <span class="info-box-text">Total Pembelian</span>
            <span class="info-box-number">Rp. <?php echo number_format($data1['total_pembelian'],0,',','.'); ?></span>
            <span class="info-box-text">Total Penjualan</span>
            <span class="info-box-number">Rp. <?php echo number_format($data2['total_penjualan'],0,',','.'); ?> </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
    <div class="col-md-12">
        <div class="box">
        <div class="box-header with-border">
         
            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>

            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-md-12">
                <p class="text-center">
                <strong>Barang Masuk & Keluar Tahun <?php echo date('Y');?></strong>
                </p>

                <div id="tampil_grafik_bar">
                  
                </div>
                <!-- /.chart-responsive -->
            </div>
           
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
  
        </div>
        <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
    <div class="col-md-6">
        <div class="box">
        <div class="box-header with-border">
         
            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>

            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-md-12">
                <p class="text-center">
                <strong>Stok Barang</strong>
                </p>
                <div id="tampil_grafik_stok">
                  
                </div>
            </div>
           
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
  
        </div>
        <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-6">
        <div class="box">
        <div class="box-header with-border">
         
            <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>

            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            <div class="col-md-12">
                <p class="text-center">
                <strong>Persentase Barang Keluar</strong>
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tabel_barang" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th width="40%">Persentase</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                //Koneksi database
                                include 'config/database.php';

                                // perintah sql
                                $sql="select b.*,(m.stok) as barang_masuk,(k.stok) as barang_keluar from barang b
                                left join stok_barang_masuk m on m.kode_barang=b.kode_barang
                                left join stok_barang_keluar k on k.kode_barang=b.kode_barang";
                                $hasil=mysqli_query($kon,$sql);
                                $no=0;
                                //Menampilkan data dengan perulangan while
                                while ($data = mysqli_fetch_array($hasil)):
                                $no++;

                                if (isset($data['barang_keluar'])&& isset($data['barang_masuk'])){
                                    $persentase=$data['barang_keluar']/$data['barang_masuk']*100;
                                }else {
                                    $persentase=0;
                                }

                          

                                
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data['kode_barang']; ?></td>
                                <td><?php echo $data['nama_barang']; ?></td>
                                <td>
                                    <div class="progress">
                                    <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar"
                                    aria-valuenow="<?php echo $persentase; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $persentase; ?>%">
                                    <?php echo (int)$persentase; ?>%
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- bagian akhir (penutup) while -->
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(function () {
                        $('#tabel_barang').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : false,
                        'autoWidth'   : false
                        })
                    })
                </script>
                <!-- /.chart-responsive -->
            </div>
           
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer">
  
        </div>
        <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    </div>


</section>
<!-- /.content -->
<script>

    $(document).ready(function(){
        grafik_bar();
        grafik_stok();
    });


    function grafik_bar() {
        $.ajax({
            url: 'pages/dashboard/grafik-bar.php',
            method: 'POST',
            success:function(data){
                $('#tampil_grafik_bar').html(data);
            }
        }); 
    }


    function grafik_stok() {
        $.ajax({
            url: 'pages/dashboard/grafik-stok.php',
            method: 'POST',
            success:function(data){
                $('#tampil_grafik_stok').html(data);
            }
        }); 
    }
</script>

