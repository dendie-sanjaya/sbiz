<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<h1>PENGELUARAN PERHARI</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>CARI BARANG </b></legend>
		<form action="index.php" method="post">
			<table width="100%" border="0">
				<tr>
					<td width="25%">DARI TANGGAL</td>
					<td width="25%">
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly/>
					</td>
					<td width="25%">SAMPAI TANGGAL</td>							
					<td>
						<input type="text" name="dateTo" id="dateTo" value="" readonly />
					</td>							
				</tr>							
				<tr>
					<td>KOMPONEN PENGELUARAN</td>
					<td>
						<select name="componentId"style="width:200px">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataComponent)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['componentId']) ? $_REQUEST['componentId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
					<td colspan="2">
						<input type="submit" value="FILTER" style="width: 100%" />						
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<br/>

	<p><input type="button" value="TAMBAH" onclick="window.location='add.php'" /></p>

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
						<th align="center" width="17%">TGL TRANSAKSI</th>
						<th align="center" width="30%">NAMA KOMPONEN</th>
						<th align="center" width="15%">KETERANGAN</th>
						<th align="center" width="15%">NOMINAL</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php $total = 0 ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="center" ><?php echo $val['date_transaction_frm'] ?></td>
							<td><?php echo $val['name'] ?>
								<br /><br />
								<small style="font-size: 11px">[ Sumber Pendanaan : <?php echo $val['fin_source_fund_name'] ?> ]<small>										
							</td>
							<td><?php echo $val['description'] ?></td>
							<td align="center">
								<?php echo number_format($val['nominal'],0,0,'.') ?>
							</td>
							<td align="center">
								<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
								<input type="button" value="DELETE" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>&dateFrom=<?php echo $_REQUEST['dateFrom'] ?>&dateTo=<?php echo $_REQUEST['dateTo'] ?>&componentId=<?php echo $_REQUEST['componentId'] ?>' : false" />
							</td>
						</tr>	
					<?php $i++; ?>
					<?php $total = ($total + $val['nominal']) ?>
					<?php endwhile; ?>
				<tbody>
				<tr>
					<th align="center" colspan="4"><b>TOTAL</b></th>
					<th align="center"><?php echo number_format($total,0,0,'.') ?></th>	
					<th>&nbsp;</td>
				</tr>	
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('componentId='.$componentId,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo']));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>	
		</div>
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$(function() {
					$( "#dateFrom" ).datepicker({
						dateFormat : 'dd/mm/yy',
						changeMonth : true,
						changeYear : true,
						yearRange: '-100y:c+nn',
						maxDate: '0d',
					}); 
					<?php $tmp = strlen(trim($_REQUEST['dateFrom'])) == 0 ?  '' : explode('/',$_REQUEST['dateFrom']) ?>
					$("#dateFrom" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				});


			$(function() {
					$( "#dateTo" ).datepicker({
						dateFormat : 'dd/mm/yy',
						changeMonth : true,
						changeYear : true,
						yearRange: '-100y:c+nn',
						maxDate: '0d',
					});

					<?php $tmp = strlen(trim($_REQUEST['dateTo'])) == 0 ?  '' : explode('/',$_REQUEST['dateTo']) ?>
					$("#dateTo" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				});
		});
	</script>		

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
