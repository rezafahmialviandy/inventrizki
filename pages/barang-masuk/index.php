<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
    Barang Masuk
    <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Barang Masuk</li>
    </ol>
</section>

<!-- Main content -->   
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- Barang Masuk -->
            <div class="box box-danger">
            <div class="box-header with-border">
                <a href="index.php?page=input-barang-masuk" class="btn btn-primary" role="button">Input Baru</a>
            </div>
            <!-- /.box-header -->
                <div class="box-body">
                <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control" name="jenis" id="jenis">
                                    <option value="1">Semua</option>
                                    <option value="2">Berdasarkan Periode</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control" name="bulan" id="bulan" disabled>
                                    <?php
                                    $bulan_sekarang=date('m');
                                    $nama_bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                                    $bulan = ["01","02","03","04","05","06","07","08","09","10","11","12"];
                                    for($i = 0;$i <= 11;$i++):
                                    ?>
                                    <option  <?php if ($bulan_sekarang==$bulan[$i]) echo "selected"; ?> value="<?php echo $bulan[$i]; ?>" ><?php echo $nama_bulan[$i]; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control" name="tahun" id="tahun" disabled>
                                <?php
                                    include 'config/database.php';
                                    $guru=$_SESSION['username'];
                                    $sql="select distinct year(tanggal) as tahun from barang_masuk group by tahun order by tahun desc";
                                    $hasil=mysqli_query($kon,$sql);
                                    while ($data = mysqli_fetch_array($hasil)):
                                ?>
                                <option value="<?php echo $data['tahun']; ?>"><?php echo $data['tahun']; ?></option>
                                <?php endwhile; ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="button" id="tampilkan" class="btn btn-default">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#menu1">Daftar Transaksi</a></li>
                        <li><a data-toggle="tab" href="#menu2">Daftar Barang</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="menu1" class="tab-pane fade in active">
                            <br>
                            <div id="tampil_tabel_transaksi"></div>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <br>
                            <div id="tampil_tabel_barang"></div>
                        </div>
                    </div>
                   
                </div>
                <div class="box-footer">
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
</section>

<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
        </div>

        <div class="modal-body">
            <div id="tampil_data">
                 <!-- Data akan di load menggunakan AJAX -->                   
            </div>  
        </div>
  
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>


<script>

    $(document).ready( function () {
        tabel_transaksi();
        tabel_barang();
    });


    $("#jenis").change(function() {
        var jenis = $("#jenis").val();

        if (jenis==2){
            $("#bulan").prop('disabled', false);
            $("#tahun").prop('disabled', false);
        }else {
            $("#bulan").prop('disabled', true);
            $("#tahun").prop('disabled', true);
        }
    });


    $('#tampilkan').click(function(){
        tabel_transaksi();
        tabel_barang();
    });


</script>

<script>

  function tabel_transaksi(){
    var jenis = $("#jenis").val();

    if (jenis==1){
        $.ajax({
            type: "POST",
            data : {},
            dataType: "html",
            async : false,
            url: 'pages/barang-masuk/tabel-transaksi.php',
            success: function(data) {
                $("#tampil_tabel_transaksi").html(data);
            }
        });
    }else {
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        $.ajax({
            type: "POST",
            data : {bulan:bulan,tahun:tahun},
            dataType: "html",
            async : false,
            url: 'pages/barang-masuk/tabel-transaksi.php',
            success: function(data) {
                $("#tampil_tabel_transaksi").html(data);
            }
        });
    }

  }

  function tabel_barang(){
    var jenis = $("#jenis").val();
    if (jenis==1){
        $.ajax({
            type: "POST",
            data : {},
            dataType: "html",
            async : false,
            url: 'pages/barang-masuk/tabel-barang-masuk.php',
            success: function(data) {
                $("#tampil_tabel_barang").html(data);
            }
        });
    }else {
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        $.ajax({
            type: "POST",
            data : {bulan:bulan,tahun:tahun},
            dataType: "html",
            async : false,
            url: 'pages/barang-masuk/tabel-barang-masuk.php',
            success: function(data) {
                $("#tampil_tabel_barang").html(data);
            }
        });
    }

  }

</script>
