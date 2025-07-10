<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PENGIRIMAN VIA GUDANG EKSTERNAL</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td width="15%" valign="middle">KATA KUNCI</td>
							<td valign="top">
								<input placeholder="NAMA PEMBELI / NO SALES ORDER" name="keyword" type="text" title="abc" value="<?php echo $_REQUEST['keyword'] ?>" style="width:400px" />
								<input type="submit" value="FILTER" />
							</td>
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
		Data dibawah ini adalah <big style="font-size:14px">PENJUALAN</big> yang telah dilakukan <big style="font-size:14px">VALIDASI PEMBAYARAN</big>, <big style="font-size:14px">PENGEMASAN</big> tetapi belum dilakukan <big style="font-size:14px">PENGIRIMAN</big></b>
	</div>	

	<?php if(mysql_num_rows($data) < 1) : ?>
		<form action="addSave.php" method="post" id="frm" onsubmit="return printLabel()" />	
			<table width="100%">
				<tr>
					<td width="30%">			
						&nbsp;
					</td>
					<td align="right">
						<b>Filter Berdasarkan Gudang</b> &nbsp; 
						<select name="warehouseExternalId" style="width:150px;" onchange="filterBy(this.value)">
							<option value="x">Semua Gudang</option>  	
							<?php while($valExpedition = mysql_fetch_array($cmbWarehouseExternal)): ?>
								<option value="<?php echo $valExpedition[0] ?>" <?php echo $valExpedition[0] == (isset($_REQUEST['warehouseExternalId']) ? $_REQUEST['warehouseExternalId'] : $dataHeader['warehouse_external_id']) ? 'selected' : '' ?>><?php echo $valExpedition[1] ?></option>								
							<?php endwhile; ?>
						</select>												
					</td>	
				</tr>
			</table>
		</form>	

	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="addSave.php" method="post" id="frm" onsubmit="return printLabel()" />	
			<table width="100%">
				<tr>
					<td width="30%">			
						<select name="actionType" id="actionType" style="width:200px;">
							<option value="0">-- PILIH AKSI --</option>
							<optgroup label="AKSI">
								<option value="1">PENGIRIMAN</option>
								<option value="2">PRINT LABEL ALAMAT</option>	
								<option value="3">BATALKAN VALIDASI PEMBAYARAN</option>
							</optgroup>									
							<optgroup label="EXPORT DATA">
								<option value="4">FORMAT GUDANG EKSTERNAL YUKBISNIS</option>
							</optgroup>																
						</select>
						<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
					</td>
					<td align="right">
						<b>Filter Berdasarkan Gudang</b> &nbsp; 
						<select name="warehouseExternalId" style="width:150px;" onchange="filterBy(this.value)">
							<option value="x">Semua Gudang</option>  	
							<?php while($valExpedition = mysql_fetch_array($cmbWarehouseExternal)): ?>
								<option value="<?php echo $valExpedition[0] ?>" <?php echo $valExpedition[0] == (isset($_REQUEST['warehouseExternalId']) ? $_REQUEST['warehouseExternalId'] : $dataHeader['warehouse_external_id']) ? 'selected' : '' ?>><?php echo $valExpedition[1] ?></option>								
							<?php endwhile; ?>
						</select>												
					</td>	
				</tr>
			</table>
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th align="center" width="5%"><input class="bigCheckBox" style="cursor:pointer" type="checkbox" onclick="toggleCheckBox(this)" /></th>				
							<th align="center" width="5%">NO</th>
							<th align="center" width="7%" style="font-size: 12px">TGL PEMESANAN</th>
							<th align="center" width="22%">NO SO</th>						
							<th align="center" width="14%">NAMA PEMBELI</th>
							<th align="center" width="10%">GUDANG</th>
							<th align="center" width="12%">JUMLAH</th>
							<th align="center" width="12%">NO RESI</th>
							<th align="center" width="%" style="font-size: 12px">FAKTUR PENJUALAN</th>
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
								<td align="center" style="font-size: 11px"><?php echo $val['date_order_frm'] ?></td>
								<td align="left" style="padding-left: 5px">		
									<?php if($val['tipe_order'] == '0'): ?>								
										<a href="../salesOrder/print.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a>
									<?php else: ?>
										<a href="../salesPreOrder/edit.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a>
									<?php endif?>	
									<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
									&nbsp;<a href="../salesOrder/edit.php?id=<?php echo $val['id'] ?>">[Edit]</a>
									<?php endif; ?>

									<div style="font-size: 9px">
										<?php 
										    $salesOrderId = $val['id'];
											$query = "select sod.name, sod.amount,
											 		  (select c.name from const as c where c.id = s.const_id) as satuan 
											 	    from sales_order_detail as sod 
											 	    left join stuff as s 
											 	      on s.id = sod.stuff_id
												    where sod.sales_order_id = '$salesOrderId'
												    order by sod.name asc
												    ";
											$tmpProduk = mysql_query($query) or die(mysql_error());
										?>
										<?php while($rowDetail = mysql_fetch_array($tmpProduk)): ?>
											<div style="margin-top:8px;">
											  (<?php echo $rowDetail['amount'] ?> <?php echo ucfirst(strtolower($rowDetail['satuan'])) ?>) 	
											  <?php echo $rowDetail['name'] ?><br />	
											</div>
										<?php endwhile ?>	
									</div>	
								</td>	
								<td align="center"><?php echo $val['name'] ?><br />
									<b>
									<?php if($val['is_reseller'] == '1'): ?>
									  <small style="font-size: 10px">Reseller: <?php echo $val['reseller_name'] ?></small>
									<?php else: ?>
									  <small style="font-size: 10px">Sales: <?php echo $val['sales_name'] ?></small>                    
									<?php endif; ?> 
									</b>
								</td>	
								<td align="center"><?php echo $val['warehouse_external_name'] ?>								
								<td align="center"><?php echo number_format($val['jml'],0,'','.')?><br />
									<small style="font-size: 10px">Pembayaran: <?php echo $val['description_payment'] ?></small>
								</td>
								<td align="center">
									<!--
									<input type="text" name="noResi[]" value="<?php echo $val['no_resi'] ?>" style="width:90px; text-align:center" />
									-->
									<input type="text" name="noResi_<?php echo $val['id'] ?>" value="<?php echo $val['no_resi'] ?>" style="width:90px; text-align:center" />

								</td>
								<td align="center"><input type="button" value="FAKTUR" onclick="window.open('../salesOrder/print.php?id=<?php echo $val['id'] ?>')" /></td>		
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
				<!--
				<p style="text-align:center; padding:10px">
					<?php
						echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'tipeOrder='.$tipeOrder,'statusOrder='.$statusOrder,'statusPayment='.$statusPayment));
						echo '<br /><br />';
						echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
					?>
				</p>
				-->			
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
					if(confirm('Anda yakin akan melakukan pengiriman ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}

				
				if(p == '2') {
					if(confirm('Anda yakin print label alamat ?')) {
						document.getElementById('frm').action = 'printLabel.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}
				
				if(p == '3') {
					if(confirm('Anda yakin akan membatalkan pengemasan ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}


				if(p == '4') {
					if(confirm('Anda yakin akan export data ke format gudang external yukbisnis ?')) {
						document.getElementById('frm').action = 'excelGudangExternalYubisnis.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}
				
			}
		</script>
	<?php endif; ?>

	<script type="text/javascript">
		function filterBy(p){
			window.location = 'index.php?warehouseExternalId='+p;
		}		
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
