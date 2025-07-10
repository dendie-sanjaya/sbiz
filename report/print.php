<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LOG MUTASI BARANG</h1></center>
	<fieldset style=" border:2px solid black ">
		<legend style="font-size:14pt;"><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td width="20%" style="font-size:12pt">DARI TANGGAL </td>
				<td width="25%" style="font-size:12pt"> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td width="20%" style="font-size:12pt">KATEGORI</td>
				<td style="font-size:12pt">
					: <?php echo $categoryId == 'x' ? 'SEMUA' : $printDataCategory['name'] ?>
				</td>
			</tr>
			<tr>
				<td style="font-size:12pt">SAMPAI TANGGAL</td>
				<td style="font-size:12pt"> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
				<td style="font-size:12pt">JENIS TRANSAKSI</td>
				<td style="font-size:12pt"> :
					<?php if($_REQUEST['type'] == 0): ?>
						BRG. KELUAR
					<?php endif; ?>

					<?php if($_REQUEST['type'] == 1): ?>
						BRG. MASUK
					<?php endif; ?>

					<?php if($_REQUEST['type'] == 2): ?>
						KOREKSI STOK
					<?php endif; ?>

					<?php if($_REQUEST['type'] == 3): ?>
						SEMUA
					<?php endif; ?>
				</td>
			</tr>
		</table>
	</fieldset>
	<p></p>
	<div id="tbl">
		<?php if(mysql_num_rows($data) < 1) : ?>
		 	<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<table width="100%" border="0" style="font-size:12pt; padding:0px; border:1px solid black;" cellpadding="0" cellspacing="0">
				<thead>			
					<tr>
						<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="5%">NO</th>
						<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="15%">TANGGAL</th>
						<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="18%">NAMA BARANG</th>
						<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="13%">TIPE</th>
						<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="10%">JUMLAH</th>
						<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center" width="13%">TOTAL</th>	
						<th style="font-size:12pt; padding:5px; border:1px solid black;" align="center">KETERANGAN</th>
					</tr>	
				</thead>
				<tbody>
					<?php $priceTotal = 0; ?>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center" valign="top"><?php echo $i ?></td>
							<td style="font-size:12pt; padding:5px; border:1px solid black;" valign="top" align="center">
								<?php echo $val['date'] ?>
							</td>
							<td style="font-size:12pt; padding:5px; border:1px solid black;" valign="top" align="center">
								<?php echo $val['name'] ?><br />
								<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
							</td>
							<td style="font-size:12pt; padding:5px; border:1px solid black;" valign="top" align="center">
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
							<td style="font-size:12pt; padding:5px; border:1px solid black;" valign="top" align="center">
								<?php echo $val['amount'] ?>
								<?php echo $val['const_name'] ?>
							</td>
							<td style="font-size:12pt; padding:5px; border:1px solid black;"  valign="top" align="center">
								<?php $tmp 	= abs($val['amount']) * $val['price']; ?>
								<?php echo number_format($tmp,0,'','.') ?>
								<?php $priceTotal += $tmp; ?>
							</td>
							<td style="font-size:12pt; padding:5px; border:1px solid black;" valign="top" align="left">
								HARGA : <b><?php echo number_format($val['price'],0,'','.') ?> / <?php echo $val['const_name'] ?></b>
								<br /><br />
								<?php if($_REQUEST['type'] == 0): ?>
									KLIEN :
								<?php endif; ?>

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
							<td style="font-size:12pt; padding:5px; border:1px solid black;" colspan="5" align="center"><b>GRAND TOTAL</b></td>
							<td style="font-size:12pt; padding:5px; border:1px solid black;" align="center"><b><?php echo number_format($priceTotal,0,'','.') ?></b></td>
							<td style="font-size:12pt; padding:5px; border:1px solid black;" colspan="2">&nbsp;</td>
						</tr>	
					<?php endif; ?>
				<tbody>
			</table>
		<?php endif; ?>
	</div>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
