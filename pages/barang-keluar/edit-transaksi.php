<?php 
    include '../../config/database.php';
    $kode_transaksi=addslashes(trim($_POST['kode_transaksi']));
    $sql="select * from barang_keluar where kode_transaksi='$kode_transaksi' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>

<form id="form_edit">

    <div class="form-group">
        <input type="hidden" class="form-control" name="kode_transaksi" value="<?php echo $data['kode_transaksi'];?>" id="kode_transaksi">
    </div>

    <div class="form-group">
        <label>Kode Transaksi</label>
        <input type="text" class="form-control" value="<?php echo $data['kode_transaksi'];?>" disabled>
    </div>

    <div class="form-group">
        <label>Petugas Penginput</label>
        <input type="text" class="form-control"  name="kode_pengguna" value="<?php echo $data['kode_pengguna'];?>" disabled>
    </div>

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" class="form-control"  name="tanggal" value="<?php echo date("Y-m-d",strtotime($data["tanggal"]));?>" >
    </div>

    <div class="form-group">
        <label>Jam</label>
        <input type="time" class="form-control"  name="jam" value="<?php echo date("H:i",strtotime($data["tanggal"]));?>">
    </div>

    <div class="alert alert-info">
        Untuk varian barang dapat dilakukan edit pada <strong>Tab Daftar Barang.</strong>
    </div>


</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" >Submit</button>


<script>
    $('#submit').click(function(){
        var agree=confirm("Adakah Anda yakin ingin mengedit data ini?");
        if (!agree){
            return false;
        } else {
            var form = $('#form_edit')[0];
            var data = new FormData(form);
            $.ajax({
                type	: 'POST',
                url: 'pages/barang-keluar/ajax/edit-transaksi.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success	: function(data){
                    tabel_transaksi();
                }
            });
        }

    });
</script>

