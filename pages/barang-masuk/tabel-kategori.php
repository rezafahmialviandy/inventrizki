<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No</th>
            <th width="80%">Nama</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            <?php
                //Koneksi database
                include '../../config/database.php';
                // perintah sql untuk menampilkan daftar kategori
                $sql="select * from kategori order by id_kategori desc";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['nama_kategori']; ?></td>
                <td>
                <button class="tombol_edit btn btn-warning btn-circle" id_kategori="<?php echo $data['id_kategori']; ?>"data-toggle="tooltip" title="Edit kategori" data-placement="top"><i class="fa fa-edit"></i></button>
                <button class="tombol_hapus btn btn-danger btn-circle" nama_kategori="<?php echo $data['nama_kategori']; ?>" id_kategori="<?php echo $data['id_kategori']; ?>" data-toggle="tooltip" title="Hapus kategori" data-placement="top" ><i class="fa fa-trash"></i></button>
                </td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script>

$('.tombol_edit').on('click',function(){
    var id_kategori = $(this).attr("id_kategori");
    $.ajax({
        url: 'pages/kategori/edit.php',
        method: 'post',
        data: {id_kategori:id_kategori},
        success:function(data){
            $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Kategori';
        }
    });
    // Membuka modal
    $('#modal').modal('show');
});


$('.tombol_hapus').on('click',function(){
    var nama_kategori = $(this).attr("nama_kategori");
    var agree=confirm("Adakah Anda yakin ingin menghapus kategori "+nama_kategori+"?");
    if (!agree){
        return false;
    } else {
        var id_kategori = $(this).attr("id_kategori");
        $.ajax({
            url: 'pages/kategori/ajax/hapus.php',
            method: 'post',
            data: {id_kategori:id_kategori},
            success:function(data){
                tabel_kategori();
            }
        });
    }
});

</script>