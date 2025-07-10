<?php ob_start(); ?>
	<?php include 'detailRead.php' ?>
	<br />
	<?php if(!isset($_REQUEST['date'])) : ?>
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
				<?php if($type == 1): ?>
					<table width="100%">
						<thead>
							<th style="font-size:12px; font-weight:bold" align="center">NO</th>
							<th style="font-size:12px; font-weight:bold" align="center">NO SALES ORDER</th>
							<th style="font-size:12px; font-weight:bold" align="center">NAMA PEMBELI</th>
							<th style="font-size:12px; font-weight:bold" align="center">NAMA SALES</th>
						</thead>
						<?php $j=1 ?>
						<tbody>
						<?php $jumlah = 0 ?>
						<?php while($rowdataSub = mysql_fetch_array($data)): ?>
							<tr>
								<td style="font-size:12px"  align="center"><?php echo $j ?></td>
								<td style="font-size:12px"  align="center"><a target="_blank" href="../salesOrder/print.php?id=<?php echo $rowdataSub['id'] ?>"><?php echo $rowdataSub['no_order'] ?></a></td>
								<td style="font-size:12px"  align="center"><?php echo $rowdataSub['name'] ?></td>
								<td style="font-size:12px"  align="center"><?php echo $rowdataSub['sales_name'] ?></td>
							</tr>	
							<?php $jumlah = $jumlah + $rowdataSub['total_nilai'] ?>
							<?php $j++ ?>	
						<?php endwhile; ?>	
						</tbody>									
					</table>	
				<?php else: ?>
					<table width="100%">
						<thead>
							<th style="font-size:12px; font-weight:bold" align="center">NO</th>
							<th style="font-size:12px; font-weight:bold" align="center">JAM</th>
							<th style="font-size:12px; font-weight:bold" align="center">NO SALES ORDER</th>
							<th style="font-size:12px; font-weight:bold" align="center">USER INPUT</th>
						</thead>
						<?php $j=1 ?>
						<tbody>
						<?php $jumlah = 0 ?>
						<?php while($rowdataSub = mysql_fetch_array($data)): ?>
							<tr>
								<td style="font-size:12px"  align="center"><?php echo $j ?></td>
								<td style="font-size:12px"  align="center"><?php echo $rowdataSub['date_track'] ?></td>
								<td style="font-size:12px"  align="center"><a target="_blank" href="../salesOrder/print.php?id=<?php echo $rowdataSub['sales_order_id'] ?>"><?php echo $rowdataSub['no_sales_order'] ?></a></td>
								<td style="font-size:12px"  align="center"><?php echo $rowdataSub['member_name'] ?><small> (<?php echo $rowdataSub['username'] ?>)</small></td>
							</tr>	
							<?php $j++ ?>	
						<?php endwhile; ?>	
						</tbody>									
					</table>	
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>	
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>
