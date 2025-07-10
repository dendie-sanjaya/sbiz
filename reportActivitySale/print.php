<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>REKAPITULASI AKTIVITAS PENJUALAN</h1></center>
	<fieldset style="border:2px solid black">
		<table width="100%">			
			<tr>
				<td>DARI TANGGAL </td>
				<td> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td>SAMPAI TANGGAL </td>
				<td> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
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
		<?php if(count($dataSum) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<div id="tbl">
				<table width="100%" cellpadding="0" cellspacing="0">
					<thead>			
						<tr>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="5%">NO</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="%">TANGGAL</th>						
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="%">PENJUALAN</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="%">VALIDASI PEMBAYARAN</th>
							<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="%">PENGEMASAN</th>
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
									<?php echo  $val['deleteOrder'] ?> Transaksi
								</td>
							<?php $i++; ?>
						<?php endforeach; ?>
					<tbody>
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
