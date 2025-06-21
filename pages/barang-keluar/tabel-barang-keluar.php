<?php
    session_start();
    include '../../config/database.php';
    $bulan="";
    $tahun="";
    if (isset($_POST['bulan'])){
        $bulan=$_POST['bulan'];
        $tahun=$_POST['tahun'];
        
        $sql=mysqli_query($kon,"select * from barang_keluar where month(tanggal)='".$bulan."' and year(tanggal)='".$tahun."' order by id_barang_keluar desc");
        $jum = mysqli_num_rows($sql);
    
        if ($jum<=0){
            echo "<div class='alert alert-warning'> Data tidak ditemukan!</div>";
            exit;
        }    
    }

    function bulan($bulan)
    {
    Switch ($_POST['bulan']){
        case 1 : $bulan="Januari";
            break;
        case 2 : $bulan="Februari";
            break;
        case 3 : $bulan="Maret";
            break;
        case 4 : $bulan="April";
            break;
        case 5 : $bulan="Mei";
            break;
        case 6 : $bulan="Juni";
            break;
        case 7 : $bulan="Juli";
            break;
        case 8 : $bulan="Agustus";
            break;
        case 9 : $bulan="September";
            break;
        case 10 : $bulan="Oktober";
            break;
        case 11 : $bulan="November";
            break;
        case 12 : $bulan="Desember";
            break;
        }
    return $bulan;
    }


?>

<?php 
if (isset($_POST['bulan'])){
    echo "<h4>Menampilkan Data Bulan ".bulan($_POST['bulan'])." Tahun ".$_POST['tahun']."</h4>";
}else {
    echo "<h4>Menampilkan Semua Data</h4>";
}
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tabel_barang_keluar" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Transaksi</th>
            <th>Kode Barang</th>
            <th>Nama</th>
            <th>QTY</th>
            <th>Harga</th>
            <?php if ($_SESSION["level"]=="admin"): ?>
            <th>Aksi</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';
                if (isset($_POST['bulan'])){
                    $bulan=$_POST['bulan'];
                    $tahun=$_POST['tahun'];
                    $sql="select d.*,b.nama_barang,t.tanggal from detail_barang_keluar d inner join barang b on b.kode_barang=d.kode_barang inner join barang_keluar t on t.kode_transaksi=d.kode_transaksi  where month(t.tanggal)='".$bulan."' and year(t.tanggal)='".$tahun."' order by t.tanggal desc";
                }else {
                    $sql="select d.*,b.nama_barang,t.tanggal from detail_barang_keluar d inner join barang b on b.kode_barang=d.kode_barang inner join barang_keluar t on t.kode_transaksi=d.kode_transaksi order by t.tanggal desc";
                }
              
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                $tot_qty=0;
                $tot_harga=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
                $tot_qty+= $data['qty'];
                $tot_harga+= $data['harga']*$data['qty'];
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo tanggal(date("Y-m-d",strtotime($data["tanggal"])));?></td>
                <td><?php echo $data['kode_transaksi']; ?></td>
                <td><?php echo $data['kode_barang']; ?></td>
                <td><?php echo $data['nama_barang']; ?></td>
                <td><?php echo $data['qty']; ?></td>
                <td>Rp. <?php echo number_format($data['harga']*$data['qty'],0,',','.'); ?></td>
                <?php if ($_SESSION["level"]=="admin"): ?>
                <td>
                    <button class="tombol_edit_barang btn btn-warning btn-circle btn-sm" kode_barang="<?php echo $data['kode_barang']; ?>" kode_transaksi="<?php echo $data['kode_transaksi'];?>"  data-toggle="tooltip" title="Edit" data-placement="top" ><i class="fa fa-edit"></i></button>
                    <button class="tombol_hapus_barang btn btn-danger btn-circle btn-sm" kode_transaksi="<?php echo $data['kode_transaksi'];?>" kode_barang="<?php echo $data['kode_barang'];?>" data-toggle="tooltip" title="Hapus" data-placement="top" ><i class="fa fa-trash"></i></button>
                </td>
                <?php endif; ?>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="5"></th>
            <th><?php echo $tot_qty; ?></th>
            <th>Rp. <?php echo number_format($tot_harga,0,',','.'); ?></th>
        </tr>
        </tfoot>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tabel_barang_keluar').DataTable( {
            "searching": true,
            "paging":   true,
            "ordering": true,
            "info":     true,
            dom: 'Bfrtip',
            buttons: ['excel','print','copy']
        });
    });
</script>
<?php 
    //Membuat format tanggal
    function tanggal($tanggal)
    {
        $bulan = array (1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }

?>



<script>

$('.tombol_edit_barang').on('click',function(){
    var kode_transaksi = $(this).attr("kode_transaksi");
    var kode_barang = $(this).attr("kode_barang");
    $.ajax({
        url: 'pages/barang-keluar/edit-barang.php',
        method: 'post',
        data: {kode_transaksi:kode_transaksi,kode_barang:kode_barang},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Barang Keluar';
        }
    });
    // Membuka modal
    $('#modal').modal('show');
});



$('.tombol_hapus_barang').on('click',function(){
    var kode_transaksi = $(this).attr("kode_transaksi");
    var kode_barang = $(this).attr("kode_barang");
    var agree=confirm("Adakah Anda yakin ingin menghapus data barang keluar "+kode_transaksi+"?");
    if (!agree){
        return false;
    } else {
        $.ajax({
            url: 'pages/barang-keluar/ajax/hapus-barang.php',
            method: 'post',
            data: {kode_transaksi:kode_transaksi,kode_barang:kode_barang},
            success:function(data){
                tabel_barang();
                tabel_transaksi();
            }
        });
    }
});
</script>