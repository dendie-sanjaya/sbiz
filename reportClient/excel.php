<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN PEDAGANG / RESSELER.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN PEDAGANG / RESSELER</h1></center>
	<fieldset style="border:2px solid black">
		<legend style="font-size:14pt"><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td style="font-size:12pt" width="25%">DARI TANGGAL </td>
				<td style="font-size:12pt" width="25%"> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
			</tr>
			<tr>
				<td style="font-size:12pt">SAMPAI TANGGAL</td>
				<td style="font-size:12pt"> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
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
				<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid black">
					<thead>			
						<tr>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="5%">NO</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">NAMA PEDAGANG</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">TOTAL PEMBELIAN</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">TOTAL DISKON</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">TOTAL BIAYA KIRIM</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalHargaDasar = 0; ?>
						<?php $totalHargaJual = 0; ?>
						<?php $totalDiskon = 0; ?>
						<?php $totalLaba = 0; ?>
						<?php $totalBiayaKirim = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center" style="padding:5px; font-size:12pt; border:1px solid black"><?php echo $i ?></td>
								<td align="center" style="padding:5px; font-size:12pt; border:1px solid black"><?php echo $val['name'] ?></td>
								<td align="center" style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($val['total_pembelian'],0,'','.')?></td>							
								<td align="center" style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($val['total_diskon'],0,'','.')?></td>
								<td align="center" style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($val['total_pengiriman'],0,'','.')?>
							</tr>	
						<?php $i++; ?>							
						<?php endwhile; ?>
					<tbody>
				</table>				
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
