<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN PEMASOK</h1></center>
	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td width="20%">DARI TANGGAL </td>
				<td> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
			</tr>
			<tr>
				<td>SAMPAI TANGGAL</td>
				<td> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
			</tr>
			<tr>
				<td>PEMASOK</td>
				<td> : <?php echo $dataSuplierName['name'] ?>
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
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="15%">TANGGAL</th>
						<th align="center" width="18%">NAMA BARANG</th>
						<th align="center" width="13%">TIPE</th>
						<th align="center" width="10%">HARGA</th>
						<th align="center" width="10%">JUMLAH</th>
						<th align="center" width="13%">TOTAL</th>	
						<th align="center">KETERANGAN</th>
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
								<?php echo $val['description'] ?>
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
					<?php if(in_array($_REQUEST['type'],array(0,1,2))):?>
						<tr>
							<td colspan="6" align="center"><b>GRAND TOTAL</b></td>
							<td align="center"><b><?php echo number_format($priceTotal,0,'','.') ?></b></td>
							<td colspan="2">&nbsp;</td>
						</tr>	
					<?php endif; ?>
				<tbody>
			</table>
		<?php endif; ?>
	</div>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
