<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<h1>PERIODE PEMESANAN</h1>

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
					<td width="18%">KATA KUNCI</td>
					<td>
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
						<small><i>NAMA PERIODE</i></small>
					</td>
				</tr>
				<tr>
					<td width="15%">STATUS PERIODE</td>
					<td>
						<select name="periodeStatus" style="width:180px">
							<option value="0" <?php echo 1 == (isset($_REQUEST['periodeStatus']) ? $_REQUEST['periodeStatus'] : '') ? 'selected' : '' ?>>Di Buka</option>
							<option value="1" <?php echo 1 == (isset($_REQUEST['periodeStatus']) ? $_REQUEST['periodeStatus'] : '') ? 'selected' : '' ?>>Di Tutup	</option>
						</select>				
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
						<th align="center" width="20%">NAMA PERIODE</th>
						<th align="center" width="20%">TGL BUKA</th>
						<th align="center" width="20%">TGL TUTUP</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="left">
								<?php echo $val['name'] ?><br />
							</td>
							<td align="center"><?php echo $val['date_start_frm'] ?></td>
							<td align="center"><?php echo $val['date_end_frm'] ?></td>
							<td align="center">
								<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
								<?php if($val['is_status'] == '1'): ?>
									<input type="button" value="BUKA PERIODE" onclick="confirm('Anda yakin akan membuka ?') ? window.location='status.php?id=<?php echo $val['id'] ?>&status=0' : false" />
								<?php else: ?>
									<input type="button" value="TUTUP PERIODE " onclick="confirm('Anda yakin akan menutup ?') ? window.location='status.php?id=<?php echo $val['id'] ?>&status=1' : false" />
								<?php endif; ?>
								<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />								
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'periodeStatus='.$periodeStatus));
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
