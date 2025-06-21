<?php
if (isset($_POST['submit'])){
    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $id_pengguna = $_SESSION["id_pengguna"];
        //Koneksi database
        include '../../config/database.php';

        //Mengambil kiriman form
        $password_baru = md5(addslashes(trim($_POST["password_baru"])));

        $sql="update pengguna set
        password='$password_baru'
        where id_pengguna='$id_pengguna'";

        //Eksekusi query
        $update=mysqli_query($kon,$sql);

        if ($update) {
            header("Location:../../logout.php");
        }
        else {
            header("Location:../../index.php?page=ubah-password");
        }
    }
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Pengguna
    <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Pengguna</li>
    </ol>
</section>

<!-- Main content -->   
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- pengguna -->
            <div class="box box-danger">
            <!-- /.box-header -->
                <div class="box-body">
                    <div class="alert alert-info">
                        Apabila lupa password, silahkan hubungi admin.
                    </div>

                    <form action="pages/pengguna/ubah-password.php" method="post">
                        <div class="form-group">
                            <label>Password Saat Ini:</label>
                                <input type="password" name="password_lama" value="" class="form-control" id="password_lama">
                            <br>
                            <div id="get_ajax"></div>
                        </div>
                        <div class="form-group">
                            <label>Password Baru:</label>
                                <input type="password" name="password_baru" value="" class="form-control" id="password_baru" disabled>
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru:</label>
                            <input type="password" name="konfirmasi_password" value="" class="form-control" id="konfirmasi_password" disabled>
                            <br>
                            <div id="show_konfirmasi"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" disabled class="btn btn-primary btn-fill btn-wd" id="submit" >Submit</button>
                        </div>
                    </form>

                </div>
                <div class="box-footer">
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
</section>


<input type="hidden" name="status" id="status" value="0" />
<script>
    $('#password_lama').bind('keyup', function () {

        var password_lama=$("#password_lama").val();

        $.ajax({
          url: 'pages/pengguna/cek-password.php',
          method: 'POST',
          data:{password_lama:password_lama},
          success:function(data){
            $("#get_ajax").html(data);
          }
      }); 
    });


    $('#password_lama').bind('keyup', function () {
        cek();
    });

    $('#password_baru').bind('keyup', function () {
        if ($("#konfirmasi_password").val().length != 0) {
            cek();
        }
        
    });


    $('#konfirmasi_password').bind('keyup', function () {
        cek();
    });

    function cek(){
        var password_baru=$("#password_baru").val();
        var konfirmasi_password=$("#konfirmasi_password").val();
        var status=$("#status").val();

        if (status==1){
            if ($("#konfirmasi_password").val().length != 0) {
                if (password_baru!=konfirmasi_password){
                $("#show_konfirmasi").html("<div class='alert alert-danger'> Konfirmasi password salah</div>  ");
                $("#submit").prop('disabled', true);
            }else {
                $("#show_konfirmasi").html("<div class='alert alert-success'>Konfirmasi password benar</div>");
                $("#submit").prop('disabled', false);
            }
        }

        }else {
            $("#submit").prop('disabled', true);
        }
    }

</script>



