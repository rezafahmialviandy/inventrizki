<!-- Content Header (Page header) -->
<form id="form_barang_masuk">
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
            <div class="col-md-4">
                <!-- Barang Masuk -->
                <div class="box box-danger">
                <div class="box-header with-border">
                </div>
                <!-- /.box-header -->
                    <div class="box-body">
                        <!-- rows -->
                        <div class="row">
                        <div class="col-sm-12">
                            <!-- Overflow Hidden -->
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h4>Pilih Kategori</h4>
                                </div>
                                <div class="card-body">
                                    <!-- rows -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <select class="form-control" name="kategori" id="kategori">
                                                <?php
                                                include 'config/database.php';
                                                $sql="select k.* from kategori k inner join barang b on b.kategori_barang=k.id_kategori
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
                                        </div>
                                    <!-- rows -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="tampil_barang">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- rows -->
                    </div>
                    <div class="box-footer">
                    </div>
                </div>
                <!-- /.box -->
            </div>

            <div class="col-md-8">
                <div class="box box-danger">
                <div class="box-header with-border">
            
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                        <!--Menampilkan cart (keranjang barang) --> 
                        <div id="tampil_cart"></div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
                <div class="box-footer">
        
                </div>
                <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            
        </div>
        <!-- /.row -->
    </section>
</form>





<script>

  //Saat halaman diload cart ditampilkan
  $("#tampil_cart").load("pages/barang-masuk/keranjang.php");

    $(document).ready(function(){
      load_data();
    });

    $("#kategori").change(function() {
      load_data();
    });

    
    $(document).on('click', '.halaman', function(){
          var page = $(this).attr("id");
          load_data(page);
    });


    function load_data(page){
      var kategori = $("#kategori").val();
      $.ajax({
          type: "POST",
          dataType: "html",
          url: 'pages/barang-masuk/pilih-barang.php',
          data:{page:page,kategori:kategori},
          success: function(data) {
              $("#tampil_barang").html(data);
          }
      });
    }
</script>
