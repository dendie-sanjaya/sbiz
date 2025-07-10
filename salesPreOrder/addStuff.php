<?php ob_start(); ?>
	<?php include 'addStuffRead.php' ?>

	<h1>BARANG</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="addStuff.php" method="get">
			<input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
			<table width="100%">
				<tr>
					<td width="25%">KATEGORI</td>
					<td>
						<select name="categoryId" style="width:180px">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
				</tr>			
				<tr>
					<td>KATA KUNCI</td>
					<td>
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
						<small><i>NAMA BARANG / JUDUL PRODUK</i></small>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="FILTER" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<p></p>
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="33%">NAMA BARANG</th>
						<th align="center" width="20%">HARGA JUAL</th>
						<!--
						<th align="center" width="15%">STOK</th>
						-->
						<th>&nbsp;</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="left">
								<?php echo $val['name'] ?><br />
								<?php if(strlen($val['nickname']) > 0): ?>
									<small style="font-size:9px; padding-left:5px"><?php echo $val['nickname'] ?></small><br />
								<?php endif; ?>	
								<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>	
							</td>
							<td align="center">
								<?php echo number_format($val['price'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>
							<!--	
							<td align="center">
								<?php echo $val['stock'] ?>
								<?php echo $val['const_name'] ?>
							</td>
							-->
							<td align="center">
								JUMLAH BELI <input type="text" value="1" id="amount_<?php echo $i ?>" name="amount" size="1" style="text-align:center" />
								<input type="button" value="PILIH" onclick="choose('amount_<?php echo $i ?>','<?php echo $val['id'] ?>','<?php echo $val['price_basic'] ?>','<?php echo $val['price'] ?>','<?php echo $_REQUEST['id'] ?>')" />

								<script type="text/javascript">				
									function choose(p,p2,p3,p4,p5) {
										var amount = document.getElementById(p).value;
										window.location='addStuffSave.php?jumpTo=detailStuff&amount=' + amount +'&stuffId=' + p2 + '&priceBasic=' + p3 + '&price=' + p4 + '&id=' + p5; 
									}
								</script>
								
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'id='.$_REQUEST['id'],'categoryId='.$categoryId));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>	
		</div>
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>	
