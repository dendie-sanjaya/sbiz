<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PURNA JUAL</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td width="25%" valign="top">KATA KUNCI</td>
							<td valign="top">
								<input placeholder=""name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
								<small style="font-size:8px;"><i>NAMA PEMBELI / NO SALES ORDER / NO RESI</i></small>
							</td>
							<td width="" valign="top">STATUS
								<div id="pilihanSudahDiHubungiLabel" style="display: none"><br />PILIHAN</div>
							</td>
							<td width="" valign="top">
								<select name="status" style="width:180px" onchange="showPilihan(this.value)">
									<option value="0" <?php echo '0' == (isset($_REQUEST['status']) ? $_REQUEST['status'] :$status) ? 'selected' : '' ?> >Belum di Hubungin</option>
									<option value="1" <?php echo '1' == (isset($_REQUEST['status']) ? $_REQUEST['status'] :$status) ? 'selected' : '' ?> >Sudah di Hubungin</option>
									<option value="2" <?php echo '2' == (isset($_REQUEST['status']) ? $_REQUEST['status'] :$status) ? 'selected' : '' ?> >Sedang di Proses</option>
								</select>	
								<?php
								   $responCheckbox = array();
								   if($status == '1') {
									  $responCheckbox = explode('~',$_REQUEST['statusResponCustomerBreakdown']);
								   }
								?>	
								<div id="pilihanSudahDiHubungi" style="display: none"><br />
									<input style="margin-bottom: 8px" type="checkbox" name="checkboxBlmAdaRespon" value="1.1" <?php echo in_array('1.1',$responCheckbox) ? 'checked' : '' ?> > Belum Ada Respon <br />
									<input style="margin-bottom: 8px" type="checkbox" name="checkboxSudahAdaTesti" value="1.2" <?php echo in_array('1.2',$responCheckbox) ? 'checked' : '' ?>> Sudah Ada Testimonal <br />
									<input type="checkbox" name="checkboxSedangProses" value="1.3" <?php echo in_array('1.3',$responCheckbox) ? 'checked' : '' ?>> Repeat Order
								</div>
							</td>						
						</tr>
						<tr>
							<td>DARI TGL PEMESANAN</td>
							<td>
								<input type="text" name="dateFrom" id="dateFrom" value="" readonly  style="width:180px"  />
							</td>
							<td>SAMPAI TGL PEMESANAN</td>							
							<td>
								<input type="text" name="dateTo" id="dateTo" value="" readonly  style="width:180px"  />
							</td>							
						</tr>	
						<tr>
						   <td colspan="4">
						   	    <div style="padding-bottom: 5px; padding-top: 15px">KATEGORI PELANGGAN</div>
								<select name="clientId[]" style="width:100%; height: 120px" multiple>
									<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
										<option value="<?php echo $valClient['id'] ?>" <?php echo in_array($valClient['id'],$clientId) == true ? 'selected' : '' ?>><?php echo $valClient['name'] ?></option>	
									<?php endwhile; ?>
								</select>				
						   </td>	
						</tr>	
						<tr>
							<td colspan="4"><input type="submit" value="FILTER" style="width: 100%; margin-top:20px" /></td>
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
		
	
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<!-- 
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
							</optgroup>																
						</select>
						<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
					</td>
					<td align="right">
						<b>Urutkan Beradasarkan</b> &nbsp; 
						<select name="oderBy" style="width:150px;" onchange="orderBy(this.value)">
							<option value="expedition_name" <?php echo $orderBy == 'expedition_name' ? 'selected' : '' ?> >KURIR</option>
							<option value="no_order" <?php echo $orderBy == 'no_order' ? 'selected' : '' ?>>NO SALES ORDER</option>
						</select>												
					</td>	
				</tr>
			</table>
			-->
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<!--
							<th align="center" width="5%"><input class="bigCheckBox" style="cursor:pointer" type="checkbox" onclick="toggleCheckBox(this)" /></th>				
							-->
							<th align="center" width="5%">NO</th>
							<th align="center" width="7%" style="font-size: 12px">TGL PEMESANAN</th>
							<th align="center" width="7%" style="font-size: 12px">TGL PENGIRIMAN</th>
							<th align="center" width="22%">NO SO</th>						
							<th align="center" width="19%">NAMA PEMBELI</th>
							<th align="center" width="15%">KURIR</th>
							<th align="center" width="%" style="font-size: 12px"></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=(1 + $record ); ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr style="cursor:pointer">
								<!--
								<td align="center">
									<input class="bigCheckBox" style="cursor:pointer" name="salesOrderId[]" type="checkbox" value="<?php echo $val['id'] ?>" />
								</td>
								-->						
								<td align="center"><?php echo $i ?></td>
								<td align="center" style="font-size: 11px"><?php echo $val['date_order_frm'] ?></td>
								<td align="center" style="font-size: 11px"><?php echo $val['date_shipping_frm'] ?></td>
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
											  <?php echo $rowDetail['name'] ?>
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

									<small style="font-size: 10px">Pelanggan: <?php echo $val['client_name'] ?></small>                    

									<div style=" margin-top: 5px">
										<image src="../asset/image/icon-contact/whatsup.png" style="width: 14px; border: 0px; margin: 0px" border="0" >
										<a href="https://api.whatsapp.com/send?phone=<?php echo trim(utf8_encode($val['phone'])) ?>&text=Apa kabar <?php echo trim(ucfirst(strtolower($val['name']))) ?> " style="font-size: 12px;" target="_blank"><?php echo trim(str_replace('-','',utf8_encode($val['phone']))) ?></a>											
									</div>

								</td>	
								<td align="center">
									<?php if($val['is_warehouse_external'] == '1'): ?>
										<?php echo $val['warehouse_external_name'] ?>
									<?php else: ?>
										<?php echo $val['expedition_name'] ?>
									<?php endif; ?>	
									<br />	
									<div style="font-size: 10px; padding-top: 5px">[ No Resi : <?php echo $val['no_resi'] ?> ]</div>									
								</td>								
								<td align="center">
									<input type="button" value="TANGGAPAN PEMBELI" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>&keyword=<?php echo $keyword ?>&status=<?php echo $status ?>&dateFrom=<?php echo $_REQUEST['dateFrom'] ?>&dateTo=<?php echo $_REQUEST['dateTo'] ?>&statusResponCustomerBreakdown=<?php echo $_REQUEST['statusResponCustomerBreakdown'] ?>'" />
								</td>		
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
				<p style="text-align:center; padding:10px">
					<?php
						echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'status='.$status,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo'],'statusResponCustomerBreakdown='.$_REQUEST['statusResponCustomerBreakdown'],'clientId='.$clientIdStr));
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
				
			}

			function orderBy(p){
				window.location = 'index.php?orderBy='+p;
			}	
		</script>		
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


		function showPilihan(p) {
		   if(p == 1) {
			  $("#pilihanSudahDiHubungiLabel").show();		   	
			  $("#pilihanSudahDiHubungi").show();		   	
		   } else {
			  $("#pilihanSudahDiHubungiLabel").hide();		   	
			  $("#pilihanSudahDiHubungi").hide();		   			   	
		   }			   			
		}

		showPilihan('<?php echo isset($_REQUEST['status']) ? $_REQUEST['status'] :$status ?>') 		
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
