<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN-STOK.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<center><h1>LAPORAN STOK</h1></center>

	<table width="100%">
		<tr>
			<td valign="top" width="60%">
				<fieldset style="height:150px">
					<legend><b>INFORMASI</b></legend>
					<form action="index.php" method="post">
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<table width="100%">
										<tr>
											<td><small>KATEGORI</small></td>
										</tr>
										<tr>
											<td>
												<small>
													<strong>
														<?php while($val = mysql_fetch_array($dataCategoryPrint)): ?>
															<small><?php echo $val['name'] ?></small>,		
														<?php endwhile; ?>											
													</strong>	
												</small>	
											</td>
										</tr>						
									</table>
								</td>
							</tr>
							<tr>			
								<td valign="top">
									<table width="100%">
										<tr>
											<td width="25%"><small>NAMA BARANG</small></td>
											<td><small>: 
													<strong><?php echo strlen($_REQUEST['keyword']) > 0 ? $_REQUEST['keyword'] : 'SEMUA' ?></strong>
												</small>
											</td>
										</tr>
										<tr>
											<td valign="top"><small>TAMPILKAN STOK</small></td>
											<td valign="top">
												<small>: 
													<strong>
													<?php if($_REQUEST['operator'] == '1'): ?>
														=		
													<?php endif; ?> 

													<?php if($_REQUEST['operator'] == '2'): ?>
														>		
													<?php endif; ?> 

													<?php if($_REQUEST['operator'] == '3'): ?>
														<		
													<?php endif; ?> 

													<?php if($_REQUEST['operator'] == '4'): ?>
														&lt; Min Stok
													<?php endif; ?> 

													<?php echo strlen($_REQUEST['stock']) > 0 ? $_REQUEST['stock'] : 0 ?>
													</strong>
												</small>
											</td>
										</tr>
									</table>	
								</td>
							</tr>	
						</table>
					</form>
				</fieldset>
			</td>
			<td valign="top">
				<fieldset style="height:150px">
					<legend><b>TOTAL ASSET<b></legend>
					<table width="100%">
						<tr>
							<td width="60%"><small>JUMLAH ITEM BARANG</small></td>
							<td>: <b><small><?php echo $dataTotalAssetItem ?> Buah</b></small></td>
						</tr>
						<tr>
							<td style="font-size:font-size:12pt">TOTAL NILAI HARGA JUAL</td>
							<td style="font-size:font-size:12pt">: <b><?php echo number_format($dataTotalAssetValue,0,'','.') ?></b></td>
						</tr>
						<tr>
							<td style="font-size:font-size:12pt">TOTAL NILAI HARGA DASAR</td>
							<td style="font-size:font-size:12pt">: <b><?php echo number_format($dataTotalAssetValueBasic,0,'','.') ?></b></td>
						</tr>	
					</table>
				</fieldset>	
			</td>
		</tr>
	</table>
	<br />

	<div id="tbl">
		<table width="100%" border="1">
			<thead>			
				<tr>
					<th align="center" width="5%">NO</th>
					<th align="center" width="25%">NAMA BARANG</th>
					<th align="center" width="16%">SISA STOK</th>
					<th align="center" width="%">NILAI HARGA DASAR</th>
					<th align="center" width="%">NILAI HARGA JUAL</th>
					<th align="center">LKS SIMPAN</th>
				</tr>	
			</thead>
			<tbody>
				<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
				<?php while($val = mysql_fetch_array($data)): ?>
					<tr>
						<td align="center"><?php echo $i ?></td>
						<td>
							<?php echo $val['name'] ?><br />
							<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
						</td>
						<td align="center">
							<?php echo $val['stock'] ?>
							<?php echo $val['const_name'] ?><br />
							<small>(Min Stok <?php echo $val['stock_min_alert'] ?> <?php echo $val['const_name'] ?>)</small>		
						</td>
						<td style="font-size:font-size:12pt; border:1px solid black" align="center">
							<?php echo number_format(($val['stock'] * $val['price_basic']),0,'','.') ?><br />
							<small>(<?php echo $val['stock'].' '.$val['const_name']  ?> * <?php echo number_format($val['price_basic'],0,'','.') ?>)</small>
						</td>													
						<td align="center">
							<div><?php echo ($val['stock'] * $val['price']) ?></div>
							<small>(<?php echo $val['stock'].' '.$val['const_name']  ?> * <?php echo $val['price'] ?>)</small>
						</td>
						<td align="center">
							<?php echo $val['location_name'] ?>
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
