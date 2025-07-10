<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<h1>LOG MUTASI BARANG</h1>

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
					<td width="15%">DARI TANGGAL </td>
					<td>
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly />
					</td>
				</tr>
				<tr>
					<td>SAMPAI TANGGAL</td>
					<td>
						<input type="text" name="dateTo" id="dateTo" value="" readonly />
					</td>
				</tr>
				<tr>
					<td>NAMA BARANG</td>
					<td>
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" /><br />
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
	<?php if(!isset($_REQUEST['dateFrom'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('filterData') ?></h3>
		</div>		
	<?php else: ?>
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
							<th align="center" width="15%">TANGGAL</th>
							<th align="center" width="16%">NAMA BARANG</th>
							<th align="center" width="15%">TIPE</th>
							<th align="center" width="10%">JUMLAH</th>
							<th align="center" width="25%">KETERANGAN</th>
							<th></th>
						</tr>	
					</thead>
					<tbody>
						<?php $quantityTotal = 0; ?>
						<?php $priceTotal = 0; ?>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center" valign="top"><?php echo $i ?></td>
								<td valign="top" align="center">
									<?php echo $val['date'] ?>
								</td>
								<td valign="top" align="center">
									<?php echo $val['name'] ?>
								</td>
								<td valign="top" align="center">
									<?php if($val['tipe'] == 0): ?>
										BRG. KELUAR
									<?php endif; ?>

									<?php if($val['tipe'] == 1): ?>
										BRG. MASUK
									<?php endif; ?>

									<?php if($val['tipe'] == 2): ?>
										KOREKSI STOK
									<?php endif; ?>

									<?php if($val['tipe'] == 3): ?>
										SEMUA
									<?php endif; ?>
								</td>
								<td valign="top" align="center">
									<?php echo $val['amount'] ?>
									<?php echo $val['const_name'] ?>
								</td>
								<td valign="top" align="left">
									<strong>
										<?php if($val['tipe'] == 0): ?>
											KLIEN :
										<?php endif; ?>

										<?php if($val['tipe'] == 1): ?>
											PEMASOK :
										<?php endif; ?>

										<?php if($val['tipe'] == 2): ?>
											KOREKSI
										<?php endif; ?>

										<?php if($val['tipe'] == 0): ?>
											<?php echo $val['client_name'] ?>
										<?php endif; ?>

										<?php if($val['tipe'] == 1): ?>
											<?php echo $val['suplier_name'] ?>
										<?php endif; ?>
									</strong>
									<?php echo $val['description'] ?>
								</td>
								<td align="center">
									<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>&keyword=<?php echo $_REQUEST['keyword'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>' : false" />
								</td>
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
			</div>
		<?php endif; ?>
	<?php endif; ?>

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
