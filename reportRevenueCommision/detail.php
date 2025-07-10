<?php ob_start(); ?>
	<?php include 'detailRead.php' ?>
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
				<table width="100%">
					<thead>
						<th style="font-size:12px; font-weight:bold" align="center">NO</th>
						<th style="font-size:12px; font-weight:bold" align="center" width="100">NO SALES ORDER</th>
						<th style="font-size:12px; font-weight:bold" align="center" width="150">TGL PENJUALAN</th>
						<th style="font-size:12px; font-weight:bold" align="center">NAMA PEMBELI</th>
						<th style="font-size:12px; font-weight:bold" align="center">NILAI TRANSAKSI</th>
						<th style="font-size:12px; font-weight:bold" align="center">KOMISI RESELLER</th>
						<th style="font-size:12px; font-weight:bold" align="center">POIN RESELLER</th>
					</thead>
					<?php $j=1 ?>
					<tbody>
					<?php $jumlah = 0 ?>
					<?php $totalKomisi = 0 ?>
					<?php while($rowdataSub = mysql_fetch_array($data)): ?>
						<tr>
							<td style="font-size:12px"  align="center"><?php echo $j ?></td>
							<td style="font-size:12px"  align="center"><a target="_blank" href="../salesOrder/print.php?id=<?php echo $rowdataSub['id'] ?>"><?php echo $rowdataSub['no_order'] ?></a></td>
							<td style="font-size:12px"  align="center"><?php echo $rowdataSub['date_order_frm'] ?></td>
							<td style="font-size:12px"  align="center">
								<?php echo $rowdataSub['name'] ?></td>
							<td style="font-size:12px"  align="center"><b><?php echo number_format($rowdataSub['total_nilai'],0,0,'.') ?></b></td>
							<td style="font-size:12px"  align="center"><b><?php echo number_format($rowdataSub['amount_fee_reseller'],0,0,'.') ?></b></td>
							<td style="font-size:12px"  align="center"><b><?php echo $rowdataSub['total_poin'] ?></b></td>
						</tr>	
						<?php $jumlah = $jumlah + $rowdataSub['total_nilai'] ?>
						<?php $totalKomisi = $totalKomisi + $rowdataSub['amount_fee_reseller'] ?>						
						<?php $totalPoin = $totalPoin + $rowdataSub['total_poin'] ?>						
						<?php $j++ ?>	
					<?php endwhile; ?>	
						<th colspan="4" align="center">TOTAL</th>
						<th style="font-size:12px; font-weight:bold" align="center"><?php echo number_format($jumlah,0,0,'.') ?></th>
						<th style="font-size:12px; font-weight:bold" align="center"><?php echo number_format($totalKomisi,0,0,'.') ?></th>																
						<th style="font-size:12px; font-weight:bold" align="center"><?php echo $totalPoin ?></th>																
					</tbody>									
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>
