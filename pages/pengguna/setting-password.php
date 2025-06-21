<?php 
    include '../../config/database.php';
    $id_pengguna=addslashes(trim($_POST['id_pengguna']));
    $sql="select * from pengguna s where s.id_pengguna='$id_pengguna' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>
<form id="form_setting_password">

    <div class="form-group">
        <input type="hidden" class="form-control" name="id_pengguna" value="<?php echo $data['id_pengguna'];?>" id="id_pengguna">
    </div>


    <div class="form-group">
        <label>Password Baru:</label>
        <input name="password_baru" value="" type="text" id="password_baru" class="form-control" placeholder="Masukan Password" required>
    </div>

    <div class="form-group">
        <input name="password_lama" value="<?php echo $data['password'];?>" type="hidden" class="form-control" placeholder="Masukan Password" required>
    </div>

</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" >Submit</button>

<script>
    $('#submit').click(function(){
        if ($("#password_baru").val().length == 0) {
            alert('Password baru belum diisi');
            return false;
        }else {
            var form = $('#form_setting_password')[0];
            var data = new FormData(form);
            $.ajax({
                type	: 'POST',
                url: 'pages/pengguna/ajax/setting-password.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success	: function(data){
                    tabel_pengguna();
                }
            });
        }

    });
</script>

