<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<h1>KOREKSI STOK</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>CARI BARANG </b></legend>
		<form action="index.php" method="post">
			<table width="100%">
				<tr>
					<td width="18%">KATEGORI</td>
					<td>
						<select name="categoryId" style="width:180px">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
						<div style="color:red"><?php echo isset($msgError['categoryId']) ? $msgError['categoryId'] : '' ?></div>
					</td>
				</tr>				
				<tr>
					<td width="15%">NAMA BARANG</td>
					<td>
						<input name="keyword" type="text" style="width:180px" value="<?php echo $_REQUEST['keyword'] ?>" /><br />						
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="CARI" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<br/>
	<?php if(isset($_REQUEST['keyword'])): ?>
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
							<th align="center" width="30%">NAMA BARANG</th>
							<th align="center" width="25%">STOK SAAT INI</th>
							<th></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td>
									<?php echo $val['name'] ?><br />
									<small style="font-size:9px; padding-left:5px">(<?php echo $val['nickname'] ?>) (<?php echo $val['category_name'] ?>)</small>
								</td>
								<td align="center">
									<?php echo $val['stock'] ?>
									<?php echo $val['const_name'] ?>
								</td>
								<td align="center">
									<input type="button" value="KOREKSI STOK" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>&keyword=<?php echo $_REQUEST['keyword'] ?>'" />
								</td>
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
				<p style="text-align:center; padding:10px">
					<?php
						echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$_REQUEST['keyword'],'status='.$_REQUEST['status'],'categoryId='.$_REQUEST['categoryId']));
						echo '<br /><br />';
						echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
					?>
				</p>	
			</div>
		<?php endif; ?>
	<?php else: ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('searchSuccess') ?></h3>
		</div>		
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
