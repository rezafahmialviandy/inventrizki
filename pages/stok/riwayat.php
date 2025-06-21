<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
    Riwayat Stok Barang
    <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Riwayat Stok Barang</li>
    </ol>
</section>

<!-- Main content -->   
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!--Riwayat Stok Barang -->
            <div class="box box-danger">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
                <div class="box-body">
                <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Kategori:</label>
                                <select class="form-control" name="kategori" id="kategori">
                                    <?php
                                    include 'config/database.php';
                                    $sql="select k.* from kategori k inner join barang b on b.kategori_barang=k.id_kategori inner join stok_barang_masuk s on s.kode_barang=b.kode_barang
                                    group by k.id_kategori
                                    order by k.id_kategori asc";
                                    $hasil=mysqli_query($kon,$sql);
                                    while ($data = mysqli_fetch_array($hasil)):
                                    ?>
                                    <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Barang:</label>
                                <select class="form-control" name="barang" id="barang">
            
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div id="tampil_data"></div>
                </div>
                <div class="box-footer">
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
</section>


<script>

    $(document).ready( function () {
        get_barang();
        tabel_barang();
    });

    $("#kategori").change(function() {
        get_barang();
        tabel_barang();
    });

    $("#barang").change(function() {
        tabel_barang();
    });

</script>

<script>

  function tabel_barang(){
    var kategori=$("#kategori").val();
    var barang=$("#barang").val();
    $.ajax({
        type: "POST",
        data : {kategori:kategori,barang:barang},
        dataType: "html",
        async : false,
        url: 'pages/stok/tabel-riwayat-stok.php',
        success: function(data) {
            $("#tampil_data").html(data);
        }
    });
  }

  function get_barang(){
      var kategori=$("#kategori").val();
      $.ajax({
        url: 'pages/stok/ambil-barang.php',
            method : "POST",
            data : {kategori:kategori},
            async : false,
            dataType : 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].kode_barang+'>'+data[i].nama_barang+'</option>';
                }
                $('#barang').html(html);

            }
        })
    }

</script>
