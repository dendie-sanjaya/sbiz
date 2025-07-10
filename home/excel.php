<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=PENGINGAT PERSEDIAAN BARANG MENIPIS.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<center><h1>PENGINGAT PERSEDIAN BARANG MENIPIS</h1></center>

			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="35%">NAMA BARANG</th>
							<th align="center" width="20%">STOK SAAT INI</th>
							<th align="center">MINIMUM STOK</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td>
									<?php echo $val['name'] ?><br />
									<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
								</td>
								<td align="center">
									<b>
										<?php echo $val['stock'] ?>
										<?php echo $val['const_name'] ?>
									</b>
								</td>
								<td align="center">
									<?php echo $val['stock_min_alert'] ?>
									<?php echo $val['const_name'] ?>
								</td>
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
			</div>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/excel.php' ?>	
