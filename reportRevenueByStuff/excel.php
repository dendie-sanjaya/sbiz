<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN PENJUALAN BARANG.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN PENJUALAN BARANG</h1></center>
	<fieldset style="border:2px solid black">
		<table width="100%">
			<tr>
				<td style="font-size:12pt" width="15%">DARI TANGGAL </td>
				<td style="font-size:12pt" width="25%"> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td style="font-size:12pt" width="15%">SAMPAI TANGGAL</td>
				<td style="font-size:12pt"> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
			</tr>
			<tr>
				<td style="font-size:12pt" width="15%">KATEGORI BARANG </td>
				<td style="font-size:12pt" colspan="3"> : 
					<?php while($val = mysql_fetch_array($dataCategoryPrint)): ?>
						<small><?php echo $val['name'] ?></small>,		
					<?php endwhile; ?>							
				</td>
			</tr>
		</table>
	</fieldset>
	<p></p>
	<br />
	<?php if(!isset($_REQUEST['dateFrom'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('filterData') ?></h3>
		</div>		
	<?php else: ?>	
		<?php if(mysql_num_rows($data) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<div id="tbl">
				<table width="100%" cellpadding="0" cellspacing="0">
					<thead>			
						<tr>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="5%">NO</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">NAMA BARANG</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JML BARANG TERJUAL</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JML HARGA DASAR TERJUAL</th>													
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JML NILAI TERJUAL</th>						
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php $totalHargaDasarJual = 0 ?>												
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center" sty><?php echo $i ?></td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="left">
									<?php echo $val['stuff_name'] ?>
									<?php if(strlen($strSalesId) > 0): ?>									
									<br />
									<span style="font-size:10px"><?php echo $val['nickname'] ?></span><br />
									<span style="font-size:10px">[Sales : <?php echo $val['sales_name'] ?>]</span>							
									<?php endif; ?>		
								</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $val['amount_total'] ?> <?php echo $val['satuan'] ?></td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"align="center"><?php echo $val['price_total_basic'] ?></td>													
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $val['price_total'] ?></td>							
							<?php $totalNilaiJual = $totalNilaiJual + $val['price_total'] ?>
							<?php $totalHargaDasarJual = $totalHargaDasarJual + $val['price_total_basic'] ?>														
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<tr>
						<th colspan="3" align="left" style="padding:5px; font-size:12pt; border:1px solid black">GRAND TOTAL</th>
						<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo $totalHargaDasarJual ?></th>						
						<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo $totalNilaiJual ?></th>
					</tr>	
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
