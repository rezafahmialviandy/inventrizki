<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
    Stok Saat Ini
    <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Stok Saat Ini</li>
    </ol>
</section>

<!-- Main content -->   
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- Stok Saat Ini -->
            <div class="box box-danger">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
                <div class="box-body">
                    <div id="tampil_tabel_transaksi"></div>
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
        tabel_transaksi();
    });

</script>

<script>

  function tabel_transaksi(){
    $.ajax({
        type: "POST",

        dataType: "html",
        async : false,
        url: 'pages/stok/tabel-stok-saat-ini.php',
        success: function(data) {
            $("#tampil_tabel_transaksi").html(data);
        }
    });
  }

</script>
