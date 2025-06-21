<form id="form_tambah">

    <div class="form-group">
        <label>Nama:</label>
        <input name="nama_pengguna" type="text" class="form-control" placeholder="Masukan nama" required>
    </div>

    <div class="form-group">
        <label>Username:</label>
        <input name="username" id="username" type="text" class="form-control" placeholder="Masukan username" required>
    </div>

    <div class="form-group">
        <span id="alert"></span>
    </div>

    <div class="form-group">
        <label>Password:</label>
        <input name="password" type="password" class="form-control" placeholder="Masukan password" required>
    </div>

    <div class="form-group">
        <label>Level:</label>
        <select class="form-control" name="level">
            <option value="user">User</option>
            <option value="admin">Admin</option>
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
        <img src="" id="preview_pas_foto" class="img-thumbnail">
    </div>

</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" disabled >Submit</button>

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

    $('#preview_pas_foto').hide();
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
    $('#username').bind('keyup', function () {
        if ($("#username").val().length == 0) {
            document.getElementById("submit").disabled = true;
        }else {
            var username=$("#username").val();
                $.ajax({
                url: 'pages/pengguna/ajax/cek-username.php',
                method: 'POST',
                data:{username:username},
                success:function(data){
                    $("#alert").html(data);
                }
            });
        }
 
    });
</script>

<script>
    $('#submit').click(function(){
        var form = $('#form_tambah')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            enctype: 'multipart/form-data',
            url: 'pages/pengguna/ajax/tambah.php',
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

