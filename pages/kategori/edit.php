<?php 
    include '../../config/database.php';
    $id_kategori=addslashes(trim($_POST['id_kategori']));
    $sql="select * from kategori s where s.id_kategori='$id_kategori' limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>
<form id="form_edit">

    <div class="form-group">
        <input type="hidden" class="form-control" name="id_kategori" value="<?php echo $data['id_kategori'];?>" id="id_kategori">
    </div>


    <div class="form-group">
        <label>Nama kategori:</label>
        <input name="nama_kategori" type="text" value="<?php echo $data['nama_kategori'];?>" class="form-control" placeholder="Masukan nama" required>
    </div>

</form>

<button class="btn btn-primary btn-fill btn-wd" id="submit"  data-dismiss="modal" >Submit</button>


<script>
    $('#submit').click(function(){
        var form = $('#form_edit')[0];
        var data = new FormData(form);
        $.ajax({
            type	: 'POST',
            url: 'pages/kategori/ajax/edit.php',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success	: function(data){
                tabel_kategori();
            }
        });
    });
</script>

