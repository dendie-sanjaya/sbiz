<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<h1>LOG MUTASI BARANG</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%">
				<tr>
					<td width="20%">DARI TANGGAL </td>
					<td width="25%">
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:180px" />
					</td>
					<td width="20%">KATEGORI</td>
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
					<td>SAMPAI TANGGAL</td>
					<td>
						<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:180px" />
					</td>
					<td>JENIS TRANSAKSI</td>
					<td>
						<select name="type" style="width:180px">
							<option value="3" <?php echo ($_REQUEST['type'] == 3) ? 'selected' : '' ?>>SEMUA</option>
							<option value="0" <?php echo ($_REQUEST['type'] == 0) ? 'selected' : '' ?>>BARANG KELUAR</option>
							<option value="1" <?php echo ($_REQUEST['type'] == 1) ? 'selected' : '' ?>>BARANG MASUK</option>
							<option value="2" <?php echo ($_REQUEST['type'] == 2) ? 'selected' : '' ?>>KOREKSI STOK</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="FILTER" />
					</td>
					<td></td>
					<td></td>
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
			<p style="text-align:right">
				<input type="button" value="PRINT" onclick="window.open('print.php?categoryId=<?php echo $_REQUEST['categoryId'] ?>&type=<?php echo $_REQUEST['type'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
				<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?categoryId=<?php echo $_REQUEST['categoryId'] ?>&type=<?php echo $_REQUEST['type'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
			</p>	
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="15%">TANGGAL</th>
							<th align="center" width="15%">NAMA BARANG</th>
							<th align="center" width="13%">TIPE</th>
							<th align="center" width="9%">JML</th>
							<th align="center" width="13%">TOTAL</th>	
							<th align="center" width="14%">KETERANGAN</th>
							<th></th>
						</tr>	
					</thead>
					<tbody>
						<?php $priceTotal = 0; ?>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center" valign="top"><?php echo $i ?></td>
								<td valign="top" align="center">
									<?php echo $val['date'] ?>
								</td>
								<td valign="top" align="center">
									<?php echo $val['name'] ?><br />
									<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
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
								<td valign="top" align="center">
									<?php if($val['tipe'] == 2): ?>
										-
									<?php else : ?>
										<?php $tmp 	= abs($val['amount']) * $val['price']; ?>
										<?php echo number_format($tmp,0,'','.') ?>
										<?php $priceTotal += $tmp; ?>
									<?php endif; ?>
								</td>
								<td valign="top" align="left">
									<?php if($val['tipe'] == 2): ?>
										-
									<?php else :?>
										HARGA : <b><?php echo number_format( $val['price'],0,'','.') ?> / <?php echo $val['const_name'] ?></b>
										<br /><br />
										<?php if($_REQUEST['type'] == 0): ?>
											KLIEN :
										<?php endif; ?>

										<strong>
											<?php if($_REQUEST['type'] == 1): ?>
												PEMASOK :
											<?php endif; ?>
	
											<?php if($_REQUEST['type'] == 2): ?>
											-
											<?php endif; ?>

											<?php if($_REQUEST['type'] == 3): ?>
												PEMASOK / KLIEN :
											<?php endif; ?>
											<?php if($val['tipe'] == 0): ?>
												<?php echo $val['client_name'] ?>
											<?php endif; ?>
										</strong>

										<strong>
											<?php if($val['tipe'] == 1): ?>
												<?php echo $val['suplier_name'] ?>
											<?php endif; ?>

											<?php if($val['tipe'] == 2): ?>
												-
											<?php endif; ?>
	
											<?php if($val['tipe'] == 3): ?>
												<?php echo $val['suplier_name'] ?> <?php echo $val['client_name'] ?>
											<?php endif; ?>
										</strong>
										<br /><br />
										<?php echo $val['description'] ?>
									<?php endif; ?>
								</td>
								<td valign="top" align="center" style="font-size:11px">
									<a href="../reportDetail/index.php?stuffId=<?php echo $val['stuff_id'] ?>&type=<?php echo $_REQUEST['type'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>">
									  [ RINCIAN ]
									</a>
								</td>				
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
						<?php if(in_array($_REQUEST['type'],array(0,1,2))):?>
							<tr>
								<td colspan="5" align="center"><b>GRAND TOTAL</b></td>
								<td align="center"><b><?php echo number_format($priceTotal,0,'','.') ?></b></td>
								<td colspan="2">&nbsp;</td>
							</tr>	
						<?php endif; ?>
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
