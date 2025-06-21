
<script>
$('title').text('DAFTAR STOK BARANG');
</script>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tabel_stok_saat_ini" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Kategori</th>
            <th>Nama</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Stok Akhir</th>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';

                // perintah sql
                $sql="select i.*,b.*,(m.stok) as barang_masuk,(k.stok) as barang_keluar from barang b
                left join kategori i on i.id_kategori=b.kategori_barang
                left join stok_barang_masuk m on m.kode_barang=b.kode_barang
                left join stok_barang_keluar k on k.kode_barang=b.kode_barang";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                $total_masuk=0;
                $total_keluar=0;
                $total_semua=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
                $total_masuk+= $data['barang_masuk']; 
                $total_keluar+=$data['barang_keluar']; 
                $total_semua+=$data['barang_masuk']-$data['barang_keluar']; 
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kode_barang']; ?></td>
                <td><?php echo $data['nama_kategori']; ?></td>
                <td><?php echo $data['nama_barang']; ?></td>
                <td><?php echo $data['barang_masuk']; ?></td>
                <td><?php echo $data['barang_keluar']; ?></td>
                <td><?php echo $data['barang_masuk']-$data['barang_keluar']; ?></td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4"></th>
            <th><?php echo $total_masuk; ?></th>
            <th><?php echo $total_keluar; ?></th>
            <th><?php echo $total_semua; ?></th>
        </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tabel_stok_saat_ini').DataTable( {
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