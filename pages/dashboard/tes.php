
<?php
   include 'config/database.php';
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
<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],
		datasets : [
			{
   
				fillColor : "#ffff00",
				strokeColor : "#e6e600",
				highlightFill: "#ffff4d",
				highlightStroke: "#ffff33",
				data : <?php echo json_encode($qty_masuk); ?>
			},
            {
    
				fillColor : "#2eb82e",
				strokeColor : "#29a329",
				highlightFill : "#2eb82e",
				highlightStroke : "#33cc33",
				data :<?php echo json_encode($qty_keluar); ?>
			}
		]
	}

        //Memanggil chart
        window.onload = function(){

            var bar = document.getElementById("grafik").getContext("2d");
            window.myBar = new Chart(bar).Bar(barChartData, {
                responsive : true
            });
        };



	</script>




    
 

