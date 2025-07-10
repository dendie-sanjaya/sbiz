<?php ob_start(); ?>
<?php include 'addRead.php' ?>
	<h1>TAMBAH RETUR PENJUALAN</h1>
	<hr />
	<div style="margin: 10px 0px 10px 0px; text-align: right; width: 100%">
		<input type="button" value="KEMBALI KE DAFTAR RETUR PENJUALAN" onclick="window.location='index.php?type=0'" />		
	</div>	
	<form action="add.php" method="post" onsubmit="this.action='add.php'; this.submit()">
		<fieldset>
			<legend><b>PILIH SALES ORDER<b></legend>			
				<table width="100%">
					<tr>
						<td width="30%">MASUKAN NO SALES ORDER</td>
						<td>
							<input type="hidden" name="hiddenPurchaseOrderId" value="<?php echo $_REQUEST['purchaseOrderId'] ?>" 	/>
							<input type="text" name="purchaseOrderName" id="purchaseOrderName"  value="<?php echo trim($_REQUEST['purchaseOrderName']) ?>" style="width: 54%" />	
							<input type="submit" name="cari" value="CARI " style="width: 30%" /><br />
							<div style="color:red"><?php echo $msgError['cari'] ?></div>		
						</td>			
					<tr>
					<tr>
						<td  >TGL RETUR BARANG </b>
						<td>
							<input name="dateReturn" type="text" id="dateReturn" size="5"   style="width:85%"/>						
						</td>											
					</tr>						
				</table>
		</fieldset>
		</form>
		
		<?php if($statusdiTemukan == '1'): ?> 
		<form action="addSave.php" method="post">				
			<input type="hidden" name="purchaseOrderName" value="<?php echo $dataHeader['no_order'] ?>" 	/>			
			<input name="dateReturn" type="hidden" id="dateReturn" size="5" value="<?php echo $_REQUEST['dateReturn'] ?>" />						
			<br />
			<br />
			<fieldset>
				<legend><b>JENIS PEMBELIAN<b></legend>			
					<table width="100%">
						<tr>
							<td width="20%">NO SALES ORDER</td>
							<td width="25%"><b><?php echo $dataHeader['no_order'] ?></b></td>
							<td width="15%">PELANGGAN</td>
							<td>
								<input type="hidden" name="hiddenClientId" value="<?php echo $_REQUEST['clientId'] ?>" 	/>
								<select name="clientId" style="width:280px" onchange='this.form.submit()' disabled>
									<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
											<option value="<?php echo $valClient[0] ?>" <?php echo $valClient[0] == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : $dataHeader['client_id']) ? 'selected' : '' ?>><?php echo $valClient[1] ?> - <?php echo $valClient[2] ?></option>								
									<?php endwhile; ?>
								</select>				
							</td>
						<tr>
					</table>
			</fieldset>
			<br />
			<br />		
			<fieldset>
				<legend><b>DATA PEMBELI<b></legend>			
					<table width="100%">
						<tr>
							<td width="20%" valign="top">NAMA</td>
							<td width="25%" valign="top">
								<input disabled name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $dataHeader['name'] ?>" />
								<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
							</td>
							<td width="15%"  valign="top">TELEPON</b>
							<td valign="top">
								<image src="../asset/image/icon-contact/whatsup.png" style="width: 14px; border: 0px; margin: 0px" border="0" >
								<a href="https://api.whatsapp.com/send?phone=<?php echo trim(utf8_encode($dataHeader['phone'])) ?>&text=Apa kabar <?php echo trim(ucfirst(strtolower($dataHeader['name']))) ?> " style="font-size: 12px;" target="_blank"><?php echo trim(str_replace('-','',utf8_encode($dataHeader['phone']))) ?></a>																		
							</td>												
						</tr>
						<tr>
							<td width="" valign="top">ALAMAT PENGIRIMAN</td>
							<td colspan="4">
								<textarea disabled name="address" style="width:100%; height:100px"><?php echo isset($_POST['address']) ? $_POST['address'] : $dataHeader['address_shipping'] ?></textarea>
								<div style="color:red"><?php echo isset($msgError['address']) ? $msgError['address'] : '' ?></div>
							</td>
						</tr>
						<tr>
							<td width="" valign="top">JALUR PENGIRIMAN</td>
							<td colspan="4">
								<select disabled name="isWarehouseExternal" style="width:100%" onchange="warehouseEsternal(this.value)">
									<option value="0" <?php echo (isset($_REQUEST['isWarehouseExternal']) ? $_REQUEST['isWarehouseExternal'] : $dataHeader['is_warehouse_external']) == '0' ? 'selected' : '' ?>>Via Ekspedisi</option>
									<option value="1" <?php echo (isset($_REQUEST['isWarehouseExternal']) ? $_REQUEST['isWarehouseExternal'] : $dataHeader['is_warehouse_external']) == '1' ?  'selected' : '' ?>>Via Gudang Eksternal</option>
								</select>	
							</td>
						</tr>
						<tr id="warehouseEksternalData1" style="display: none">
							<td>PROVINSI</td>
							<td>
								<input disabled name="province" type="text" value="<?php echo isset($_POST['province']) ? $_POST['province'] : $dataHeader['province'] ?>" />
								<div style="color:red"><?php echo isset($msgError['province']) ? $msgError['province'] : '' ?></div>
							</td>
							<td>KOTA</b>
							<td>
								<input disabled name="city" type="text" value="<?php echo isset($_POST['city']) ? $_POST['city'] : $dataHeader['city'] ?>" style="width:280px"  />
								<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
							</td>												
						</tr>
						<tr id="warehouseEksternalData2" style="display: none">
							<td>KECAMATAN</td>
							<td>
								<input disabled name="districts" type="text" value="<?php echo isset($_POST['districts']) ? $_POST['districts'] : $dataHeader['districts'] ?>" />
								<div style="color:red"><?php echo isset($msgError['districts']) ? $msgError['districts'] : '' ?></div>
							</td>
							<td>KELURAHAN</b>
							<td>
								<input disabled name="districtsSub" type="text" value="<?php echo isset($_POST['districtsSub']) ? $_POST['districts_sub'] : $dataHeader['districts_sub'] ?>" style="width:280px"  />
								<div style="color:red"><?php echo isset($msgError['districtsSub']) ? $msgError['districtsSub'] : '' ?></div>
							</td>												
						</tr>
						<tr id="warehouseEksternalData3" style="display: none">
							<td>KODE POS</td>
							<td colspan="3">
								<input disabled style="width: 89%" name="postalCode" type="text" value="<?php echo isset($_POST['postalCode']) ? $_POST['postalCode'] : $dataHeader['postal_code'] ?>" />
								<div style="color:red"><?php echo isset($msgError['postalCode']) ? $msgError['postalCode'] : '' ?></div>
							</td>
						</tr>					
					</table>
			</fieldset>	
			<br />
			<br />
			<fieldset id="detailStuff">
				<a name="databarang"></a> 
				<legend><b>DATA BARANG<b></legend>	
				<p>
					<!--
					<?php if($_SESSION['loginPosition'] == '1'): ?>									
						<span class="button">
							<input type="button" link="addStuff.php?id=<?php echo $id ?>" data-title="TAMBAH BARANG" data-width="650" data-height="400"  style="width:220px" value="TAMBAH BARANG" />
						</span>
					<?php else: ?>
						<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
							<input type="button" value="TAMBAH BARANG" disabled />
						<?php else: ?>
							<span class="button">
								<input type="button" link="addStuff.php?id=<?php echo $id ?>" data-title="TAMBAH BARANG" data-width="650" data-height="400"  style="width:220px" value="TAMBAH BARANG" />
							</span>
						<?php endif; ?>								
					<?php endif; ?>	
					-->
				</p>
				
				<div id="tbl">
					<table width="100%" border="1">
						<thead>			
							<tr>
								<th align="center" width="5%">NO</th>
								<th align="center" width="40%">NAMA BARANG</th>
								<th align="center" width="10%">QTY</th>							
								<th align="center" width="15%">HARGA JUAL</th>
								<th align="center" width="15%">JUMLAH</th>
							</tr>	
						</thead>					
						<tbody>
							<?php $i=1; ?>
							<?php $total = 0 ?>
							<?php while($val = mysql_fetch_array($dataDetail)): ?>
								<tr>
									<td align="center"><?php echo $i ?></td>
									<td>
										<?php if($val['is_bundling'] == '1'): ?>
											<?php echo $val['name'] ?><br />
										    <?php 
										    	include '../lib/connection.php';
										    	$query = "select b.id, b.stuff_id, b.qty, s.name
													 from sales_order_detail_bundling as b
													 inner join stuff as s
													   on s.id = b.stuff_id
													 where sales_order_detail_id = '{$val['id']}'
													 order by id asc";
												$rstDetailBundling = mysql_query($query) or die (mysql_error());
												include '../lib/connection-close.php';
											?>
											<?php while($dataDetailBundling = mysql_fetch_array($rstDetailBundling)): ?>
												<small style="font-size: 10px"><?php echo $dataDetailBundling['name'] ?> (<?php echo $dataDetailBundling['qty'] ?>),</small>	
											<?php endwhile; ?>											
										<?php else: ?>	
											<?php echo $val['name'] ?><br /><small>(<?php echo $val['nickname'] ?>)</small>
										<?php endif; ?>	
									</td>
									<td align="center">
										<?php echo $val['amount'] ?>
									</td>
									<td align="center"><?php echo number_format($val['price'],0,'','.') ?></td>	
									<td align="center"><?php echo number_format($val['price'] * $val['amount'] ,0,'','.') ?></td>								
								</tr>	
								<?php $total = $total + ($val['price'] * $val['amount']) ?>
							<?php $i++; ?>
							<?php endwhile; ?>
						</tbody>
						<tfoot>	
							<tr>
								<td align="left" colspan="4"><b>TOTAL</b></td>
								<td align="center"><b><?php echo number_format($total,0,'','.') ?></b></td>
							</tr>						
							<tr>
								<td align="left" colspan="2"><b>DISKON</b></td>
								<td colspan="2" align="right"><input disabled onkeyup="calcDiscount(<?php echo $total ?>)" style="text-align:center; font-size:15px; height:30px; width:100px" type="text" name="discount" id="discount" value="<?php echo isset($_POST['discount']) ? $_POST['discount'] : $dataHeader['discount_persen'] ?>" size="3" /> %</td>
								<td align="center" width="20%"><span id="labelDiskon">0</span></td>
							</tr>	
							<tr>
								<td align="left" colspan="2"><b>DISKON NOMINAL</b></td>
								<td colspan="2" align="right"><input id="discountNominal" disabled onkeyup="calcDiscount(<?php echo $total ?>)" style="text-align:center; font-size:15px; height:30px; width:100px" type="text" name="discountNominal" id="discountNominal" value="<?php echo isset($_POST['discountNominal']) ? $_POST['discountNominal'] : $dataHeader['discount_amount'] ?>" size="3" /> &nbsp;&nbsp;</td>
								<td align="center" width="20%"></td>
							</tr>							
							<tr>
								<td colspan="5">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="4"><b>TOTAL SETELAH DISKON</b></td>
								<td align="center"><b><span id="labelTotal"><?php echo number_format($total,0,'','.') ?></b></span></td>
							</tr>						
							<tr>
								<td align="left" colspan="3"><b>BIAYA KIRIM</b> 
								</td>
								<td align="center">
									<select disabled="" id="expeditionId" name="expeditionId" style="width:200px">
										<?php while($valExpedition = mysql_fetch_array($cmbExpedition)): ?>
											<option value="<?php echo $valExpedition[0] ?>" <?php echo $valExpedition[0] == (isset($_REQUEST['expeditionId']) ? $_REQUEST['expeditionId'] : $dataHeader['expedition_id']) ? 'selected' : '' ?>><?php echo $valExpedition[1] ?></option>								
										<?php endwhile; ?>
									</select>				

									<select disabled id="warehouseExternalId" name="warehouseExternalId" style="width:150px; display: none;">
										<?php while($valExpedition = mysql_fetch_array($cmbWarehouseExternal)): ?>
											<option value="<?php echo $valExpedition[0] ?>" <?php echo $valExpedition[0] == (isset($_REQUEST['warehouseExternalId']) ? $_REQUEST['warehouseExternalId'] : $dataHeader['warehouse_external_id']) ? 'selected' : '' ?>><?php echo $valExpedition[1] ?></option>								
										<?php endwhile; ?>
									</select>	
								</td>
								<td align="center"><input disabled onkeyup="updateTotal(<?php echo $total ?>)" name="costShipping" id="costShipping" style="text-align:center; font-size:15px;  fontheight:30px; width:100px" type="text" value="<?php echo isset($_POST['costShipping']) ? $_POST['costShipping'] : $dataHeader['shipping_cost'] ?>" size="5" /></td>								
							</tr>												
							<tr>
								<th style="text-align:left" width="5%"colspan="4">GRAND TOTAL</th>
								<th style="font-size:15px;"><b><span id="labelGrandTotal"></span></b></th>
							</tr>	
						</tfoot>
					</table>
				</div>
			</fieldset>	
			
			<hr />			
			<input type="submit" value="SIMPAN RETUR PENJUALAN"/>
			<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />		
		</form>
		<?php endif; ?>
	<script type="text/javascript">

		$(function() {
			$( "#dateReturn" ).datepicker({
				dateFormat : 'dd/mm/yy',
				changeMonth : true,
				changeYear : true,
				yearRange: '-2y:c+nn',
				maxDate: '0d',
			}); 
			<?php $tmp = isset($_REQUEST['dateReturn']) ? strlen(trim($_REQUEST['dateReturn'])) == 0 ?  '' : explode('/',$_REQUEST['dateReturn']) : explode('/',date('d/m/Y')) ?>
			<?php if($tmp[0] != '00'): ?>	
				$("#dateReturn" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			<?php endif; ?>
		});


		<?php if($statusdiTemukan == '1'): ?> 	
			calcDiscount('<?php echo $total ?>');
			updateTotal('<?php echo $total ?>');

			$(document).ready(function() {
			});
			

			$(document).ready(function() {
				$(function() {
						$( "#datePayment" ).datepicker({
							dateFormat : 'dd/mm/yy',
							changeMonth : true,
							changeYear : true,
							yearRange: '-2y:c+nn',
							maxDate: '0d',
						}); 
						<?php $tmp = isset($_REQUEST['datePayment']) ? strlen(trim($_REQUEST['datePayment'])) == 0 ?  '' : explode('/',$_REQUEST['datePayment']) : explode('/',$dataHeader['date_payment_frm']) ?>	
						<?php if($tmp[0] != '00'): ?>
							$("#datePayment" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
						<?php endif; ?>	
					});
			});
				var iframe = '';
				var dialog = '';
				$(function () {
					var iframe = $('<iframe id="externalSite" class="externalSite" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen style="text-align:center" align="center"></iframe>');
					var dialog = $("<div style='text-align:center'></div>").append(iframe).appendTo("body").dialog({
						autoOpen: false,
						modal: true,
						resizable: false,
						width: "auto",
						height: "auto",
						close: function () {
							iframe.attr("src", "");
						}
					});
					$(".button a").on("click", function (e) {
						e.preventDefault();
						var src = $(this).attr("href");
						var title = $(this).attr("data-title");
						var width = $(this).attr("data-width");
						var height = $(this).attr("data-height");
						iframe.attr({
							width: +width,
							height: +height,
							src: src
						});	
						dialog.dialog("option", "title", title).dialog("open");
					});
					
					$(".button input").on("click", function (e) {
						e.preventDefault();
						var src = $(this).attr("link");
						var title = $(this).attr("data-title");
						var width = $(this).attr("data-width");
						var height = $(this).attr("data-height");
						iframe.attr({
							width: +width,
							height: +height,
							src: src
						});	
						dialog.dialog("option", "title", title).dialog("open");
					});
					
				});

				function warehouseEsternal(p) {
					if(p == 1) {
					  $('#warehouseEksternalData1').show();
					  $('#warehouseEksternalData2').show();
					  $('#warehouseEksternalData3').show();
					  $('#warehouseExternalId').show();		  
					  $('#expeditionId').hide();		  
					} else {
					  $('#warehouseEksternalData1').hide();
					  $('#warehouseEksternalData2').hide();
					  $('#warehouseEksternalData3').hide();			
					  $('#warehouseExternalId').hide();		  
					  $('#expeditionId').show();		  
					}	
				}	

				warehouseEsternal(<?php echo isset($_REQUEST['isWarehouseExternal']) ? $_REQUEST['isWarehouseExternal'] : $dataHeader['is_warehouse_external'] ?> );	

				
				function showPeriodePemesanan(p) {
					if(p == 0) { 
						document.getElementById('periodePemesananLabel').style.display='none';		
						document.getElementById('periodePemesananCmb').style.display='none';		
					} else {
						document.getElementById('periodePemesananLabel').style.display='';		
						document.getElementById('periodePemesananCmb').style.display='';		
					}
				}
				
				//showPeriodePemesanan(<?php echo $_REQUEST['tipeOrder'] ?>);

				<?php if(isset($_REQUEST['jumpTo'])): ?>
					document.getElementById("detailStuff").scrollIntoView(true);			
				<?php endif; ?>	

				function calcDiscount(p) { 
					var vDiscount = document.getElementById('discount').value;
					var r = 0;
					r = (p / 100) * vDiscount;				
					document.getElementById('labelDiskon').innerHTML = r; 
					$('#labelDiskon').simpleMoneyFormat();	
			
					updateTotal(p);	
				}
				
				function updateTotal(p) {
					var lDiskon = document.getElementById('labelDiskon').innerHTML;

					lDiskon  = lDiskon.replace(".","");
					lDiskon  = lDiskon.replace(".","");
					lDiskon  = lDiskon.replace(".","");

					var lDiskonAmount = document.getElementById('discountNominal').value;
					
					var total  =  (p - lDiskon) - lDiskonAmount; 
					
					document.getElementById('labelTotal').innerHTML = total;
					$('#labelTotal').simpleMoneyFormat();

					updateGrandTotal(total);	
				}
				
				function updateGrandTotal(p) {
					var costShipping =   document.getElementById('costShipping').value;

					costShipping  =  parseInt(costShipping.replace(".","")); 
					var total  =  p + costShipping; 
					
					document.getElementById('labelGrandTotal').innerHTML = total;			
					$('#labelGrandTotal').simpleMoneyFormat();			
				}
				
				
				function frmSave() {
					parent.document.getElementById('frm').action = 'editSave.php';
					parent.document.getElementById('frm').submit();
				}
				
				/*
				function closeModal(frameElement) {
					//alert('dari parent');
					//dialog("close");
					dialog.modal("hide");
					//alert(dialog.dialog.dialog("open"));
					//dialog.dialog("close")
					//$('#externalSite').modal().hide();
					/*
					if (frameElement) {
						var dialog = $(frameElement).closest(".modal");
						alert (dialog)
						if (dialog.length > 0) {
							alert('ok');
							dialog.modal("hide");
						}
					}
					
				} */

				function closeModal(frameElement) { alert('hai');
					 if (frameElement) {
						var dialog = $('externalSite').closest(".modal");
						if (dialog.length > 0) {
							dialog.modal("hide");
						}
					 }
				}		

				function setMarketPlace(p) {
					if(p == 1) {				
					  var d = new Date();
					  var now = d.getDate() + '/' +d.getMonth() + '/' + d.getFullYear();

					  $('#marketplace').prop("disabled",false);			  
					  $('#statusOrder').val(2);
					  $('#statusPayment').val(1);			  
					  $("#datePayment" ).datepicker("setDate", new Date(d.getFullYear,d.getMonth(),d.getDate()));
					  $("#datePacking" ).datepicker("setDate", new Date(d.getFullYear,d.getMonth(),d.getDate()));
					} else {
					  $('#marketplace').prop("disabled",true);
					  $('#marketplace').val('');
					  $('#statusOrder').val(4);
					  $('#statusPayment').val(0);			  
					  $("#datePayment" ).val('');
					  $("#datePacking" ).val('');
					}
				}	


				function showPilihan(p) {
				   if(p == 1) {
					  $("#pilihanSudahDiHubungiLabel").show();		   	
					  $("#pilihanSudahDiHubungi").show();		   	
				   } else {
					  $("#pilihanSudahDiHubungiLabel").hide();		   	
					  $("#pilihanSudahDiHubungi").hide();		   			   	
				   }			   			
				}

				showPilihan('<?php echo $dataHeader['status_respon_customer'] ?>') 
				setMarketPlace(<?php echo isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace'] ?>)

		<?php endif; ?>			
	</script>
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
