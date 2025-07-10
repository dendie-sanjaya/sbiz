<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN PEMBELIAN PELANGGAN.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN PEMBELIAN PELANGGAN</h1></center>
	<fieldset style="border:2px solid black">
		<legend style="font-size:14pt"><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td style="font-size:12pt" width="25%">VALIDASI PEMBAYARAN : 
					<?php 
						$statusPaymentLabel['x'] = 'Semua';
						$statusPaymentLabel[0] = 'Belum di Validasi';
						$statusPaymentLabel[1] = 'Sudah di Validasi';
					?>	
					<?php echo $statusPaymentLabel[$statusPayment] ?>
				</td>	
				<td>DARI TANGGAL : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td>SAMPAI TANGGAL : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
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
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">NAMA PEMBELI</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">TELEPON PEMBELI</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JUMLAH TRANSAKSI</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JUMLAH NILAI TRANSAKSI</th>						
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center" sty><?php echo $i ?></td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="left">
									<?php if(strlen($val['phone']) >0): ?>
										<?php echo $val['name'] ?>										
									<?php else: ?>
										<b>Tidak Ada Nomor Telepon</b>
									<?php endif; ?>	
								</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="left">
									<?php echo $val['phone'] ?>
								</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $val['total_transaction'] ?> Transaksi </td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $val['total_nilai'] ?></td>							
							</tr>								
							<?php $totalNilaiJual = $totalNilaiJual + $val['total_nilai'] ?>
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
