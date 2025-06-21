<div class="table-responsive">
    <table class="table table-bordered table-striped" id="tabel_barang" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th width="13%">Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
            //Koneksi database
            include '../../config/database.php';
            //perintah sql untuk menampilkan daftar barang
            $sql="select * from barang b left join kategori k on k.id_kategori=b.kategori_barang left join supplier s on s.id_supplier=b.supplier order by b.id_barang desc";
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
            <td><?php echo $data['satuan']; ?></td>
            <td><?php echo $data['nama_kategori']; ?></td>
            <td><?php echo $data['nama_supplier']; ?></td>
            <td>Rp. <?php echo number_format($data['harga_beli'],0,',','.'); ?></td>
            <td>Rp. <?php echo number_format($data['harga_jual'],0,',','.'); ?></td>
            <td>
                <button class="tombol_edit btn btn-warning btn-circle" id_barang="<?php echo $data['id_barang']; ?>" kode_barang="<?php echo $data['kode_barang']; ?>" data-toggle="tooltip" title="Edit barang" data-placement="top"><i class="fa fa-edit"></i></button>
                <button class="tombol_hapus btn btn-danger btn-circle" nama_barang="<?php echo $data['nama_barang']; ?>" id_barang="<?php echo $data['id_barang']; ?>" kode_barang="<?php echo $data['kode_barang'];?>" ><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <!-- bagian akhir (penutup) while -->
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tabel_barang').DataTable( {
            "searching": true,
            "paging":   true,
            "ordering": true,
            "info":     true,
            dom: 'Bfrtip',
            buttons: ['excel','print','copy']
        });
    });
</script>

<script>

$('.tombol_edit').on('click',function(){
    var id_barang = $(this).attr("id_barang");
    $.ajax({
        url: 'pages/barang/edit.php',
        method: 'post',
        data: {id_barang:id_barang},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit barang';
        }
    });
    // Membuka modal
    $('#modal').modal('show');
});


$('.tombol_hapus').on('click',function(){
    var nama_barang = $(this).attr("nama_barang");
    var agree=confirm("Adakah Anda yakin ingin menghapus barang "+nama_barang+" ?");
    if (!agree){
        return false;
    } else {
        var id_barang = $(this).attr("id_barang");
        $.ajax({
            url: 'pages/barang/ajax/hapus.php',
            method: 'post',
            data: {id_barang:id_barang},
            success:function(data){
                tabel_barang();
            }
        });
    }
});

</script>