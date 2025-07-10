<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<h1>DASHBOARD</h1>
	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<table width="100%">
			<?php if(in_array($_SESSION['loginPosition'], array('1','3','4','5'))): ?>
			<tr>
				<td width="30%">PENJUALAN HARI INI</td>
				<td width="17%">
					<a href="../salesOrder/index.php"><big><?php echo $dataJmlPenjualanLangsungHariIni['total'] ?></big> TRANSAKSI</a>
				</td>
				<?php if(in_array($_SESSION['loginPosition'], array('1','4','5'))): ?>
				<td width="33%">VALIDASI PEMBAYARAN</td>
				<td>
					<a href="../salesPayment/index.php"><big><?php echo $dataJmlPembayaranBelumValidasi['total'] ?></big> TRANSAKSI</a>
				</td>
				<?php endif; ?>
			</tr>
			<?php endif; ?>
			<?php if(in_array($_SESSION['loginPosition'], array('1','4','5'))): ?>
			<tr>
				<td width="30%">PENJUALAN RESELLER HARI INI</td>
				<td>
					<a href="../salesOrderReseller/index.php"><big><?php echo $dataJmlPenjualanLangsungHariIniReseller['total'] ?></big> TRANSAKSI</a>
				</td>
				
				<?php if(in_array($_SESSION['loginPosition'], array('1','4','5'))): ?>
				<td width="25%">VALIDASI RESELLER COD</td>
				<td>
					<a href="../salesCod/index.php"><big><?php echo $dataJmlPembayaranBelumValidasiResellerCod['total'] ?></big> TRANSAKSI</a>
				</td>
				<?php endif; ?>
			</tr>						
			<?php endif; ?>
			<?php if(in_array($_SESSION['loginPosition'], array('1','2','4','5'))): ?>
			<tr>
				<td>PENJUALAN BELUM DIKEMAS</td>
				<td>
					<a href="../salesPacking/index.php"><big><?php echo $dataJmlPembayaranBelumPacking['total'] ?></big> TRANSAKSI</a>
				</td>				
				<td >PENJUALAN BELUM DIKIRIM <sup style="font-size: 11px">(Via Ekspedisi)</sup></td>
				<td>
					<a href="../salesShipping/index.php"><big><?php echo $dataJmlPenjualanBelumBayar['total'] ?></big> TRANSAKSI</a>
				</td>
			</tr>

			<tr>
				<td>PENJUALAN BELUM BAYAR</td>
				<td>
				   <a href="../salesUnpaid/index.php"><big><?php echo $dataJmlPenjualanBelumBayar['total'] ?></big> TRANSAKSI</a>					
				</td>
				<td >PENJUALAN BELUM DIKIRIM <sup style="font-size: 11px">(Via Gdg Eksternal)</sup></td>
				<td>
					<a href="../salesShippingWarehouseExternal/index.php"><big><?php echo $dataJmlPembayaranBelumShippingWarehouseExternal['total'] ?></big> TRANSAKSI</a>
				</td>
			</tr>
			<?php endif; ?>
		</table>	
	<br />
	</fieldset>
	<br /><br />

	<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
	<fieldset>
		<legend><b>PENDAPATAN HARI INI</b></legend>

		<table width="100%">
			<tr>
				<td width="30%">TOTAL HARGA DASAR</td>
				<td width="17%" style="font-weight: bold; color:green">
				  <?php echo number_format($dataRevenue['total_price_basic'],0,'','.') ?>	
				</td>				
				<td width="33%">TOTAL DISKON PERSEN</td>
				<td width="17%"style="font-weight: bold; color:green">
				  <?php echo number_format($dataRevenue['total_discount_percent'],0,'','.') ?>						
				</td>				
			</tr>						
			<tr>
				<td>TOTAL HARGA JUAL</td>
				<td style="font-weight: bold; color:green">					
				  <?php echo number_format($dataRevenue['total_price'],0,'','.') ?>						
				</td>				
				<td>TOTAL DISKON NOMINAL</td>
				<td style="font-weight: bold; color:green">
				  <?php echo number_format($dataRevenue['total_discount_nominal'],0,'','.') ?>						
				</td>				
			</tr>						
			<tr>
				<td>TOTAL HARGA JUAL<sup style="font-size: 10px">(Setelah Diskon)</sup></td>
				<td style="font-weight: bold; color:green">
				  <?php echo number_format($dataRevenue['total_price_after_discount'],0,'','.') ?>						
				</td>				
				<td >TOTAL BIAYA KIRIM</td>
				<td style="font-weight: bold; color:green">
				  <?php echo number_format($dataRevenue['total_shipping'],0,'','.') ?>						
				</td>				
			</tr>						
			<tr>
				<td>LABA SETELAH DISKON</td>
				<td style="font-weight: bold; color:green"><?php echo number_format($dataRevenue['total_profit_after_discount'],0,'','.') ?></td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>				
			</tr>						
		</table>

		<ul style="letter-spacing: 1px; line-height: 1.5; font-size: 10px; margin-left: -25px; margin-top:20px" >
			<li>Data pendapatan hari ini adalah penjualan dengan status penjualan <b>sudah bayar</b> termasuk yg <b>belum di validasi bayar</b></li>				
		</ul>
	</fieldset>
	<br /><br />
	<?php endif; ?>

	<?php if(in_array($_SESSION['loginPosition'],array('1','3','4'))): ?>
	<fieldset>
		<legend><b>GRAFIK PENJUALAN</b></legend>
		<div style="font-size: 11px; margin: 10px 0px 30px 0px;  width: 100%; ">
		  <ul style="letter-spacing: 1px; line-height: 1.5">	
			  <li>Di bawah ini adalah grafik penjualan dengan status penjualan <b>sudah bayar</b> dan sudah di <b>validasi bayar</b></li>
			  <?php if(in_array($_SESSION['loginPosition'],array('1'))): ?>
			  	 <li>Jumlah pendapatan rupiah dihitung dengan rumus total (Harga Jual - Diskon) pada hari tertentu</li>		
			  <?php endif; ?>
			  <li>Grafik di bawah ini adalah semua hasil penjualan dari <b><?php echo $_SESSION['loginPosition'] == '1' ? 'semua sales' : 'Anda'  ?> </li>		
		  </li>	  
		</div>		
		<?php if(in_array($_SESSION['loginPosition'],array('1','4'))): ?>
			<div id="container" style="width: 50%; float: right;">
				<canvas id="canvas"></canvas>
			</div>		

			<div id="container" style="width: 50%;">
				<canvas id="canvas-2"></canvas>
			</div>		
		<?php else:  ?>
			<div id="container" style="width: 100%;">
				<canvas id="canvas"></canvas>
			</div>				
		<?php endif; ?>	
	</fieldset>
	<br /><br />	

	<?php endif; ?>	


	<form action="index.php" method="post">	
	<p style="text-align:right">	
		<b>KATEGORI BARANG</b> 
		<select name="categoryId" style="width:230px" onchange="this.form.submit()">
			<option value="x">-- Semua --</option>
			<?php while($val = mysql_fetch_array($dataCategory)): ?>
				<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
			<?php endwhile; ?>
		</select>					
	</p>
	</form>

	<fieldset>
		<legend><b>PENGINGAT PERSEDIAN BARANG MENIPIS</b></legend>
		<?php if(mysql_num_rows($data) < 1) : ?>
		 	<div class="info">
				<h3>SELURUH BARANG DALAM PERSEDIAN CUKUP</h3>
			</div>		
		<?php else: ?>
			<table width="100%">
				<tr>
					<td>		
						<p style="text-align:right">
							<input type="button" value="PRINT" onclick="window.open('print.php?categoryId=<?php echo $categoryId ?>')" />
							<input type="button" value="EXPORT TO EXCEL" onclick="window.open('excel.php?categoryId=<?php echo $categoryId ?>')" />
						</p>					
					</td>
				</tr>
			</table>			
					
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="35%">NAMA BARANG</th>
							<th align="center" width="20%">STOK SAAT INI</th>
							<th align="center" width="20%">MINIMUM STOK</th>
							<th></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td>
									<?php echo $val['name'] ?><br />
									<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
								</td>
								<td align="center">
									<b>
										<?php echo $val['stock'] ?>
										<?php echo $val['const_name'] ?>
									</b>
								</td>
								<td align="center">
									<?php echo $val['stock_min_alert'] ?>
									<?php echo $val['const_name'] ?>
								</td>
								<td align="center">
									<a href="../reportStock/detail.php?stuffId=<?php echo $val['id'] ?>"> CATATAN TRANSAKSI </a>
								</td>
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
			</div>
		<?php endif; ?>
	</fieldset>

	<script src="../asset/js/chart.js-2.9.3/dist/Chart.min.js"></script>
	<script src="../asset/js/chart.js-2.9.3/samples/utils.js"></script>

	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
	
	<script type="text/javascript">		
		Chart.defaults.global.tooltips.callbacks.label = function(tooltipItem, data) {
		    return tooltipItem.yLabel.toLocaleString("id-US");
		};

		Chart.scaleService.updateScaleDefaults('linear', {
		    ticks: {
		        callback: function (value, index, values) {
		            return value.toLocaleString();
		        }
		    }
		});

		var color = Chart.helpers.color;
		var barChartData = {
			labels:<?php echo $grafikLabelTransaksi ?>,
			datasets: [{
				label: 'Transaksi',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 2,
				data: <?php echo $grafikValTransaksi ?>					
			}]
		};

		var color = Chart.helpers.color;
		var barChartDataRupiah = {
			labels:<?php echo $grafikLabelRupiah ?>,
			datasets: [{
				label: 'Rupiah',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 2,
				data: <?php echo $grafikValRupiah ?>					
			},]
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Grafik Penjualan (Jumlah Transaksi)'
					}
				}
			});


			var ctx2 = document.getElementById('canvas-2').getContext('2d');
			window.myBar = new Chart(ctx2, {
				type: 'bar',
				data: barChartDataRupiah,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Grafik Penjualan (Jumlah Rupiah)'
					}
				}
			});

		};
	</script>					
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
