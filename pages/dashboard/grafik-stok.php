<?php
    include '../../config/database.php';
    $sql="select b.nama_barang,(am.stok-k.stok) as stok from barang b
    left join kategori i on i.id_kategori=b.kategori_barang
    left join stok_barang_masuk am on am.kode_barang=b.kode_barang
    left join stok_barang_keluar k on k.kode_barang=b.kode_barang";  
    $hasil=mysqli_query($kon,$sql);
    $no=0;

    while ($data = mysqli_fetch_array($hasil)) {
      $stok[] = $data['stok'];
      $nama_barang[] = $data['nama_barang'];  
    }

  ?>
<!-- Menampilkan Pie Chart -->
<canvas id="grafik_stok"  height="250px"></canvas>

<script>
    var ctx = document.getElementById("grafik_stok");
    var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($nama_barang); ?>,
        datasets: [{
          data: <?php echo json_encode($stok); ?>,
          backgroundColor: ['#33cc33', '#0066ff', '#ffff00','#ff0000','#ff8000',' #e600ac','#a31aff','#999966','#aaff00'],
          hoverBackgroundColor: ['#47d147', '#3385ff', '#ffff4d', '#ff1a1a', ' #ff8c1a','#ff00bf','#ad33ff','#a3a375','#b3ff1a'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
      },
    });
</script>