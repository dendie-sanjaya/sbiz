<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>KATEGORI</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<p><input type="button" value="TAMBAH" onclick="window.location='add.php'" /></p>
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center">NAMA</th>
						<!--
						<th align="center" width="15%">BIAYA CS</th>
						<th align="center" width="15%">BIAYA OPERATION</th>
						<th align="center" width="15%">BIAYA RISET</th>
						<th align="center" width="15%">BIAYA ADVERTISER</th>
						-->
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="left"><?php echo $val['name'] ?></td>
							<!--
							<td align="center"><?php echo number_format($val['cost_cs'],0,'','.') ?></td>
							<td align="center"><?php echo number_format($val['cost_ops'],0,'','.') ?></td>
							<td align="center"><?php echo number_format($val['cost_riset'],0,'','.') ?></td>
							<td align="center"><?php echo number_format($val['cost_adv'],0,'','.') ?></td>
							-->
							<td align="center">
								<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
								<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
		</div>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
