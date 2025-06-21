<form id="form_tambah">

    <div class="form-group">
        <label>Kode:</label>
        <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Masukan Kode Barang">
    </div>

    <div class="form-group">
        <span id="alert"></span>
    </div>

    <div class="form-group">
        <label>Nama:</label>
        <input type="text" class="form-control" name="nama_barang" placeholder="Masukan Nama Barang">
    </div>

    <div class="form-group">
        <label>Satuan:</label>
        <select class="form-control" name="satuan">
            <option value="pcs">Pcs</option>
            <option value="box">Box</option>
        </select>
    </div>

    <div class="form-group">
        <label>Kategori:</label>
        <select class="form-control" name="kategori">
            <?php
            include '../../config/database.php';
            $sql="select * from kategori order by id_kategori asc";
            $hasil=mysqli_query($kon,$sql);
            while ($data = mysqli_fetch_array($hasil)):
            ?>
            <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Supplier:</label>
        <select class="form-control" name="supplier">
            <?php
            include '../../config/database.php';
            $sql="select * from supplier order by id_supplier asc";
            $hasil=mysqli_query($kon,$sql);
            while ($data = mysqli_fetch_array($hasil)):
            ?>
            <option value="<?php echo $data['id_supplier']; ?>"><?php echo $data['nama_supplier']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Harga Beli:</label>
        <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Masukan Harga Beli">
    </div>

    <div class="form-group">
        <label id="info_harga_beli"> </label>
    </div>

    <div class="form-group">
        <label>Harga Jual:</label>
        <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Masukan Harga Jual">
    </div>

    <div class="form-group">
        <label id="info_harga_jual"> </label>
    </div>

    <div class="form-group">
        <label>Keterangan:</label>
        <textarea class="form-control" name="keterangan" rows="5" ></textarea>
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
        <img src="" id="preview_foto_barang" class="img-thumbnail">
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

    $('#preview_foto_barang').hide();
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

    function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
         return ribuan	= ribuan.join('.').split('').reverse().join('');
    }


    $('#harga_beli').bind('keyup', function () {
        var harga_beli=$("#harga_beli").val();
        if (harga_beli!=0){
            $("#info_harga_beli").text('Rp. '+format_rupiah(harga_beli)); 
        }else {
            $("#info_harga_beli").text('Rp. '+0);
        }
        
    });

    $('#harga_jual').bind('keyup', function () {
        var harga_jual=$("#harga_jual").val();
        if (harga_jual!=0){
            $("#info_harga_jual").text('Rp. '+format_rupiah(harga_jual)); 
        }else {
            $("#info_harga_jual").text('Rp. '+0);
        }
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
        var form = $('#form_tambah')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            enctype: 'multipart/form-data',
            url: 'pages/barang/ajax/tambah.php',
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

