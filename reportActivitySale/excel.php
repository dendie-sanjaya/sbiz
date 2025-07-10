<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN AKTIVITAS SALE.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN AKTIVITAS PENJUALAN</h1></center>
	<fieldset style="border:2px solid black">
		<legend style="font-size:14pt"><b>INFORMASI</b></legend>
		<table width="100%">			
			<tr>
				<td width="20%">DARI TANGGAL </td>
				<td width=""> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
			</tr>
			<tr>
				<td width="20%">SAMPAI TANGGAL </td>
				<td> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
			</tr>

		</table>		
	</fieldset>

	<?php if(!isset($_REQUEST['dateFrom'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('filterData') ?></h3>
		</div>		
	<?php else: ?>	
		<?php if(count($dataSum) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<p></p>
			<div id="tbl">
				<table width="100%" cellpadding="0" cellspacing="0">
					<thead>			
						<tr>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="5%">NO</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="20%">TANGGAL</th>						
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="20%">PENJUALAN</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="20%">VALIDASI PEMBAYARAN</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="20%">PENGEMASAN</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="%">PENGIRIMAN</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="%">HAPUS PENJUALAN</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php foreach($dataSum as $key => $val): ?>
							<tr>
								<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center"><?php echo $i ?></td>
								<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center">
									<?php echo date('d M Y ',strtotime($key)) ?>		
								</td>
								<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center">
									<?php echo $val['order'] ?> Transaksi
								</td>
								<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center">
									<?php echo $val['validationPayment'] ?> Transaksi
								</td>
								<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center">
									<?php echo $val['packing'] ?> Transaksi
								</td>
								<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center">
									<?php echo $val['shipping'] ?> Transaksi
								</td>
								<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center">
									<?php echo $val['deleteOrder'] ?> Transaksi
								</td>

							<?php $i++; ?>
						<?php endforeach; ?>
					<tbody>
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	

	<p></p>
	<br />
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
