<?php 
    include '../../config/database.php';
    if (isset($_POST['bulan'])){
    $_POST['bulan']=$_POST['bulan'];
    $_POST['tahun']=$_POST['tahun'];
    
    $sql=mysqli_query($kon,"select * from barang_masuk where month(tanggal)='".$_POST['bulan']."' and year(tanggal)='".$_POST['tahun']."' order by id_barang_masuk desc");
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
<script>
$('title').text('DAFTAR BARANG MASUK BULAN <?php echo strtoupper(bulan($_POST['bulan'])); ?> TAHUN <?php echo $_POST['tahun']; ?>');
</script>
<?php 
if (isset($_POST['bulan'])){
    echo "<h4>Menampilkan Data Bulan ".bulan($_POST['bulan'])." Tahun ".$_POST['tahun']."</h4>";
    echo "<script> $('title').text('LAPORAN BARANG MASUK & KELUAR BULAN ".strtoupper(bulan($_POST['bulan']))." TAHUN ".$_POST['tahun']."'); </script>";
}else {
    echo "<h4>Menampilkan Semua Data</h4>";
    echo "<script> $('title').text('LAPORAN SEMUA BARANG MASUK & KELUAR'); </script>";
}
?>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tabel_laporan" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Selisih</th>
            <th>Harga Beli Satuan</th>
            <th>Harga Jual Satuan</th>
            <th>Total Pembelian</th>
            <th>Total Penjualan</th>
            <th>Laba</th>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';
         
                // perintah sql untuk menampilkan daftar barang_masuk
                $sql="select * from barang order by id_barang desc";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                $stok_akhir=0;
                $total_masuk=0;
                $total_keluar=0;
                $total_semua=0;
                $total_harga_beli=0;
                $total_harga_jual=0;
                $tot_harga_beli=0;
                $tot_harga_jual=0;
                $total_laba=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;

                //Mendapatkan jumlah QTY barang masuk

                if (isset($_POST['bulan'])){
                    $sql2="SELECT sum(dm.qty) as qty,dm.harga as harga_beli_satuan, sum(dm.harga*qty) as harga
                    from barang_masuk m
                    inner join detail_barang_masuk dm on dm.kode_transaksi=m.kode_transaksi
                    where month(m.tanggal)='".$_POST['bulan']."' and year(m.tanggal)='".$_POST['tahun']."' and  kode_barang='".$data['kode_barang']."'";
                }else {
                    $sql2="SELECT sum(dm.qty) as qty,dm.harga as harga_beli_satuan, sum(dm.harga*qty) as harga
                    from barang_masuk m
                    inner join detail_barang_masuk dm on dm.kode_transaksi=m.kode_transaksi
                    where kode_barang='".$data['kode_barang']."'";
                }
          
                $query2=mysqli_query($kon,$sql2);
                $row2 = mysqli_fetch_array($query2);
                $qty_masuk=$row2['qty'];
                $harga_masuk=$row2['harga'];
                $harga_beli_satuan=$row2['harga_beli_satuan'];
          

                if (isset($_POST['bulan'])){
                //Mendapatkan jumlah QTY barang keluar
                $sql3="SELECT sum(dk.qty) as qty,dk.harga as harga_jual_satuan , sum(dk.harga*qty) as harga
                from barang_keluar k
                inner join detail_barang_keluar dk on dk.kode_transaksi=k.kode_transaksi
                where month(k.tanggal)='".$_POST['bulan']."' and year(k.tanggal)='".$_POST['tahun']."' and  kode_barang='".$data['kode_barang']."'";
            
                }else {
                //Mendapatkan jumlah QTY barang keluar
                $sql3="SELECT sum(dk.qty) as qty,dk.harga as harga_jual_satuan , sum(dk.harga*qty) as harga
                from barang_keluar k
                inner join detail_barang_keluar dk on dk.kode_transaksi=k.kode_transaksi
                where kode_barang='".$data['kode_barang']."'";
            
                }
                $query3=mysqli_query($kon,$sql3);
                $row3 = mysqli_fetch_array($query3);
                $qty_keluar=$row3['qty'];
                $harga_keluar=$row3['harga'];
                $harga_jual_satuan=$row3['harga_jual_satuan'];

                $stok_akhir=$qty_masuk-$qty_keluar;
                $total_masuk+=$qty_masuk; 
                $total_keluar+=$qty_keluar; 
                $total_semua+=$stok_akhir;

                $total_harga_beli+=$harga_beli_satuan; 
                $total_harga_jual+=$harga_jual_satuan;

                $tot_harga_beli+=$harga_masuk;
                $tot_harga_jual+=$harga_keluar;

                $total_laba+=$tot_harga_jual-$tot_harga_beli;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kode_barang']; ?></td>
                <td><?php echo $data['nama_barang']; ?></td>
                <td><?php echo $qty_masuk; ?></td>
                <td><?php echo $qty_keluar; ?></td>
                <td><?php echo $stok_akhir; ?></td>
                <td>Rp. <?php echo number_format($harga_beli_satuan,0,',','.'); ?></td>
                <td>Rp. <?php echo number_format($harga_jual_satuan,0,',','.'); ?></td>
                <td>Rp. <?php echo number_format($harga_masuk,0,',','.'); ?></td>
                <td>Rp. <?php echo number_format($harga_keluar,0,',','.'); ?></td>
                <?php 
                    if ($harga_keluar-$harga_masuk<0){
                        $label="class='text-danger'";
                    }else {
                        $label="class='text-success'";
                    }
                ?>
                <td <?php echo $label; ?> >Rp. <?php echo number_format($harga_keluar-$harga_masuk,0,',','.'); ?></td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3"></th>
            <th><?php echo $total_masuk; ?></th>
            <th><?php echo $total_keluar; ?></th>
            <th><?php echo $total_semua; ?></th>
            <th>Rp. <?php echo number_format($total_harga_beli,0,',','.'); ?></th>
            <th>Rp. <?php echo number_format($total_harga_jual,0,',','.'); ?></th>
            <th>Rp. <?php echo number_format($tot_harga_beli,0,',','.'); ?></th>
            <th>Rp. <?php echo number_format($tot_harga_jual,0,',','.'); ?></th>
            <?php 
            
            ?>
            <th>Rp. <?php echo number_format($total_laba,0,',','.'); ?></th>
        </tr>
        </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#tabel_laporan').DataTable( {
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
        $_POST['bulan'] = array (1 =>   'Januari',
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
        return $split[2] . ' ' . $_POST['bulan'][ (int)$split[1] ] . ' ' . $split[0];
    }

?>



<script>

$('.tombol_edit').on('click',function(){
    var id_barang_masuk = $(this).attr("id_barang_masuk");
    $.ajax({
        url: 'pages/barang_masuk/edit.php',
        method: 'post',
        data: {id_barang_masuk:id_barang_masuk},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit barang_masuk';
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