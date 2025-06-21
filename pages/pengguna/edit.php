<?php 
    include '../../config/database.php';
    $id_pengguna=addslashes(trim($_POST['id_pengguna']));
    $sql="select * from pengguna s where s.id_pengguna='$id_pengguna' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>
<form id="form_edit">

    <div class="form-group">
        <input type="hidden" class="form-control" name="id_pengguna" value="<?php echo $data['id_pengguna'];?>" id="id_pengguna">
    </div>


    <div class="form-group">
        <label>Nama:</label>
        <input name="nama_pengguna" value="<?php echo $data['nama_pengguna'];?>" type="text" class="form-control" placeholder="Masukan nama" required>
    </div>

    <div class="form-group">
        <label>Username:</label>
        <input name="username" value="<?php echo $data['username'];?>" id="username" type="text" class="form-control" placeholder="Masukan username" required>
    </div>

    <div class="form-group">
        <span id="alert"></span>
    </div>


    <div class="form-group">
        <label>Level:</label>
        <select class="form-control" name="level">
            <option <?php if ($data['level']=='user') echo "selected"; ?> value="user">User</option>
            <option <?php if ($data['level']=='admin') echo "selected"; ?> value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <div id="msg"></div>
        <label>Pas Foto:</label>
        <input type="file" name="pas_foto" id="pas_foto">
            <div class="input-group my-3">
                <div class="input-group-append">
                    <button type="button" id="pilih_pas_foto" class="browse btn btn-light">Pilih</button>
                </div>
            </div>
        <img src="pages/pengguna/foto/<?php echo $data['foto']; ?>" id="preview_pas_foto" class="img-thumbnail">
    </div>

    <div class="form-group">
        <input type="hidden" class="form-control" name="foto_lama" value="<?php echo $data['foto'];?>">
    </div>

</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" >Submit</button>


<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
    #file {
    visibility: hidden;
    position: absolute;
    }
</style>

<script>


    $(document).on("click", "#pilih_pas_foto", function() {
    var file = $(this).parents().find("#pas_foto");
    file.trigger("click");
    });
    $('#pas_foto').change(function(e) {

    var reader = new FileReader();
    reader.onload = function(e) {
        $('#preview_pas_foto').show();
        // get loaded data and render thumbnail.
        document.getElementById("preview_pas_foto").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });
</script>

<script>
    $('#submit').click(function(){
        var form = $('#form_edit')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            enctype: 'multipart/form-data',
            url: 'pages/pengguna/ajax/edit.php',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success	: function(data){
                tabel_pengguna();
            }
        });
    });
</script>

