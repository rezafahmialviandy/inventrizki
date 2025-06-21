<form id="form_tambah">

    <div class="form-group">
        <label>Kode:</label>
        <input type="text" class="form-control" name="kode_supplier" id="kode_supplier" placeholder="Masukan Kode supplier">
    </div>

    <div class="form-group">
        <span id="alert"></span>
    </div>

    <div class="form-group">
        <label>Nama supplier:</label>
        <input name="nama_supplier" type="text" class="form-control" placeholder="Masukan nama" required>
    </div>

    <div class="form-group">
        <label>Status:</label>
        <select name="status" class="form-control">
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
        </select>
    </div>

    <div class="form-group">
        <label>No Telp:</label>
        <input name="no_telp" type="number" class="form-control" placeholder="Masukan no telp" required>
    </div>

    <div class="form-group">
        <label>Alamat:</label>
        <textarea name="alamat" class="form-control" rows="3" ></textarea>
    </div>

</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" >Submit</button>


<script>
    $('#kode_supplier').bind('keyup', function () {
        var kode_supplier=$("#kode_supplier").val();
        $.ajax({
          url: 'pages/supplier/ajax/cek-kode.php',
          method: 'POST',
          data:{kode_supplier:kode_supplier},
          success:function(data){
            $("#alert").html(data);
          }
      }); 
    });
</script>

<script>
    $('#submit').click(function(){
        var form = $('#form_tambah')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            url: 'pages/supplier/ajax/tambah.php',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success	: function(data){
                tabel_supplier();
            }
        });
    });
</script>

