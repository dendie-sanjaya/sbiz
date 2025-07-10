<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN KINERJA SALES</h1></center>
	<fieldset style="border:2px solid black">
		<table width="100%">
			<tr>
				<td style="font-size:12pt" width="25%">STATUS PENJUALAN</td>
				<td style="font-size:12pt" width="25%"> : 
					<?php 
						$statusPenjualanLabel['x'] = 'Semua';
						$statusPenjualanLabel[0] = 'Pemesanan / Sudah Bayar';
						$statusPenjualanLabel[1] = 'Pengemaasan';
						$statusPenjualanLabel[2] = 'Pengiriman';
						$statusPenjualanLabel[3] = 'Selesai';
						$statusPenjualanLabel[4] = 'Belum Bayar';
					?>	
					<?php echo $statusPenjualanLabel[$statusOrder] ?>
				</td>
				<td style="font-size:12pt" width="25%">VALIDASI PEMBAYARAN</td>
				<td style="font-size:12pt" width="25%"> : 
					<?php 
						$statusPaymentLabel['x'] = 'Semua';
						$statusPaymentLabel[0] = 'Belum di Validasi';
						$statusPaymentLabel[1] = 'Sudah di Validasi';
					?>	
					<?php echo $statusPaymentLabel[$statusPayment] ?>
				</td>
			</tr>
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
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">TANGGAL TRANSAKSI</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JUMLAH TRANSAKSI</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JUMLAH NILAI TRANSAKSI</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">KOMISI SALES</th>						
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalTransaction = 0; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php $totalKomisi = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center" sty><?php echo $i ?></td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="left">
									<?php echo $val['date_order_format'] ?>
								</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $val['total_transaction'] ?> Transaksi </td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo number_format($val['total_nilai'],0,'','.') ?></td>							
							<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo number_format($val['total_fee_sales'],0,'','.') ?></td>							

							<?php $totalTransaction += $val['total_transaction']; ?>
							<?php $totalNilaiJual += $val['total_nilai'] ?>
							<?php $totalKomisi += $val['total_fee_sales']; ?>							
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<tfoot>
						<tr>
							<th style="padding:5px; font-size:12pt; border:1px solid black" colspan="2" align="center">TOTAL</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo $totalTransaction ?> TRANSAKSI</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($totalNilaiJual,0,'.','.') ?></th>
							<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($totalKomisi,0,'.','.') ?></th>
							<th>&nbsp;</th>
						</tr> 
					</tfoot>							
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
