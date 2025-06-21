<?php
    include '../../config/database.php';
    $kategori=$_POST['kategori'];
    $results = array();
    $query = mysqli_query($kon, "select * from barang
    where kategori_barang='".$kategori."'");
    while ($data = mysqli_fetch_array($query)):
        $results[] = $data;
    endwhile;
    echo json_encode($results);
?>