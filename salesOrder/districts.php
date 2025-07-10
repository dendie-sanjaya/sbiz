<?php ob_start(); ?>
	<?php include 'districtsRead.php' ?>

	<h1>CARI KODE KECAMATAN</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="districts.php" method="get">
			<input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
			<table width="100%">
				<tr style="height: 80px">
					<td colspan="2"> 
						KATA KUNCI <br />
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%"/><br />
						<small><i>KODE KECAMATAN / KECAMATAN / KOTA / KAB / PROVINSI</i></small>
					</td>
				</tr>
				<tr style="height: 60px">
					<td colspan="2">
						<input type="submit" value="FILTER" style="width: 100%" />
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
						<th style="font-size: 11px" align="center" width="5%">NO</th>
						<th style="font-size: 11px" align="center" width="15%">KODE KECAMATAN</th>
						<th style="font-size: 11px" align="center" width="20%">KECAMATAN</th>
						<th style="font-size: 11px" align="center" width="20%">KOTA/KAB</th>
						<th style="font-size: 11px" align="center" width="20%">PROVINSI</th>
						<th>&nbsp;</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td style="font-size: 12px" align="center"><?php echo $i ?></td>
							<td style="font-size: 12px" align="center">
								<?php echo $val['code'] ?>
							</td>
							<td style="font-size: 12px" align="center">
								<?php echo $val['name'] ?>
							</td>
							<td style="font-size: 12px" align="center">
								<?php echo $val['city'] ?>
							</td>
							<td style="font-size: 12px" align="center">
								<?php echo $val['province'] ?>
							</td>
							<td style="font-size: 12px" align="center">
								<input type="button" value="PILIH" onclick="choose('<?php echo $val['id'] ?>','<?php echo $_REQUEST['id'] ?>')" />								
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
					<script type="text/javascript">				
						function choose(p,p2) {
							window.location='districtsSave.php?jumpTo=detailDataBuyer&districtsId=' + p + '&id=' + p2; 
						}
					</script>

				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'id='.$_REQUEST['id'],'categoryId='.$categoryId,'isBundling='.$isBundling));
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
