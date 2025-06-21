<?php
    //Memulai session
    session_start();
    //Koneksi database
    include '../../config/database.php';
    $kode_barang="";
  
    $jumlah=0;
    $qty_maks=0;
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

    if (isset($_POST['qty_maks'])) {
        $qty_maks=$_POST['qty_maks'];
    }


    //Mengambil data barang
    $query = mysqli_query($kon, "SELECT * FROM barang where kode_barang='$kode_barang'");
    $productByCode = mysqli_fetch_array($query);


    //Memecah data barang ke dalam array
    if (isset($_POST['aksi'])) {
    $itemArray = array($productByCode['kode_barang']=>array('jumlah'=>$jumlah,'qty_maks'=>$qty_maks,'kode_barang'=>$productByCode['kode_barang'],'nama_barang'=>$productByCode['nama_barang'],'harga_beli'=>$productByCode['harga_beli'],'harga_jual'=>$productByCode['harga_jual'],'satuan'=>$productByCode['satuan']));
    }
    switch($aksi) {	
        //Menambah barang ke kerangjang belanja
        case "tambah":
            if(!empty($_SESSION["cart_barang_keluar"])) {
                if(in_array($productByCode['kode_barang'],array_keys($_SESSION["cart_barang_keluar"]))) {
                    foreach($_SESSION["cart_barang_keluar"] as $k => $v) {
                            if($productByCode['kode_barang'] == $k) {
                                if(empty($_SESSION["cart_barang_keluar"][$k]["jumlah"])) {
                                    $_SESSION["cart_barang_keluar"][$k]["jumlah"] = 0;
                                }
                                $_SESSION["cart_barang_keluar"][$k]["jumlah"] += $jumlah;
                            }
                    }
                } else {
                    $_SESSION["cart_barang_keluar"] = array_merge($_SESSION["cart_barang_keluar"],$itemArray);
                }
            } else {
                $_SESSION["cart_barang_keluar"] = $itemArray;
            }
        break;
        case "hapus_item":
            //Menghapus barang dari keranjang belanja
    		if(!empty($_SESSION["cart_barang_keluar"])) {
                foreach($_SESSION["cart_barang_keluar"] as $k => $v) {
                        if($_POST["kode_barang"] == $k)
                            unset($_SESSION["cart_barang_keluar"][$k]);
                        if(empty($_SESSION["cart_barang_keluar"]))
                            unset($_SESSION["cart_barang_keluar"]);
                }
            }
        break;
    }
    //unset($_SESSION["cart_barang_keluar"]);
?>
<div id="info"> </div>
<table class="table table-bordered table-striped" id="tabel_belanja" width="100%" cellspacing="0" >
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
$harga=0;
$alert="";
$out_of_stock=false;
$nama_barang="";
if(!empty($_SESSION["cart_barang_keluar"])) {
    foreach ($_SESSION["cart_barang_keluar"] as $item){
        $tot+=$item["jumlah"];
        $harga+=$item["jumlah"]*$item['harga_beli'];
        $no++;

        if ($item['jumlah']>$item['qty_maks']){
            $alert="class='text-danger'";
            $nama_barang=$item["nama_barang"];
            $out_of_stock=true;
        }
		?>
 
            <tr <?php echo $alert; ?>>
                <td><?php echo $no; ?></td>
                <td><?php echo $item["kode_barang"]; ?></td>
                <td><?php echo $item["nama_barang"]; ?></td>
                <td><?php echo $item["satuan"]; ?></td>
                <td><?php echo $item["jumlah"]; ?></td>
                <td>Rp. <?php echo number_format($item['harga_beli'],0,',','.'); ?></td>
                <td>Rp. <?php echo number_format($item["jumlah"]*$item['harga_beli'],0,',','.'); ?></td>
                <td>  <button type="button" data-toggle="tooltip" title="Hapus" onClick="hapus_item('hapus_item','<?php echo $item["kode_barang"]; ?>')"  id="batal_pembelian" class="btn-hapus btn btn-danger btn-circle"  ><i class="fa fa-trash"></i></button></td>
			</tr>
            <?php 
                $alert="";
            ?>
    <?php }} ?>
    </tbody>
</table>

<table class="table">
    <tbody>
    <tr>
        <td width="20%">Jumlah Barang</td>
        <td><?php echo $no; ?></td>
    </tr>
    <tr>
        <td>Total Qty</td>
        <td><?php echo $tot; ?></td>
    </tr>
    <tr>
        <td>Total Harga</td>
        <td>Rp. <?php echo number_format($harga,0,',','.'); ?></td>
    </tr>
    </tbody>
</table>

<?php if ($out_of_stock==true):?>
    <script>
        $(document).ready(function() {
            $('#info').html("<div class='alert alert-danger'>Jumlah qty <?php echo $nama_barang; ?> melebihi stok.</div>");
            $('#buat_transaksi').prop('disabled', true);
        });
    </script>
<?php endif; ?>

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
        var form = $('#form_barang_keluar')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            url	: "pages/barang-keluar/ajax/submit.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success	: function(data){
                window.location.href = "index.php?page=barang-keluar";
            }
        });
    });
</script>

<script>
    //Fungsi menghapus barang dari keranjang belanja
    function hapus_item(aksi,kode_barang) {
        var jumlah=0;
        $.ajax({
            url: 'pages/barang-keluar/keranjang.php',
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






