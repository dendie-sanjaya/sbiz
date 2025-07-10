<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PEMESANAN</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td width="25%">KATA KUNCI</td>
							<td>
								<input placeholder=""name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
								<small style="font-size:8px"><i>NAMA PEMBELI / NO SALES ORDER / NO RESI</i></small>
							</td>
							<td width="" valign="top">PEDAGANGAN</td>
							<td width="" valign="top">
								<select name="isReseller" style="width:180px">
									<option value="x" <?php echo 'x' == (isset($_REQUEST['isReseller']) ? $_REQUEST['isReseller'] : $isReseller) ? 'selected' : '' ?>>Semua</option>
									<option value="0" <?php echo '0' == (isset($_REQUEST['isReseller']) ? $_REQUEST['isReseller'] : $isReseller) ? 'selected' : '' ?>>YA</option>
									<option value="1" <?php echo '1' == (isset($_REQUEST['isReseller']) ? $_REQUEST['isReseller'] : $isReseller) ? 'selected' : '' ?>>TIDAK</option>
								</select>				
							</td>						
						</tr>
						<tr>
							<td width="20%">STATUS PENJUALAN</td>
							<td width="">
								<select name="statusOrder" style="width:180px">
									<option value="x" <?php echo 'x' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] :'') ? 'selected' : '' ?>>Semua</option>							
									<option value="0" <?php echo '0' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pemesanan</option>
									<option value="1" <?php echo '1' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pengemaasan</option>
									<option value="2" <?php echo '2' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pengiriman</option>
								</select>				
							</td>
						
							<!--
							<td width="20%">TIPE PENJUALAN</td>
							<td width="">
								<select name="tipeOrder" style="width:180px">
									<option value="x" <?php echo 'x' == (isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : $tipeOrder) ? 'selected' : '' ?>>Semua</option>
									<option value="0" <?php echo '0' == (isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : $tipeOrder) ? 'selected' : '' ?>>Langsung</option>
									<option value="1" <?php echo '1' == (isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : $tipeOrder) ? 'selected' : '' ?>>Pemesanan</option>
								</select>				
							</td>
							-->
							<td>STATUS TRANSAKSI</td>					
								<td>
									<select name="statusClose" style="width:180px">
										<option value="0" <?php echo '0' == (isset($_REQUEST['statusClose']) ? $_REQUEST['statusClose'] : $statusPayment) ? 'selected' : '' ?>>Belum Selesai</option>
										<option value="1" <?php echo '1' == (isset($_REQUEST['statusClose']) ? $_REQUEST['statusClose'] : $statusPayment) ? 'selected' : '' ?>>Telah Selesai</option>
									</select>				
								</td>	
							</td>
						<tr>
						<tr>
							<td>STATUS PEMBAYARAN</td>					
							<td>
								<select name="statusPayment" style="width:180px">
									<option value="x" <?php echo 'x' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] :$statusPayment) ? 'selected' : '' ?>>Semua</option>							
									<option value="0" <?php echo '0' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Belum Bayar</option>
									<option value="1" <?php echo '1' == (isset($_REQUEST['statusPaymenet']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Sudah Bayar</option>
								</select>				
							</td>	
							<td><input type="submit" value="FILTER" /></td>
							<td>
								
							</td>
						</tr>						
					</table>
				</form>	
		</fieldset>
		<br />
	
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
						<th align="center" width="%">TGL PEMESANAN</th>
						<th align="center" width="%">NO SALES ORDER</th>						
						<th align="center" width="%">NAMA PEMBELI</th>
						<th align="center" width="%">JUMLAH</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="center"><?php echo $val['date_order_frm'] ?></td>
							<td align="center"><?php echo $val['no_order'] ?>
								<?php if(strlen($val['no_resi']) > 0 ): ?>
									<br /><small style="font-size:10px">NO RESI: <?php echo $val['no_resi'] ?>
								<?php endif; ?>				
							</td>
							<td align="center"><?php echo $val['name'] ?></td>
							<td align="center"><?php echo number_format($val['jml'],0,'','.')?></td>							
							<td align="center">
							<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
							<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'statusClose='.$statusClose,'statusOrder=','statusOrder='.$statusOrder,'statusPayment='.$statusPayment));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>			
		</div>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
