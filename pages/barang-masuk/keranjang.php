<?php
    //Memulai session
    session_start();
    //Koneksi database
    include '../../config/database.php';
    $kode_barang="";
  
    $jumlah=0;
    $aksi="";
    //Menerima data yang dikirim dengan ajax
    if (isset($_POST['kode_barang'])) {
        $kode_barang=$_POST['kode_barang'];
    }

    if (isset($_POST['jumlah'])) {
        $jumlah=$_POST['jumlah'];
    }
    if (isset($_POST['aksi'])) {
        $aksi=$_POST['aksi'];
    }

    //Mengambil data barang
    $query = mysqli_query($kon, "SELECT * FROM barang where kode_barang='$kode_barang'");
    $productByCode = mysqli_fetch_array($query);


    //Memecah data barang ke dalam array
    if (isset($_POST['aksi'])) {
    $itemArray = array($productByCode['kode_barang']=>array('jumlah'=>$jumlah,'kode_barang'=>$productByCode['kode_barang'],'nama_barang'=>$productByCode['nama_barang'],'harga_beli'=>$productByCode['harga_beli'],'satuan'=>$productByCode['satuan']));
    }
    switch($aksi) {	
        //Menambah barang ke kerangjang belanja
        case "tambah":
            if(!empty($_SESSION["cart_barang_masuk"])) {
                if(in_array($productByCode['kode_barang'],array_keys($_SESSION["cart_barang_masuk"]))) {
                    foreach($_SESSION["cart_barang_masuk"] as $k => $v) {
                            if($productByCode['kode_barang'] == $k) {
                                if(empty($_SESSION["cart_barang_masuk"][$k]["jumlah"])) {
                                    $_SESSION["cart_barang_masuk"][$k]["jumlah"] = 0;
                                }
                                $_SESSION["cart_barang_masuk"][$k]["jumlah"] += $jumlah;
                            }
                    }
                } else {
                    $_SESSION["cart_barang_masuk"] = array_merge($_SESSION["cart_barang_masuk"],$itemArray);
                }
            } else {
                $_SESSION["cart_barang_masuk"] = $itemArray;
            }
        break;
        case "hapus_item":
            //Menghapus barang dari keranjang belanja
    		if(!empty($_SESSION["cart_barang_masuk"])) {
                foreach($_SESSION["cart_barang_masuk"] as $k => $v) {
                        if($_POST["kode_barang"] == $k)
                            unset($_SESSION["cart_barang_masuk"][$k]);
                        if(empty($_SESSION["cart_barang_masuk"]))
                            unset($_SESSION["cart_barang_masuk"]);
                }
            }
        break;
    }
    //unset($_SESSION["cart_barang_masuk"]);
?>
<table class="table table-bordered" id="tabel_belanja" width="100%" cellspacing="0" >
    <thead>
        <tr>
            <th><strong>No</strong></th>
            <th><strong>Kode</strong></th>
            <th><strong>Nama Barang</strong></th>
            <th><strong>Satuan</strong></th>
            <th><strong>Jumlah</strong></th>
            <th><strong>Harga Beli</strong></th>
            <th><strong>Total</strong></th>
            <th><strong>Aksi</strong></th>
        </tr>	
    </thead>
    <tbody>

<?php
$no=0;
$tot=0;	
if(!empty($_SESSION["cart_barang_masuk"])) {
    foreach ($_SESSION["cart_barang_masuk"] as $item){
        $tot+=$item["jumlah"];
        $no++;
		?>
 
			<tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $item["kode_barang"]; ?></td>
                <td><?php echo $item["nama_barang"]; ?></td>
                <td><?php echo $item["satuan"]; ?></td>
                <td><?php echo $item["jumlah"]; ?></td>
                <td>Rp. <?php echo number_format($item['harga_beli'],0,',','.'); ?></td>
                <td>Rp. <?php echo number_format($item["jumlah"]*$item['harga_beli'],0,',','.'); ?></td>
                <td>  <button type="button" data-toggle="tooltip" title="Hapus"  onClick="hapus_item('hapus_item','<?php echo $item["kode_barang"]; ?>')"  id="batal_pembelian" class="btn-hapus btn btn-danger btn-circle"  ><i class="fa fa-trash"></i></button></td>
			</tr>
    <?php }} ?>
    </tbody>
</table>



<?php if ($tot!=0):?>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group text-right">
            <button  type="button" id="buat_transaksi" name="buat_transaksi" class="btn btn-success" ><span class="text">Buat Transaksi</span></button>
        </div>
    </div>
</div>
<?php endif; ?>

<script>

    $('#buat_transaksi').click(function(){
        var form = $('#form_barang_masuk')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            url	: "pages/barang-masuk/ajax/submit.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success	: function(data){
                window.location.href = "index.php?page=barang-masuk";
            }
        });
    });
</script>

<script>
    //Fungsi menghapus barang dari keranjang belanja
    function hapus_item(aksi,kode_barang) {
        var jumlah=0;
        $.ajax({
            url: 'pages/barang-masuk/keranjang.php',
            method: 'POST',
            data:{kode_barang:kode_barang,aksi:aksi,jumlah:jumlah},
            success:function(data){
                $('#tampil_cart').html(data);
            }
        }); 
    }
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>





