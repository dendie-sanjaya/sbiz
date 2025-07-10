<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PENJUALAN RESSELLER</h1>
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
							<td width="" valign="top">RESELLER</td>
							<td width="" valign="top">
								<select name="clientId" style="width:180px">
									<option value="x" >Semua</option>
									<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
										<option value="<?php echo $valClient[0] ?>" <?php echo $valClient[0] == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : $dataHeader['client_id']) ? 'selected' : '' ?>><?php echo strtoupper($valClient[1]) ?></option>								
									<?php endwhile; ?>
								</select>				
							</td>						
						</tr>
						<tr>
							<td width="20%">STATUS PENJUALAN</td>
							<td width=>
								<select name="statusOrder" style="width:180px">
									<option value="x" <?php echo 'x' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] :'') ? 'selected' : '' ?>>Semua</option>							
									<option value="4" <?php echo '4' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Belum Bayar</option>
									<option value="0" <?php echo '0' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
									<option value="1" <?php echo '1' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pengemaasan</option>
									<option value="2" <?php echo '2' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pengiriman</option>
									<option value="3" <?php echo '3' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Selesai</option>
								</select>				
							</td>
							<td>VALIDASI PEMBAYARAN</td>					
							<td>
								<select name="statusPayment" style="width:180px">
									<option value="x" <?php echo 'x' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] :$statusPayment) ? 'selected' : '' ?>>Semua</option>							
									<option value="1" <?php echo '1' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Sudah di Validasi</option>
									<option value="0" <?php echo '0' == (isset($_REQUEST['statusPaymenet']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Belum di Validasi</option>
								</select>				
							</td>								
						</tr>
						<tr>
							<td>DARI TANGGAL</td>
							<td>
								<input type="text" name="dateFrom" id="dateFrom" value="" readonly  style="width:180px"  />
							</td>
							<td>SAMPAI TANGGAL</td>							
							<td>
								<input type="text" name="dateTo" id="dateTo" value="" readonly  style="width:180px"  />
							</td>							
						</tr>	
						<tr>
							<td colspan="4"><input type="submit" value="FILTER" style="width: 100%; margin-top:20px" /></td>
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
						<th align="center" width="%">TIPE PEMBAYARAN</th>
						<th align="center" width="15%">JUMLAH</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i= ((1 * $record) + 1); ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="center"><?php echo $val['date_order_frm'] ?></td>
							<td align="center"><?php echo $val['no_order'] ?>
								<?php if(strlen($val['no_resi']) > 0 ): ?>
									<br /><small style="font-size:10px">NO RESI: <?php echo $val['no_resi'] ?>
								<?php endif; ?>				
							</td>
							<td align="center">
								<?php echo $val['name'] ?><br />
								<small>Reseller : <?php echo strtoupper($val['reseller_name']) ?></small>
							</td>
							<td align="center">
								<?php echo $val['is_cod'] == '1' ? 'COD' : 'TRANSFER' ?>
								<?php if(strlen($val['expedition_name']) > 0): ?>
									<br />
									<small style="font-size: 11">KURIR : <?php echo $val['expedition_name'] ?></small>
								<?php endif; ?>	
							</td>
							<td align="center">
								<?php echo number_format($val['jml'],0,'','.')?><br />
								<small style="font-size: 10px">Pembayaran : <?php echo $val['description_payment'] ?></small>		
							</td>							
							<td align="center">
							<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
								<?php if($_SESSION['loginPosition'] == '1'): ?>									
									<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
								<?php else: ?>
									<?php if(in_array($val['status_order'],array(2,3))): ?>
										<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
									<?php else: ?>
										<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
									<?php endif; ?>								
								<?php endif; ?>	
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'statusClose='.$statusClose,'statusOrder='.$statusOrder,'statusPayment='.$statusPayment,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo']));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';a
				?>
			</p>			
		</div>
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
