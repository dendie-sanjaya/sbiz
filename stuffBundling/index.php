<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<h1>BARANG BUNDLING</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%">
				<tr>
					<td width="15%">KATEGORI</td>
					<td>
						<select name="categoryId" style="width:90%">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
					<td>KATA KUNCI</td>
					<td>
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:90%" /><br />
						<small><i>NAMA BARANG BUNDLING</i></small>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>	
				<tr>
					<td colspan="4">
						<input type="submit" value="FILTER" style="width: 100%" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<p></p>
	<?php if($_SESSION['loginPosition'] != '3'): ?>
		<p><input type="button" value="TAMBAH " onclick="window.location='add.php'" /></p>
	<?php endif; ?>

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
						<th align="center" width="23%">BARANG BUNDLING</th>
						<th align="center" width="25%">HARGA MINIMUM BUNDLING</th>
						<th align="center" width="15%">KOMISI SALES</th>
						<th align="center"></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="left">
								<?php echo $val['name'] ?><br />
								<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>	
								<small style="font-size:9px; padding-left:5px; color: red"><?php echo $val['is_hidden'] == '1' ? '(Disembunyikan)' : '' ?></small>	

							</td>
							<td align="center">
								<?php echo number_format($val['price_min'],0,'','.') ?>
							</td>
							<td align="center">
								<?php echo number_format($val['fee_sales'],0,0,'.') ?>
							</td>
							<?php if($_SESSION['loginPosition'] != '3'): ?>
								<td align="center">
									<input type="button" value="PENGATURAN BARANG" onclick="window.location='stuff.php?id=<?php echo $val['id'] ?>'" />									
									<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
									<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
								</td>
							<?php endif;?>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'status='.$status,'categoryId='.$categoryId));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>	
		</div>
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
