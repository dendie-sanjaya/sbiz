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
						<th style="font-size:12px; font-weight:bold" align="center">TGL PENJUALAN</th>
						<th style="font-size:12px; font-weight:bold" align="center">NO SALES ORDER</th>
						<th style="font-size:12px; font-weight:bold" align="center">PEMBELIAN</th>
						<th style="font-size:12px; font-weight:bold" align="center">DISKON</th>
						<th style="font-size:12px; font-weight:bold" align="center">BIAYA KIRIM</th>
						</thead>
					<?php $j=1 ?>
					<tbody>
					<?php $grandTotalPembelian = 0 ?>
					<?php $grandTotalDiskon = 0 ?>
					<?php $grandTotalBiayaKirim = 0 ?>
					<?php $jumlah = 0 ?>
					<?php while($rowdataSub = mysql_fetch_array($data)): ?>
						<tr>
							<td style="font-size:12px"  align="center"><?php echo $j ?></td>
							<td style="font-size:12px"  align="center"><?php echo $rowdataSub['date_order_frm'] ?></td>
							<td align="center"><a href="../salesOrder/print.php?id=<?php echo $rowdataSub['id'] ?>" target="_blank"><?php echo $rowdataSub['no_order'] ?></a></td>							
							<td style="font-size:12px"  align="center"><?php echo number_format($rowdataSub['total_pembelian'],0,'','.') ?></td>
							<td style="font-size:12px"  align="center"><?php echo number_format($rowdataSub['total_diskon'],0,'','.') ?></td>
							<td style="font-size:12px"  align="center"><?php echo number_format($rowdataSub['total_pengiriman'],0,'','.') ?></td>
						</tr>	
						<?php $j++ ?>	
						<?php $grandTotalPembelian = $grandTotalPembelian + $rowdataSub['total_pembelian'] ?>
						<?php $grandTotalDiskon = $grandTotalDiskon + $rowdataSub['total_diskon'] ?>
						<?php $grandTotalBiayaKirim = $grandTotalBiayaKirim +$rowdataSub['total_pengiriman']  ?>						
					<?php endwhile; ?>	
						<tr>
							<th colspan="3" align="center">TOTAL</th>
							<th style="font-size:12px"  align="center"><?php echo number_format($grandTotalPembelian,0,'','.') ?></th>
							<th style="font-size:12px"  align="center"><?php echo number_format($grandTotalDiskon ,0,'','.') ?></th>
							<th style="font-size:12px"  align="center"><?php echo number_format($grandTotalBiayaKirim,0,'','.') ?></th>
						</tr>
					</tbody>									
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>
