<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<center><h1>LAPORAN STOK</h1></center>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
		<table width="100%">
			<tr>
				<td valign="top" width="60%">
					<fieldset style="height:150px; border:2px solid black; font-size:18pt">
						<legend><b>INFORMASI</b></legend>
						<form action="index.php" method="post">
							<table width="100%" border="0">
								<tr>
									<td width="100%" valign="top">
										<table width="100%" >
											<tr>
												<td style="font-size:14pt">KATEGORI</td>
											</tr>
											<tr>
												<td style="font-size:12pt">
													
														<strong>
															<?php while($val = mysql_fetch_array($dataCategoryPrint)): ?>
																<small><?php echo $val['name'] ?></small>,		
															<?php endwhile; ?>											
														</strong>	
														
												</td>
											</tr>						
										</table>
									</td>
								</tr>
								<tr>			
									<td valign="top">
										<table width="100%">
											<tr>
												<td width="40%" style="font-size:12pt">NAMA BARANG</td>
												<td style="font-size:12pt">: 
														<strong><?php echo strlen($_REQUEST['keyword']) > 0 ? $_REQUEST['keyword'] : 'SEMUA' ?></strong>
													
												</td>
											</tr>
											<tr>
												<td valign="top" style="font-size: 12pt">TAMPILKAN STOK</td>
												<td valign="top" style="font-size: 12pt">
													: 
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
					<fieldset style="height:150px; border:2px solid black">
						<legend><b>TOTAL ASSET<b></legend>
						<table width="100%">
							<tr>
								<td width="60%" style="font-size:font-size:12pt">JUMLAH ITEM BARANG</td>
								<td style="font-size:font-size:12pt">: <b><small><?php echo $dataTotalAssetItem ?> Buah</b></small></td>
							</tr>
						</table>
					</fieldset>	
				</td>
			</tr>
		</table>
		<br />

		<div id="tbl">
			<table width="100%" border="0" style="font-size:font-size:12pt; border:1px solid black;" cellpadding="0" cellspacing="0">
				<thead>			
					<tr>
						<th style="font-size:font-size:12pt; border:1px solid black" align="center" width="5%">NO</th>
						<th style="font-size:font-size:12pt; border:1px solid black" align="center" width="25%">NAMA BARANG</th>
						<th style="font-size:font-size:12pt; border:1px solid black" align="center" width="%">HARGA JUAL</th>
						<th style="font-size:font-size:12pt; border:1px solid black" align="center" width="%">SISA STOK</th>
						<th style="font-size:font-size:12pt; border:1px solid black" align="center" width="%">MINIMUM STOK</th>
						<th style="font-size:font-size:12pt; border:1px solid black" align="center" width="%">KOMISI SALES</th>
						<th style="font-size:font-size:12pt; border:1px solid black" align="center" width="%">LOKASI</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td style="font-size:font-size:12pt; border:1px solid black" align="center"><?php echo $i ?></td>
							<td style="font-size:font-size:12pt; border:1px solid black; padding:5px">
								<?php echo $val['name'] ?><br />
								<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
							</td>
							<td style="font-size:font-size:12pt; border:1px solid black; padding:5px" align="center">
								<?php echo number_format($val['price'],0,0,'.') ?> / 
								<?php echo $val['const_name'] ?>		
							</td>							
							<td style="font-size:font-size:12pt; border:1px solid black; padding:5px" align="center">
								<?php echo $val['stock'] ?>
								<?php echo $val['const_name'] ?>		
							</td>
							<td style="font-size:font-size:12pt; border:1px solid black; padding:5px" align="center">
								<?php echo $val['stock_min_alert'] ?> 
								<?php echo $val['const_name'] ?>							
							</td>
							<td style="font-size:font-size:12pt; border:1px solid black; padding:5px" align="center">
								<?php echo number_format($val['fee_sales'],0,0,'.') ?> / 
								<?php echo $val['const_name'] ?>		
							</td>							
							<td style="font-size:font-size:12pt; border:1px solid black; padding:5px" align="center">
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

<?php include '../template/print.php' ?>	
