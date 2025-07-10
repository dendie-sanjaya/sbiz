<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>MEMBER</h1>

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
						<th align="center" width="25%">NAMA</th>
						<th align="center" width="15%">HANDPHONE</th>						
						<th align="center" width="20%">POSISI</th>		
						<th align="center" width="15%">STATUS AKTIF</th>						
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td>
								<?php echo $val['name'] ?>
								<small>(<?php echo $val['username_name'] ?>)</small>
							</td>
							<td align="center">
								<?php echo $val['phone'] ?>			
							</td>							
							<td align="center">
								<?php if($val['id'] == '1'): ?>
									<b>Super Administrator</b>
								<?php else: ?>	
									<?php echo $val['position_name'] ?>
								<?php endif; ?>
							</td>
							<td align="center">
								<?php echo $val['is_enabled'] == '1' ? 'YA' : 'TIDAK' ?>			
							</td>
							<td align="center">
								<?php if($val['id'] != '1'): ?>
									<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
									<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
								<?php else: ?>	
									<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" disabled />
									<input type="button" value="HAPUS" disabled onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false"  />
								<?php endif; ?>	
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
