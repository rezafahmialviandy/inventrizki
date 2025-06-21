<?php 
    include '../../config/database.php';
    $id_barang=addslashes(trim($_POST['id_barang']));
    $sql="select * from barang b where b.id_barang='$id_barang' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>
<form id="form_edit">

    <div class="form-group">
        <input type="hidden" class="form-control" name="id_barang" value="<?php echo $data['id_barang'];?>" id="id_barang">
    </div>

    <div class="form-group">
        <label>Kode:</label>
        <input type="text" class="form-control" name="kode_barang" value="<?php echo $data['kode_barang'];?>" id="kode_barang" placeholder="Masukan Kode Barang" disabled>
    </div>

    <div class="form-group">
        <span id="alert"></span>
    </div>

    <div class="form-group">
        <label>Nama:</label>
        <input type="text" class="form-control" name="nama_barang" value="<?php echo $data['nama_barang'];?>" placeholder="Masukan Nama Barang">
    </div>

    <div class="form-group">
        <label>Kategori:</label>
        <select class="form-control" name="kategori">
            <option value="0">Pilih</option>
            <?php
            include '../../config/database.php';
            $sql="select * from kategori order by id_kategori asc";
            $hasil=mysqli_query($kon,$sql);
            while ($row = mysqli_fetch_array($hasil)):
            ?>
            <option <?php if ($data['kategori_barang']==$row['id_kategori']) echo 'selected';?> value="<?php echo $row['id_kategori']; ?>"><?php echo $row['nama_kategori']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Supplier:</label>
        <select class="form-control" name="supplier">
            <option value="0">Pilih</option>
            <?php
            include '../../config/database.php';
            $sql="select * from supplier order by id_supplier asc";
            $hasil=mysqli_query($kon,$sql);
            while ($row = mysqli_fetch_array($hasil)):
            ?>
            <option <?php if ($data['supplier']==$row['id_supplier']) echo 'selected';?> value="<?php echo $row['id_supplier']; ?>"><?php echo $row['nama_supplier']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Satuan:</label>
        <select class="form-control" name="satuan">
            <option <?php if ($data['satuan']=='pcs') echo "selected";?> value="pcs">Pcs</option>
            <option <?php if ($data['satuan']=='box') echo "selected";?>  value="box">Box</option>
        </select>
    </div>

    <div class="form-group">
        <label>Harga Beli:</label>
        <input type="number" class="form-control" name="harga_beli" value="<?php echo $data['harga_beli'];?>" placeholder="Masukan Harga Beli">
    </div>

    <div class="form-group">
        <label>Harga Jual:</label>
        <input type="number" class="form-control" name="harga_jual" value="<?php echo $data['harga_jual'];?>" placeholder="Masukan Harga Jual">
    </div>

    <div class="form-group">
        <label>Keterangan:</label>
        <textarea class="form-control" name="keterangan" rows="5" ><?php echo $data['keterangan_barang']; ?></textarea>
    </div>

    <div class="form-group">
        <div id="msg"></div>
        <label>Pas Foto:</label>
        <input type="file" name="foto_barang" id="foto_barang">
            <div class="input-group my-3">
                <div class="input-group-append">
                    <button type="button" id="pilih_foto_barang" class="browse btn btn-light">Pilih</button>
                </div>
            </div>
        <img src="pages/barang/foto/<?php echo $data['foto_barang']; ?>" id="preview_foto_barang" class="img-thumbnail">
    </div>

    <div class="form-group">
        <input type="hidden" class="form-control" name="foto_lama" value="<?php echo $data['foto_barang'];?>">
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


    $(document).on("click", "#pilih_foto_barang", function() {
    var file = $(this).parents().find("#foto_barang");
    file.trigger("click");
    });
    $('#foto_barang').change(function(e) {

    var reader = new FileReader();
    reader.onload = function(e) {
        $('#preview_foto_barang').show();
        // get loaded data and render thumbnail.
        document.getElementById("preview_foto_barang").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });
</script>

<script>
    $('#kode_barang').bind('keyup', function () {
        var kode_barang=$("#kode_barang").val();
        $.ajax({
          url: 'pages/barang/ajax/cek-kode.php',
          method: 'POST',
          data:{kode_barang:kode_barang},
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
            enctype: 'multipart/form-data',
            url: 'pages/barang/ajax/edit.php',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success	: function(data){
                tabel_barang();
            }
        });
    });
</script>

