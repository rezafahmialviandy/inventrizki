<?php
    //validasi hanya admin yang boleh mengakses halaman ini
    $username = $_SESSION['username'];
    $cek = mysqli_query ($kon,"select * from pengguna where username='".$username."' and level='admin' limit 1");
    $jum = mysqli_num_rows($cek);

    if ($jum<1){
        echo "<section class='content-header'>";
        echo "<br><div class='alert alert-danger'>TIDAK MEMILIKI HAK AKSES</div>";
        echo "</section>";
        exit;
    }
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Supplier
    <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Supplier</li>
    </ol>
</section>

<!-- Main content -->   
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- supplier -->
            <div class="box box-success">
            <div class="box-header with-border">
                <button type="button" class="btn btn-primary" id="tambah">Tambah</button>
            </div>
            <!-- /.box-header -->
                <div class="box-body">
                    <div id="tampil_tabel"></div>
                </div>
                <div class="box-footer">
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
</section>
<!-- jQuery 3 -->




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
    // Tambah supplier
    $('#tambah').on('click',function(){
        $.ajax({
            url: 'pages/supplier/tambah.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Supplier';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>

<script>

  $(document).ready( function () {
    tabel_supplier();
  });


  function tabel_supplier(){

    $.ajax({
        type: "POST",
        dataType: "html",
        async : false,
        url: 'pages/supplier/tabel-supplier.php',
        success: function(data) {
            $("#tampil_tabel").html(data);
        }
    });
  }

</script>