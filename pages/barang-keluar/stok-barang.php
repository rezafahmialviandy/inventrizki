
<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama</th>
            <th>Stok</th>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';

                // perintah sql
                $sql="select b.*,(m.stok) as barang_masuk,(k.stok) as barang_keluar from barang b
                left join stok_barang_masuk m on m.kode_barang=b.kode_barang
                left join stok_barang_keluar k on k.kode_barang=b.kode_barang";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kode_barang']; ?></td>
                <td><?php echo $data['nama_barang']; ?></td>
                <td><?php echo $data['barang_masuk']-$data['barang_keluar']; ?></td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

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