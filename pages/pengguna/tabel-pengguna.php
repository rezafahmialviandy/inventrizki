<div class="table-responsive">
    <table class="table table-bordered table-striped" id="tabel_pengguna" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th width="60%">Nama</th>
            <th>Username</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';
                // perintah sql untuk menampilkan daftar pengguna
                $sql="select * from pengguna order by id_pengguna desc";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['nama_pengguna']; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['level']; ?></td>
                <td>
                    <button class="tombol_set_password btn btn-primary btn-circle" id_pengguna="<?php echo $data['id_pengguna']; ?>"data-toggle="tooltip" title="Setting Password" data-placement="top"><i class="fa fa-lock"></i></button>
                    <button class="tombol_edit btn btn-warning btn-circle" id_pengguna="<?php echo $data['id_pengguna']; ?>"data-toggle="tooltip" title="Edit Pengguna" data-placement="top"><i class="fa fa-edit"></i></button>
                    <button class="tombol_hapus btn btn-danger btn-circle" nama_pengguna="<?php echo $data['nama_pengguna']; ?>" id_pengguna="<?php echo $data['id_pengguna']; ?>" data-toggle="tooltip" title="Hapus Pengguna" data-placement="top" ><i class="fa fa-trash"></i></button>
                </td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tabel_pengguna').DataTable( {
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

$('.tombol_set_password').on('click',function(){
    var id_pengguna = $(this).attr("id_pengguna");
    $.ajax({
        url: 'pages/pengguna/setting-password.php',
        method: 'post',
        data: {id_pengguna:id_pengguna},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Setting Password';
        }
    });
    // Membuka modal
    $('#modal').modal('show');
});

$('.tombol_edit').on('click',function(){
    var id_pengguna = $(this).attr("id_pengguna");
    $.ajax({
        url: 'pages/pengguna/edit.php',
        method: 'post',
        data: {id_pengguna:id_pengguna},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit pengguna';
        }
    });
    // Membuka modal
    $('#modal').modal('show');
});


$('.tombol_hapus').on('click',function(){
    var nama_pengguna = $(this).attr("nama_pengguna");
    var agree=confirm("Adakah Anda yakin ingin menghapus pengguna "+nama_pengguna+"?");
    if (!agree){
        return false;
    } else {
        var id_pengguna = $(this).attr("id_pengguna");
        $.ajax({
            url: 'pages/pengguna/ajax/hapus.php',
            method: 'post',
            data: {id_pengguna:id_pengguna},
            success:function(data){
                tabel_pengguna();
            }
        });
    }
});

</script>