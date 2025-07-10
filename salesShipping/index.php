<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PENGIRIMAN VIA EKSPEDISI</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" id="frmFilter" >	
				   <input type="hidden" name="orderBy" id="orderBy" value="<?php echo $orderBy ?>">				
					<table width="100%">
						<tr>
							<td width="100%" valign="middle" colspan="2">KATA KUNCI &nbsp;&nbsp;&nbsp;&nbsp;
								<input placeholder="NAMA PEMBELI / NO SALES ORDER" name="keyword" type="text" title="abc" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%" />
							</td>
						</tr>
						<tr  >
						  <td width="50%" >
						  	KATERANGAN PEMBAYARAN<br style="margin-bottom: 10px; margin-top:30px" />
							<select name="paymentId[]" style="width:100%; height:100px"  multiple>
								<?php while($val = mysql_fetch_array($cmbFoundSource)): ?>
									<option <?php echo in_array($val['id'],$paymentId) ? ' selected ' : '' ?> value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['paymentId']) ? $_REQUEST['paymentId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
								<?php endwhile; ?>
							</select>				
						  </td>	
						  <td>
							EKPEDISI<br style="margin-bottom: 10px; margin-top:30px" />
							
							<select name="expeditionId[]" style="width:100%; height: 100px" multiple  >
								<?php while($val = mysql_fetch_array($cmbExpedition)): ?>
									<option <?php echo in_array($val['id'],$expeditionId) ? ' selected ' : '' ?> value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['paymentId']) ? $_REQUEST['paymentId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
								<?php endwhile; ?>
							</select>				
						  </td>	

						</tr>	
						</tr>	
							<td valign="bottom" valign="top" colspan="2">
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
		Data dibawah ini adalah <big style="font-size:14px">PENJUALAN</big> yang telah dilakukan <big style="font-size:14px">VALIDASI PEMBAYARAN</big>, <big style="font-size:14px">PENGEMASAN</big> tetapi belum dilakukan <big style="font-size:14px">PENGIRIMAN</big></b>
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
							<option value="0">-- PILIH AKSI --</option>
							<optgroup label="AKSI">
								<option value="1">PENGIRIMAN</option>
								<option value="2">PRINT LABEL ALAMAT</option>	
								<option value="3">BATALKAN PENGEMASAN</option>
							</optgroup>									
							<optgroup label="EXPORT DATA">
								<option value="4">FORMAT EXPEDISI NINJA</option>
								<option value="5">FORMAT EXPEDISI MENGANTAR</option>	
								<option value="6">FORMAT EXPEDISI SAP EXPRESS</option>	
								<option value="7">FORMAT EXPEDISI SICEPAT</option>	
								<option value="8">FORMAT EXPEDISI JDL</option>																																														

							</optgroup>																
						</select>
						<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
					</td>
					<td align="right">
						<b>Urutkan Beradasarkan</b> &nbsp; 
						<select name="oderBy" style="width:150px;" onchange="orderBy(this.value)">
							<option value="expedition_name" <?php echo $orderBy == 'expedition_name' ? 'selected' : '' ?> >EKSPEDISI</option>
							<option value="no_order" <?php echo $orderBy == 'no_order' ? 'selected' : '' ?>>NO SALES ORDER</option>
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
							<th align="center" width="10%">KURIR</th>
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
								<td align="center"><?php echo $val['expedition_name'] ?>								
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
					if(confirm('Anda yakin akan export data ke format expidisi ninja ?')) {
						document.getElementById('frm').action = 'excelExpeditionNinja.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}

				if(p == '5') {
					if(confirm('Anda yakin akan export data ke format expedisi mengantar ?')) {
						document.getElementById('frm').action = 'excelExpeditionMengantar.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}												

				if(p == '6') {
					if(confirm('Anda yakin akan export data ke format expedisi SAP Express ?')) {
						document.getElementById('frm').action = 'excelExpeditionSAPExpress.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}

				if(p == '7') {
					if(confirm('Anda yakin akan export data ke format expedisi SICEPAT ?')) {
						document.getElementById('frm').action = 'excelExpeditionSicepat.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}		

				if(p == '8') {
					if(confirm('Anda yakin akan export data ke format expedisi JDL ?')) {
						document.getElementById('frm').action = 'excelExpeditionJdl.php';	
						document.getElementById('frm').target = '_blank';						
						return true;
					} else {
						return false;
					}				
				}											
			}

			function orderBy(p){
				//window.location = 'index.php?orderBy='+p;
				document.getElementById('orderBy').value = p;
				document.getElementById('frmFilter').submit();
			}
		</script>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
