<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN PENJUALAN DAN KOMISI</h1></center>
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
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">NAMA</th>						
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">JUMLAH TRANSAKSI</th>
							<th style="padding:5px; font-size:10pt; border:1px solid black" align="center" width="%" style="font-size: 11px">JUMLAH NILAI TRANSAKSI <br />UNTUK RESELLER</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">KOMISI RESELLER</th>													
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="%">POIN RESELLER</th>													
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalTransaksi = 0; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php $totalKomisi = 0; ?>						
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center" sty><?php echo $i ?></td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center">
									<?php echo $val['reseller_name'] ?>
								</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $val['total_transaction'] ?> Transaksi</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo number_format($val['total_nilai'],0,'','.') ?></td>							
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo number_format($val['total_fee_reseller'],0,'','.') ?></td>							
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $val['total_poin'] ?></td>							
							</tr>												

							<?php $totalTransaksi = $totalTransaksi + $val['total_transaction'] ?>	
							<?php $totalNilaiJual = $totalNilaiJual + $val['total_nilai'] ?>
							<?php $totalKomisi = $totalKomisi + $val['total_fee_reseller'] ?>
							<?php $totalPoin = $totalPoin + $val['total_poin'] ?>
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<tfoot>
						<th style="padding:5px; font-size:12pt; border:1px solid black" colspan="2">TOTAL</th>
						<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($totalTransaksi,0,'','.') ?> Transaksi</th>
						<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($totalNilaiJual,0,'','.') ?></th>
						<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo number_format($totalKomisi,0,'','.') ?></th>
						<th style="padding:5px; font-size:12pt; border:1px solid black"><?php echo $totalPoin ?></th>
					</tfoot>	
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
