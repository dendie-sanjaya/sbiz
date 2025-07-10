<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<h1>LAPORAN TRANSAKSI RINCIAN BARANG</h1>

	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<form action="index.php" method="post">
			<table width="500">
				<tr>
					<td>	
						<table width="100%">
							<tr>
								<td width="38%">KATEGORI</td>
								<td> : <?php echo $dataStuff['category_name'] ?></td>
							</tr>						
							<tr>
								<td width="38%">NAMA BARANG</td>
								<td> : <?php echo $dataStuff['name'] ?></td>
							</tr>
							<tr>
								<td>DARI TANGGAL </td>
								<td> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
							</tr>
							<tr>
								<td>SAMPAI TANGGAL</td>
								<td> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
							</tr>
							<tr>
								<td>JENIS TRANSAKSI</td>
								<td> :
									<?php if($_REQUEST['type']  == 0): ?>
										BARANG KELUAR
									<?php endif; ?>

									<?php if($_REQUEST['type']  == 1): ?>
										BARANG MASUK
									<?php endif; ?>

									<?php if($_REQUEST['type']  == 2): ?>
										KOREKSI STOK
									<?php endif; ?>

									<?php if($_REQUEST['type']  == 3): ?>
										SEMUA
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<p style="text-align:right">
		<input type="button" value="PRINT" onclick="window.open('print.php?stuffId=<?php echo urlencode($_REQUEST['stuffId'])?>&type=<?php echo $_REQUEST['type'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
		<input type="button" value="EXPORT TO EXCEL" onclick="window.open('excel.php?stuffId=<?php echo urlencode($_REQUEST['stuffId'])?>&type=<?php echo $_REQUEST['type'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
		<input type="button" value="<< KEMBALI" onclick="history.go(-1)" />
	</p>
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
						<th align="center" width="15%">TIPE</th>
						<th align="center" width="13%">PRICE</th>
						<th align="center" width="13%">JUMLAH</th>
						<th align="center" width="13%">TOTAL</th>
						<th align="center">KETERANGAN</th>
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
								<?php if($val['tipe'] == 0): ?>
									BRG. KELUAR
								<?php endif; ?>

								<?php if($val['tipe'] == 1): ?>
									BRG. MASUK
								<?php endif; ?>

								<?php if($val['tipe'] == 2): ?>
									KOREKSI STOK
								<?php endif; ?>
							</td>
							<td valign="top" align="center">
								<?php echo number_format($val['price'],0,'','.') ?>
							</td>
							<td valign="top" align="center">
								<?php echo $val['amount'] ?>
								<?php echo $val['const_name'] ?>
							</td>
							<td valign="top" align="center">
								<?php $tmp 	= abs($val['amount']) * $val['price']; ?>
								<?php echo number_format($tmp,0,'','.') ?>
								<?php $priceTotal += $tmp; ?>
							</td>
							<td valign="top" align="left">
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
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
