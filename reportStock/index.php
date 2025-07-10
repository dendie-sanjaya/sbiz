<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<h1>LAPORAN STOK</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<table width="100%">
		<tr>
			<td valign="top" width="60%">
				<fieldset style="height:210px">
					<legend><b>FILTER</b></legend>
					<form action="index.php" method="post">
						<table width="100%" border="0">
							<tr>
								<td width="30%" valign="top">
									<table width="100%">
										<tr>
											<td><small>KATEGORI</small></td>
										</tr>
										<tr>
											<td>
												<select name="categoryId[]" style="width:190px; height:100px"  multiple>
													<?php while($val = mysql_fetch_array($dataCategory)): ?>
														<option <?php echo in_array($val['id'],$categoryId) ? ' selected ' : '' ?> value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
													<?php endwhile; ?>
												</select>				
											</td>
										</tr>						
									</table>
								</td>
								<td valign="top">
									<table width="100%">
										<tr>
											<td width="35%"><small>NAMA BARANG</small></td>
											<td>
												<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" />
											</td>
										</tr>
										<tr>
											<td valign="top"><small>TAMPILKAN STOK</small></td>
											<td valign="top">
												<select name="operator" onchange="operatorSelect(this.value)">
													<option value="1" <?php echo isset($_REQUEST['operator']) ? $_REQUEST['operator']  == '1' ? 'selected' : ''  : '' ?>>=</option> 
													<option value="2" <?php echo isset($_REQUEST['operator']) ? $_REQUEST['operator']  == '2' ? 'selected' : ''  : '' ?>>></option> 
													<option value="3" <?php echo isset($_REQUEST['operator']) ? $_REQUEST['operator']  == '3' ? 'selected' : ''  : '' ?>><</option> 
													<option value="4" <?php echo isset($_REQUEST['operator']) ? $_REQUEST['operator']  == '4' ? 'selected' : ''  : '' ?>>< Min Stok</option> 
												</select>
												<input style="text-align:center" name="stock" id="stock" type="text" size="4" value="<?php echo isset($_REQUEST['stock']) ? $_REQUEST['stock'] : '-1' ?>" /><br />
											</td>
										</tr>
									</table>	
								</td>
							</tr>	
							<tr>
								<td colspan="2">
									<input type="submit" value="FILTER" />
								</td>
							</tr>
						</table>
					</form>
				</fieldset>
			</td>
			<td valign="top">
				<fieldset style="height:210px">
					<legend><b>TOTAL ASSET<b></legend>
						<table width="100%">
							<tr>
								<td width="65%">JUMLAH ITEM BARANG</td>
								<td>: <b><?php echo $dataTotalAssetItem ?> Buah</b></td>
							</tr>
							<tr>
								<td>TOTAL NILAI HARGA JUAL</td>
								<td>: <b><?php echo number_format($dataTotalAssetValue,0,'','.') ?></b></td>
							</tr>
							<tr>
								<td>TOTAL NILAI HARGA DASAR</td>
								<td>: <b><?php echo number_format($dataTotalAssetValueBasic,0,'','.') ?></b></td>
							</tr>							
						</table>
				</fieldset>	
			</td>
		</tr>
	</table>
	<br />

	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<p style="text-align:right">
			<input type="button" value="PRINT ALL" onclick="window.open('print.php?categoryIdChoose=<?php echo $categoryIdChoose ?>&recordMax=10000&SplitRecord=&keyword=<?php echo $_REQUEST['keyword'] ?>&operator=<?php echo $_REQUEST['operator'] ?>&stock=<?php echo $_REQUEST['stock'] ?>')" />		
			<input type="button" value="PRINT" onclick="window.open('print.php?categoryIdChoose=<?php echo $categoryIdChoose ?>&SplitRecord=<?php echo $_REQUEST['SplitRecord'] ?>&keyword=<?php echo $_REQUEST['keyword'] ?>&operator=<?php echo $_REQUEST['operator'] ?>&stock=<?php echo $_REQUEST['stock'] ?>')" />
			<input type="button" value="EXPORT TO EXCEL ALL" onclick="window.open('excel.php?categoryIdChoose=<?php echo $categoryIdChoose ?>&recordMax=10000&SplitRecord=&keyword=<?php echo $_REQUEST['keyword'] ?>&operator=<?php echo $_REQUEST['operator'] ?>&stock=<?php echo $_REQUEST['stock'] ?>')" />
			<input type="button" value="EXPORT TO EXCEL" onclick="window.open('excel.php?categoryIdChoose=<?php echo $categoryIdChoose ?>&SplitRecord=<?php echo $_REQUEST['SplitRecord'] ?>&keyword=<?php echo $_REQUEST['keyword'] ?>&operator=<?php echo $_REQUEST['operator'] ?>&stock=<?php echo $_REQUEST['stock'] ?>')" />
		</p>

		<div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="25%">NAMA BARANG</th>
						<th align="center" width="16%">SISA STOK</th>
						<th align="center" width="%">NILAI HARGA DASAR</th>
						<th align="center" width="%">NILAI HARGA JUAL</th>
						<th align="center" width="%">LKS SIMPAN</th>
						<th align="center" width="7%"></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td>
								<?php echo $val['name'] ?><br />
								<small style="font-size:9px; padding-left:5px">(<?php echo $val['nickname'] ?>)</small>
								<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
							</td>
							<td align="center">
								<?php echo $val['stock'] ?>
								<?php echo $val['const_name'] ?><br />
								<small>(Min Stok <?php echo $val['stock_min_alert'] ?> <?php echo $val['const_name'] ?>)</small>		
							</td>
							<td align="center">
								<?php echo number_format(($val['stock'] * $val['price_basic']),0,'','.') ?><br />
								<small>(<?php echo $val['stock'].' '.$val['const_name']  ?> * <?php echo number_format($val['price_basic'],0,'','.') ?>)</small>
							</td>
							<td align="center">
								<?php echo number_format(($val['stock'] * $val['price']),0,'','.') ?><br />
								<small>(<?php echo $val['stock'].' '.$val['const_name']  ?> * <?php echo number_format($val['price'],0,'','.') ?>)</small>

							<td align="center">
								<?php echo $val['location_name'] ?>
							</td>
							<td align="center">
							    <a href="detail.php?stuffId=<?php echo $val['id'] ?>"> LOG </a> 
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'operator='.$operator,'stock='.$stock,'categoryIdChoose='.urlencode($categoryIdChoose)));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>	
		</div>
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

	<script type="text/javascript">
		function operatorSelect(val) {
			if(val == 4) {
				document.getElementById('stock').disabled = true;
			} else {
				document.getElementById('stock').disabled = false;
			}

		}

		operatorSelect(<?php echo $operator ?>)
	</script>


<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
