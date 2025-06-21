<div class="table-responsive">
    <table class="table table-bordered table-striped" id="tabel_supplier" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';
                // perintah sql untuk menampilkan daftar supplier
                $sql="select * from supplier order by id_supplier desc";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['kode_supplier']; ?></td>
                <td><?php echo $data['nama_supplier']; ?></td>
                <td><?php echo $data['no_telp']; ?></td>
                <td><?php echo $data['alamat_supplier']; ?></td>
                <td><?php echo $data['status'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
                <td>
                <button class="tombol_edit btn btn-warning btn-circle" id_supplier="<?php echo $data['id_supplier']; ?>" kode_supplier="<?php echo $data['kode_supplier']; ?>" data-toggle="tooltip" title="Edit supplier" data-placement="top"><i class="fa fa-edit"></i></button>
                <button class="tombol_hapus btn btn-danger btn-circle" nama_supplier="<?php echo $data['nama_supplier']; ?>" id_supplier="<?php echo $data['id_supplier']; ?>" kode_supplier="<?php echo $data['kode_supplier'];?>"  data-toggle="tooltip" title="Hapus supplier" data-placement="top" ><i class="fa fa-trash"></i></button>
                </td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tabel_supplier').DataTable( {
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
    var id_supplier = $(this).attr("id_supplier");
    $.ajax({
        url: 'pages/supplier/edit.php',
        method: 'post',
        data: {id_supplier:id_supplier},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Supplier';
        }
    });
    // Membuka modal
    $('#modal').modal('show');
});


$('.tombol_hapus').on('click',function(){
    var nama_supplier = $(this).attr("nama_supplier");
    var agree=confirm("Adakah Anda yakin ingin menghapus supplier "+nama_supplier+"?");
    if (!agree){
        return false;
    } else {
        var id_supplier = $(this).attr("id_supplier");
        $.ajax({
            url: 'pages/supplier/ajax/hapus.php',
            method: 'post',
            data: {id_supplier:id_supplier},
            success:function(data){
                tabel_supplier();
            }
        });
    }
});

</script>