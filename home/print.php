<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<center><h1>PENGINGAT PERSEDIAN BARANG MENIPIS</h1></center>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />

			<div id="tbl">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<thead>			
						<tr>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="5%">NO</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="35%">NAMA BARANG</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center" width="20%">STOK SAAT INI</th>
							<th style="padding:5px; font-size:12pt; border:1px solid black" align="center">MINIMUM STOK</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center"><?php echo $i ?></td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" >
									<?php echo $val['name'] ?><br />
									<small style="font-size:9px; padding-left:5px">(<?php echo $val['nickname'] ?>) (<?php echo $val['category_name'] ?>)</small>
								</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center">
									<b>
										<?php echo $val['stock'] ?>
										<?php echo $val['const_name'] ?>
									</b>
								</td>
								<td style="padding:5px; font-size:12pt; border:1px solid black" align="center">
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

<?php include '../template/print.php' ?>	
