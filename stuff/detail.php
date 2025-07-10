<?php ob_start(); ?>
	<?php include 'detailRead.php' ?>

	<h1>LAPORAN TRANSAKSI RINCIAN BARANG</h1>

	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<form action="index.php" method="post">
			<table width="500">
				<tr>
					<td>	
						<table width="100%">
							<tr>
								<td width="25%">NAMA BARANG</td>
								<td> : <?php echo $dataStuff['name'] ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</fieldset>

	<p style="text-align:right">
		<input type="button" value="<< KEMBALI" onclick="history.go(-1)" />
	</p>

	<div id="tbl">
		<table width="100%" border="1">
			<thead>			
				<tr>
					<th align="center" width="5%">NO</th>
					<th align="center" width="15%">TANGGAL</th>
					<th align="center" width="20%">NAMA BARANG</th>
					<th align="center" width="15%">TIPE</th>
					<th align="center" width="10%">JUMLAH</th>
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
							<?php echo $val['name'] ?>
						</td>
						<td valign="top" align="center">
							<?php echo $val['tipe'] == 0 ? 'BRG. KELUAR' : 'BRG. MASUK' ?>
						</td>
						<td valign="top" align="center">
							<?php echo $val['amount'] ?>
							<?php echo $val['const_name'] ?>
						</td>
						<td valign="top" align="left">
							<?php echo $val['description'] ?>
						</td>
					</tr>	
				<?php $i++; ?>
				<?php endwhile; ?>
			<tbody>
		</table>
	</div>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
