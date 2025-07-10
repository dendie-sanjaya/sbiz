<?php ob_start(); ?>
	<?php include 'detailRead.php' ?>

	<h1>RINCIAN LAPORAN STOK</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<form action="index.php" method="post">
			<table width="500">		
				<tr>
					<td>	
						<table width="100%">
							<tr>
								<td width="25%" valign="top">KATEGORI</td>
								<td>
									<b> : <?php echo $dataStuff['category_name'] ?>
								</td>
							</tr>							
							<tr>
								<td width="25%">NAMA BARANG</td>
								<td><b> : <?php echo $dataStuff['name'] ?> <small>(<?php echo $dataStuff['nickname'] ?>)</small></b></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</fieldset>

	<p style="text-align:right">
		<input type="button" value="<< KEMBALI" onclick="window.location='index.php'" />
	</p>
	<p>
		<b>Keterangan</b> : Data yang ditampilkan adalah <b>50</b> buah transaksi terakhir.
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
						<th align="center" width="16%">TANGGAL</th>
						<th align="center" width="18%">NAMA BARANG</th>
						<th align="center" width="13%">TIPE</th>
						<th align="center" width="16%">PEMASOK / KLIEN</th>
						<th align="center" width="9%">JUMLAH</th>
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
								<?php echo $val['suplier_name'] ?>
								<?php echo $val['client_name'] ?>
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
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
