<?php 
    include '../../config/database.php';
    $kode_transaksi=addslashes(trim($_POST['kode_transaksi']));
    $kode_barang=addslashes(trim($_POST['kode_barang']));
    $sql="select * from detail_barang_keluar where kode_transaksi='$kode_transaksi' and kode_barang='$kode_barang' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>


<form id="form_edit">

    <div class="form-group">
        <input type="hidden" class="form-control" name="kode_transaksi" value="<?php echo $data['kode_transaksi'];?>" id="id_kategori">
    </div>

    <div class="form-group">
        <input type="hidden" class="form-control" name="kode_barang_lama" value="<?php echo $data['kode_barang'];?>" id="id_kategori">
    </div>

    <div class="form-group">
        <label>Barang:</label>
        <select class="form-control" name="kode_barang">
            <?php
            include '../../config/database.php';
            $sql="select * from barang order by id_barang asc";
            $hasil=mysqli_query($kon,$sql);
            while ($row = mysqli_fetch_array($hasil)):
            ?>
            <option <?php if ($data['kode_barang']==$row['kode_barang']) echo 'selected';?> value="<?php echo $row['kode_barang']; ?>"><?php echo $row['nama_barang']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Jumlah qty: (maksimal )</label>
        <input type="number" class="form-control" min="1" name="qty" value="<?php echo $data['qty'];?>" placeholder="Masukan QTY">
    </div>


</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" >Submit</button>


<script>
    $('#submit').click(function(){
        var agree=confirm("Adakah Anda yakin ingin mengedit barang keluar ini?");
        if (!agree){
            return false;
        } else {
            var form = $('#form_edit')[0];
            var data = new FormData(form);
            $.ajax({
                type	: 'POST',
                url: 'pages/barang-keluar/ajax/edit-barang.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success	: function(data){
                    tabel_barang();
                }
            });
        }

    });
</script>

