<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<h1>BARANG</h1>

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
					<td>
						KATEGORI<br />
						<select name="categoryId" style="width:100%" onchange="window.location='index.php?categoryId='+this.value">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
					<td colspan="2">
						NAMA BARANG / JUDUL PRODUK / SKU
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%" /><br />
					</td>
				</tr>
				<?php if(mysql_num_rows($dataSubCategory) > 0): ?>
				<!--	
				<tr style="height: 60px">
				  <?php $irow=1 ?>	
				  <?php while($row = mysql_fetch_array($dataSubCategory)): ?>
					<td <?php echo $irow == 4 ? 'colspan="2"' : '' ?>><?php echo strtoupper($row['name']) ?>&nbsp;
					  <?php 
							$query = "select id,name
								from stuff_category_sub_row
								where stuff_category_sub_id ='{$row['id']}'
								order by name
								";
							$dataSubCategoryRow = mysql_query($query) or die (mysql_error());		
					  ?>			
					  <select name="categorySubRow<?php echo $irow ?>" style="width: 100%">		
					     <option value="x">Semua</option>
	 				  <?php while($rowSubCategoryRow = mysql_fetch_array($dataSubCategoryRow)): ?>
	 				  	 <option value="<?php echo $rowSubCategoryRow['id'] ?>" <?php echo $rowSubCategoryRow['id'] == (isset($_REQUEST['categorySubRow'.$irow]) ? $_REQUEST['categorySubRow'.$irow] : '') ? 'selected' : '' ?>><?php echo $rowSubCategoryRow['name'] ?></option>
	 				  <?php endwhile; ?>		
	 				  </select>
					</td>				  
					<?php $irow++ ?>
				  <?php endwhile; ?>	
				</tr>	
				-->
				<?php endif; ?>

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
		<p><input type="button" value="TAMBAH" onclick="window.location='add.php'" /></p>
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
						<th align="center" width="24%">NAMA BARANG</th>
						<th align="center" width="12%" style="font-size: 11px">HARGA DASAR</th>
						<th align="center" width="12%" style="font-size: 11px">HARGA JUAL</th>
						<th align="center" width="11%" style="font-size: 11px">KOMISI SALES</th>
						<th align="center" width="11%" style="font-size: 11px">STOK MIN</th>
						<?php if($_SESSION['loginPosition'] != '3'): ?>
							<th></th>
						<?php endif; ?>	
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="left">
								<?php echo $val['name'] ?> <br />
								<small style="font-size:9px; padding-left:5px">[ SKU : <?php echo $val['sku'] ?> ]</small><br />
								<?php if(strlen($val['nickname']) > 0): ?>
									<small style="font-size:9px; padding-left:5px">[ Judul : <?php echo $val['nickname'] ?> ]</small><br />
								<?php endif; ?>	
								<small style="font-size:9px; padding-left:5px">[ Kategori : <?php echo $val['category_name'] ?>]</small>	
								<small style="font-size:9px; padding-left:5px; color: red"><?php echo $val['is_hidden'] == '1' ? '(Disembunyikan)' : '' ?></small>	
							</td>
							<td align="center">
								<?php echo number_format($val['price_basic'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>
							<td align="center">
								<?php echo number_format($val['price'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>
							<td align="center">
								<?php echo number_format($val['fee_sales'],0,0,'.') ?>
							</td>
							<td align="center">
								<?php echo $val['stock_min_alert'] ?>
								<?php echo $val['const_name'] ?>
								<br />
							</td>
							<?php if($_SESSION['loginPosition'] != '3'): ?>
								<td align="center">
									<input type="button" value="SALIN" onclick="window.location='add.php?id=<?php echo $val['id'] ?>'" />
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
