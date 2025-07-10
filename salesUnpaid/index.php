<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PENJUALAN BELUM BAYAR</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td width="15%" valign="middle">KATA KUNCI</td>
							<td valign="top">
								<input placeholder="NAMA PEMBELI / NO SALES ORDER" name="keyword" type="text" title="abc" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%" />
							</td>
						</tr>	
						<?php if(in_array($positionId,array('1','4','5'))): ?>
							<tr>
								<td valign="top">SALES</td>
								<td "valign="top">
									<select name="salesId[]" style="width:100%; height: 94px" multiple  >
										<?php while($val = mysql_fetch_array($cmbSales)): ?>
											<option value="<?php echo $val['id'] ?>" <?php echo in_array($val['id'],$salesId) == true ? 'selected' : '' ?>><?php echo $val['name'] ?></option>	
										<?php endwhile; ?>	
									</select>				
								</td>																						
							</tr>	
						<?php endif; ?>	
						<tr>
							<td colspan="2">
								<input type="submit" value="FILTER" style="width: 100%" />							
							</td>	
						</tr>												
					</table>
				</form>	
		</fieldset>
		<br />
		
	<?php if(isset($_GET['msgType'])) : ?>
	 	<div class="error">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>	
	<?php elseif(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif; ?>
		
	
	<div class="warning" style="min-height:20px;">
		Data dibawah ini adalah <big style="font-size:14px">PENJUALAN</big> yang  <big style="font-size:14px">BELUM MEMBAYAR</big> 
	</div>	
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="addSave.php" method="post" id="frm" onsubmit="return printLabel()" />	
			<table width="100%">
				<tr>
					<td width="30%">			
						<select name="actionType" id="actionType" style="width:200px;">
							<optgroup label="AKSI">
								<option value="0">-- PILIH AKSI --</option>
								<!--
								<option value="1">PENGEMASAN BARANG</option>
								-->								
								<option value="2">PRINT LABEL ALAMAT</option>	
								<!--
								<option value="3">BATALKAN VALIDASI PEMBAYARAN</option>
							</optgroup>		
							<optgroup label="EXPORT DATA">
								<option value="4">FORMAT EXPEDISI NINJA</option>
							</optgroup>																											-->			
						</select>
						<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
					</td>				
				</tr>
			</table>
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th align="center" width="5%"><input class="bigCheckBox" style="cursor:pointer" type="checkbox" onclick="toggleCheckBox(this)" /></th>				
							<th align="center" width="5%">NO</th>
							<th align="center" width="15%">TGL PEMESANAN</th>
							<th align="center" width="13%">NO SO</th>						
							<th align="center" width="18%">NAMA PEMBELI</th>
							<th align="center" width="15%">KURIR</th>
							<th align="center" width="14%">JUMLAH</th>
							<th align="center" width="%"></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr style="cursor:pointer">
								<td align="center">
									<input class="bigCheckBox" style="cursor:pointer" name="salesOrderId[]" type="checkbox" value="<?php echo $val['id'] ?>" />
								</td>						
								<td align="center"><?php echo $i ?></td>
								<td align="center"><?php echo $val['date_order_frm'] ?></td>
								<td align="center">
									<?php if($val['tipe_order'] == '0'): ?>
										<a href="../salesOrder/print.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a></td>
									<?php else: ?>
										<a href="../salesOrder/print.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a></td>
									<?php endif?>
								<td align="center"><?php echo $val['name'] ?><br />
									<b>
									<?php if($val['is_reseller'] == '1'): ?> 
									  <small style="font-size: 10px">Reseller: <?php echo $val['reseller_name'] ?></small>
									<?php else: ?>
									  <small style="font-size: 10px">Sales: <?php echo $val['sales_name'] ?></small>                    
									<?php endif; ?> 
									</b>
								</td>
								<td align="center">
									<?php if($val['is_warehouse_external'] == '1'): ?>
										<?php echo $val['warehouse_external_name'] ?>
									<?php else: ?>
										<?php echo $val['expedition_name'] ?>
									<?php endif; ?>	
								</td>		
								<td align="center"><?php echo number_format($val['jml'],0,'','.')?><br />
								<small style="font-size: 9px">Pembayaran : <?php echo $val['description_payment'] ?></small>		
									
								</td>

								<td align="center">
									<?php if($val['is_reseller'] == '1'): ?>
										<input type="button" value="EDIT" onclick="window.location='../salesOrderReseller/edit.php?id=<?php echo $val['id'] ?>&redirect=1'" />
									<?php else: ?>
										<input type="button" value="EDIT" onclick="window.location='../salesOrder/edit.php?id=<?php echo $val['id'] ?>&redirect=1'" />
									<?php endif; ?>	

									<?php if($_SESSION['loginPosition'] == '1'): ?>									
										<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='../salesOrder/delete.php?id=<?php echo $val['id'] ?>' : false" />
									<?php else: ?>
										<?php if(in_array($val['status_order'],array(2,3))): ?>
											<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='../salesOrder/delete.php?id=<?php echo $val['id'] ?>' : false" />
										<?php else: ?>
											<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='../salesOrder/delete.php?id=<?php echo $val['id'] ?>' : false" />
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
						echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'tipeOrder='.$tipeOrder,'statusOrder='.$statusOrder,'statusPayment='.$statusPayment));
						echo '<br /><br />';
						echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
					?>
				</p>
			</div>
		</form>	
		
		<script>
			function printLabel() { 
				var e = document.getElementById ("actionType");
				var p = e.options [e.selectedIndex] .value;
					
				if(p == '0') {
					alert('Mohon untuk memilih aksi terlebih dahulu');
					return false;
				}
				
				if(p == '1') {
					if(confirm('Anda yakin akan pengemasan barang ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}

				
				if(p == '2') {
					if(confirm('Anda yakin print label alamat ?')) {
						document.getElementById('frm').action = '../salesPacking/printLabel.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}
				
				if(p == '3') {
					if(confirm('Anda yakin akan membatalkan validasi pembayaran ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}

				if(p == '4') {
					if(confirm('Anda yakin akan export data ke format expidisi ninja ?')) {
						document.getElementById('frm').action = 'excelExpeditionNinja.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}				
			}
		</script>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
