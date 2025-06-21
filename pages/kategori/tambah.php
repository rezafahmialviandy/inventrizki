<form id="form_tambah">

    <div class="form-group">
        <label>Nama kategori:</label>
        <input name="nama_kategori" type="text" class="form-control" placeholder="Masukan nama" required>
    </div>

</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" >Submit</button>

<script>
    $('#submit').click(function(){
        var form = $('#form_tambah')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            url: 'pages/kategori/ajax/tambah.php',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success	: function(data){
                tabel_kategori();
            }
        });
    });
</script>

