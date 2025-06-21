
<?php
   include '../../config/database.php';
   $tahun=date('Y');
    for($bulan = 1;$bulan <= 12;$bulan++)
    {

        $hasil1=mysqli_query($kon,"select sum(qty) as total from detail_barang_masuk dm inner join barang_masuk m on m.kode_transaksi=dm.kode_transaksi where MONTH(tanggal)='$bulan' and YEAR(tanggal)='$tahun'");
        $data1=mysqli_fetch_array($hasil1);
        $qty_masuk[] = $data1['total'];

        $hasil2=mysqli_query($kon,"select sum(qty) as total from detail_barang_keluar dk inner join barang_keluar k on k.kode_transaksi=dk.kode_transaksi where MONTH(tanggal)='$bulan' and YEAR(tanggal)='$tahun'");
        $data2=mysqli_fetch_array($hasil2);
        $qty_keluar[] = $data2['total'];
    }
?>
<canvas id="grafik_penjualan" height="60px"></canvas>

<script>
    var ctx = document.getElementById("grafik_penjualan").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:  ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],
            datasets: [{
                label: 'Barang Masuk',
                data: <?php echo json_encode($qty_masuk); ?>,
                backgroundColor: '#ff6600',
                borderWidth: 1
            },{
                label: 'Barang Keluar',
                data: <?php echo json_encode($qty_keluar); ?>,
                backgroundColor: '#999966',
                borderWidth: 1
            }]
        },
      options: {
            maintainAspectRatio: true,
            layout: {
            padding: {
                left: 10,
                right: 10,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'month'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 30
                },
                maxBarThickness: 25,
            }],
    
            },
            legend: {
            display: false
            },
         }
    });
</script>