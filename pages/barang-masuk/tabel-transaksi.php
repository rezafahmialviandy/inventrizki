<?php 
    session_start();
    if (isset($_POST['bulan'])){
        include '../../config/database.php';
        $bulan=$_POST['bulan'];
        $tahun=$_POST['tahun'];
        
        $sql=mysqli_query($kon,"select * from barang_masuk where month(tanggal)='".$bulan."' and year(tanggal)='".$tahun."' order by id_barang_masuk desc");
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
    echo "<script> $('title').text('DAFTAR BARANG MASUK BULAN ".strtoupper(bulan($_POST['bulan']))." TAHUN ".$tahun."'); </script>";
}else {
    echo "<h4>Menampilkan Semua Data</h4>";
    echo "<script> $('title').text('DAFTAR SEMUA BARANG MASUK'); </script>";
}
?>


<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tabel_transaksi" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode Transaksi</th>
            <th>Petugas</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Varian Barang</th>
            <th>Total QTY</th>
            <th>Total Harga</th>
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
                    $sql="select * from barang_masuk m inner join detail_barang_masuk d on d.kode_transaksi=m.kode_transaksi INNER JOIN barang b on b.kode_barang=d.kode_barang where month(m.tanggal)='".$bulan."' and year(m.tanggal)='".$tahun."' group by m.kode_transaksi order by m.tanggal desc";
                }else {
                    $sql="select * from barang_masuk m inner join detail_barang_masuk d on d.kode_transaksi=m.kode_transaksi INNER JOIN barang b on b.kode_barang=d.kode_barang group by m.kode_transaksi order by m.tanggal desc";
                }
                
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                $tot_qty=0;
                $tot_harga=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;

                $query1=mysqli_query($kon,"select kode_transaksi from detail_barang_masuk where kode_transaksi='".$data['kode_transaksi']."'");
                $jumlah_barang = mysqli_num_rows($query1);

                $query2=mysqli_query($kon,"select sum(qty) as total_qty, sum(harga*qty) as total_harga from detail_barang_masuk where kode_transaksi='".$data['kode_transaksi']."'");
                $row = mysqli_fetch_array($query2);
                $total_qty=$row['total_qty'];
                $total_harga=$row['total_harga'];

                $tot_qty+= $total_qty;
                $tot_harga+= $total_harga;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kode_transaksi']; ?></td>
                <td><?php echo $data['kode_pengguna']; ?></td>
                <td><?php echo tanggal(date("Y-m-d",strtotime($data["tanggal"])));?></td>
                <td><?php echo date("H:i",strtotime($data["tanggal"]));?> WIB</td>
                <td><?php echo $jumlah_barang; ?></td>
                <td><?php echo $total_qty; ?></td>
                <td>Rp. <?php echo number_format($total_harga,0,',','.'); ?></td>
                <?php if ($_SESSION["level"]=="admin"): ?>
                <td>
                <button class="tombol_edit_transaksi btn btn-warning btn-circle btn-sm"  kode_transaksi="<?php echo $data['kode_transaksi'];?>"  data-toggle="tooltip" title="Edit" data-placement="top" ><i class="fa fa-edit"></i></button>
                    <button class="tombol_hapus_transaksi btn btn-danger btn-circle btn-sm" kode_transaksi="<?php echo $data['kode_transaksi'];?>"  data-toggle="tooltip" title="Hapus" data-placement="top" ><i class="fa fa-trash"></i></button>
                </td>
                <?php endif; ?>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="6"></th>
            <th><?php echo $tot_qty; ?></th>
            <th>Rp. <?php echo number_format($tot_harga,0,',','.'); ?></th>
        </tr>
        </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#tabel_transaksi').DataTable( {
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

$('.tombol_edit_transaksi').on('click',function(){
    var kode_transaksi = $(this).attr("kode_transaksi");
    $.ajax({
        url: 'pages/barang-masuk/edit-transaksi.php',
        method: 'post',
        data: {kode_transaksi:kode_transaksi},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Transaksi Barang Masuk';
        }
    });
    // Membuka modal
    $('#modal').modal('show');
});



$('.tombol_hapus_transaksi').on('click',function(){
    var kode_transaksi = $(this).attr("kode_transaksi");
    var agree=confirm("Adakah Anda yakin ingin menghapus data barang masuk "+kode_transaksi+"?");
    if (!agree){
        return false;
    } else {
        var kode_transaksi = $(this).attr("kode_transaksi");
        $.ajax({
            url: 'pages/barang-masuk/ajax/hapus.php',
            method: 'post',
            data: {kode_transaksi:kode_transaksi},
            success:function(data){
                tabel_transaksi();
                tabel_barang();
            }
        });
    }
});

</script>