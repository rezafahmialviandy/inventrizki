<?php 
    include '../../config/database.php';
    $id_supplier=addslashes(trim($_POST['id_supplier']));
    $sql="select * from supplier s where s.id_supplier='$id_supplier' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>
<form id="form_edit">

    <div class="form-group">
        <input type="hidden" class="form-control" name="id_supplier" value="<?php echo $data['id_supplier'];?>" id="id_supplier">
    </div>

    <div class="form-group">
        <label>Kode:</label>
        <input type="text" class="form-control" name="kode_supplier" value="<?php echo $data['kode_supplier'];?>" id="kode_supplier" placeholder="Masukan Kode supplier" disabled>
    </div>

    <div class="form-group">
        <span id="alert"></span>
    </div>

    <div class="form-group">
        <label>Nama supplier:</label>
        <input name="nama_supplier" type="text" value="<?php echo $data['nama_supplier'];?>" class="form-control" placeholder="Masukan nama" required>
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
        <input name="no_telp" type="number" value="<?php echo $data['no_telp'];?>" class="form-control" placeholder="Masukan no telp" required>
    </div>

    <div class="form-group">
        <label>Alamat:</label>
        <textarea name="alamat" class="form-control" rows="3" ><?php echo $data['alamat_supplier'];?></textarea>
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
        var form = $('#form_edit')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            url: 'pages/supplier/ajax/edit.php',
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

