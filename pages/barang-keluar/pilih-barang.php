<?php
    // include database
    include '../../config/database.php';

    $kategori=$_POST['kategori'];

    $page = (isset($_POST['page']))? $_POST['page'] : 1;
    $limit = 3; 
    $limit_start = ($page - 1) * $limit;
    $no = $limit_start + 1;
    // perintah sql untuk menampilkan daftar barang yang berelasi dengan tabel kategori barang
    $sql="select b.*,(m.stok) as barang_masuk,(k.stok) as barang_keluar from barang b
    left join stok_barang_masuk m on m.kode_barang=b.kode_barang
    left join stok_barang_keluar k on k.kode_barang=b.kode_barang
    where kategori_barang='".$kategori."' 
    order by b.id_barang desc limit $limit_start,$limit";
    $hasil=mysqli_query($kon,$sql);
    while ($data = mysqli_fetch_array($hasil)):

        if ($data['barang_masuk']-$data['barang_keluar']==0){
            continue;
        }
        
?>

    <div class="card">
        <div class="card bg-basic">
            <div class="card-body">
            <div class="row">
            <div class="col-sm-5">
                <img src="pages/barang/foto/<?php echo $data['foto_barang'];?>" width="102px" alt="Card image cap">
            </div>
            <div class="col-sm-7">
                <h5 class="m-0 font-weight-bold text-primary" ><b><?php echo $data['nama_barang'];?></b></h5>

           
                <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                    <input type="number" value="1" min="1"  id="jumlah<?php echo $no; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                <button type="button" data-toggle="tooltip" title="Tambah" no="<?php echo $no; ?>" qty_maks="<?php echo $data['barang_masuk']-$data['barang_keluar'];?>" kode_barang="<?php echo $data['kode_barang'];?>" id_barang="<?php echo $data['id_barang'];?>" aksi="tambah" class="tambahkan_ke_keranjang btn btn-primary"><i class="fa fa-plus"></i></button>
                </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    </div>
<br>
<?php $no++; endwhile; ?>
<p>Jumlah qty barang tidak boleh melebihi stok saat ini.<br> <a href="#" id="lihat_stok">Lihat daftar stok</a></p>
<nav class="mb-5">
  <ul class="pagination justify-content-end">
    <?php
      $query2     = mysqli_query($kon, "select * from barang b inner join stok_barang_masuk s on s.kode_barang=b.kode_barang where b.kategori_barang='".$kategori."' ");
      $jmldata    = mysqli_num_rows($query2);
      $jumlah_page = ceil($jmldata / $limit);
  
      for($i = 1; $i <= $jumlah_page; $i++){
        $link_active = ($page == $i)? ' active' : '';
        echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
      }

    ?>
  </ul>
</nav>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

<script>
    // Lihat stok
    $('#lihat_stok').on('click',function(){
        $.ajax({
            url: 'pages/barang-keluar/stok-barang.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Stok Barang';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>

<script>
  //Event saat tombol tambahkan keranjang dklik
  $('.tambahkan_ke_keranjang').on('click',function(){
      var aksi = $(this).attr("aksi");
      var kode_barang = $(this).attr("kode_barang");
      var no = $(this).attr("no");
      var jumlah=$("#jumlah"+no).val();
      var qty_maks = $(this).attr("qty_maks");

      $.ajax({
          url: 'pages/barang-keluar/keranjang.php',
          method: 'POST',
          data:{jumlah:jumlah,kode_barang:kode_barang,qty_maks:qty_maks,aksi:aksi},
          success:function(data){
              $('#tampil_cart').html(data);
          }
      }); 
  });
</script>