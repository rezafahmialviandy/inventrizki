<?php 
    include '../../config/database.php';
    $kode_barang=$_POST['barang'];
    $sql="select * from barang where kode_barang='$kode_barang' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>

<script>
    $('title').text('DAFTAR RIWAYAT STOK BARANG <?php echo strtoupper($data['nama_barang']);?>');
</script>

<?php 
    echo "<h4>Menampilkan Data Riwayat Stok Barang ".$data['nama_barang']."</h4>";
?>


<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tabel_riwayat_stok" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Masuk</th>
            <th>Keluar</th>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';
                $kode_barang=$_POST['barang'];
                // perintah sql
                $sql="select DISTINCT date(t.tanggal) as tgl from transaksi t
                left join barang_masuk m on date(m.tanggal)=date(t.tanggal)
                left join barang_keluar k on date(k.tanggal)=date(t.tanggal)
                left join detail_barang_masuk dm on dm.kode_transaksi=m.kode_transaksi
                left join detail_barang_keluar dk on dk.kode_transaksi=k.kode_transaksi
                where dk.kode_barang='".$kode_barang."' or dm.kode_barang='".$kode_barang."'
                group by tgl order by tgl desc";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                $total_qty_masuk=0;
                $total_qty_keluar=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                    $no++;

                    //Mendapatkan jumlah QTY barang masuk
                    $sql2="SELECT sum(dm.qty) as qty
                    from barang_masuk m
                    inner join detail_barang_masuk dm on dm.kode_transaksi=m.kode_transaksi
                    where date(m.tanggal)='".$data['tgl']."' and kode_barang='".$kode_barang."'";
                    $query2=mysqli_query($kon,$sql2);
                    $row2 = mysqli_fetch_array($query2);
                    $qty_masuk=$row2['qty'];
                    $total_qty_masuk+= $qty_masuk;
    


                    //Mendapatkan jumlah QTY barang masuk
                    $sql3="SELECT sum(dk.qty) as qty
                    from barang_keluar k
                    inner join detail_barang_keluar dk on dk.kode_transaksi=k.kode_transaksi
                    where date(k.tanggal)='".$data['tgl']."' and kode_barang='".$kode_barang."'";
                    $query3=mysqli_query($kon,$sql3);
                    $row3 = mysqli_fetch_array($query3);
                    $qty_keluar=$row3['qty'];
                    $total_qty_keluar+= $qty_keluar;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo tanggal(date("Y-m-d",strtotime($data["tgl"])));?></td>
                <?php
                    if (isset($qty_masuk)){
                        echo "<td>".$qty_masuk."</td>";
                    } else {
                    echo "<td>0</td>";
                    }

                    if (isset($qty_keluar)){
                        echo "<td>".$qty_keluar."</td>";
                    } else {
                    echo "<td>0</td>";
                    }

                
                ?>


            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2"></th>
            <th><?php echo $total_qty_masuk; ?></th>
            <th><?php echo $total_qty_keluar; ?></th>
        </tr>
        </tfoot>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#tabel_riwayat_stok').DataTable( {
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