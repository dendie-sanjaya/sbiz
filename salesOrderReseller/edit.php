	<?php ob_start(); ?>
<?php include 'editRead.php' ?>
	<h1>EDIT PENJUALAN RESELLER</h1>
	<hr />
	<p style="text-align:right">
		<input type="button" value="PRINT FAKTUR PENJUALAN" onclick="window.open('print.php?id=<?php echo $dataHeader['id'] ?>')" />
	</p>
	<form action="edit.php" method="post" id="frm">
		<input type="hidden" name="id" value="<?php echo $id ?>" />
		<fieldset>
			<legend><b>JENIS PEMBELIAN<b></legend>			
				<table width="100%">
					<tr>
						<td width="20%">NO SALES ORDER</td>
						<td width="25%"><b><?php echo $dataHeader['no_order'] ?></b></td>
						<td width="15%">RESELLER</td>
						<td valign="top">
							<b><?php echo strtoupper($dataHeader['reseller_name']) ?></b>
							<small>(<?php echo $dataHeader['reseller_type'] == '1' ? 'Reseller Stok' : 'Dropshipper' ?>)</small>

						</td>
					<tr>
					<tr>
						<td width="20%">TRACKING ORDER</td>
						<td width="25%" colspan="3">
							<b>
								<image onclick="copyText()" src="../asset/image/icon-copy.png" style="width: 20px; border: 0px; margin: 0px; cursor: pointer;" border="0" title="Salin Link Tracking ke clipboard" >&nbsp;
								<a href="https://tracking.mahira.co.id/<?php echo base64_encode($dataHeader['no_order']) ?>" target="_blank">Klik Link Tracking  Ini >></a></b>
								<input style="display: none;" type="text" id="tracking" value="https://tracking.mahira.co.id/<?php echo base64_encode($dataHeader['no_order']) ?>">
							</a>											
						</td>
					<tr>						
				</table>
		</fieldset>
		<br />	
		<fieldset>
			<legend><b>DATA PEMBELI<b></legend>			
				<table width="100%">
					<tr>
						<td width="20%" valign="top">NAMA</td>
						<td width="25%" valign="top">
							<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $dataHeader['name'] ?>" disabled />
							<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
						</td>
						<td width="15%"  valign="top">TELEPON</b>
						<td valign="top">
							<input name="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $dataHeader['phone'] ?>" style="width:280px" disabled  />
							<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
						</td>												
					</tr>
					<tr>
						<td width="" valign="top">ALAMAT PENGIRIMAN</td>
						<td colspan="4" >
							<textarea name="address" style="width:100%; height:50px" disabled><?php echo isset($_POST['address']) ? $_POST['address'] : $dataHeader['address_shipping'] ?></textarea>
							<div style="color:red"><?php echo isset($msgError['address']) ? $msgError['address'] : '' ?></div>
						</td>
					</tr>
					<tr>
						<td>KODE POS</td>
						<td valign="top" colspan="3">
							<input type="hidden" value="0" name="postalCode">
							<input readonly style="width: 100%; height: 35px; background-color: #cccccc" name="ekpedisiPostalCode" type="text" value="<?php echo $dataHeader['postal_code'] ?>" />
							<div style="color:red"><?php echo isset($msgError['ekspedisiPostalCode']) ? $msgError['ekspedisiPostalCode'] : '' ?></div>
						</td>
						<!--
						<td valign="top">
							<span class="button">
								<input type="button" link="postalCode.php?id=<?php echo $id ?>" data-title="CARI KODE POS" data-width="650" data-height="400" style="margin-left: 2px; margin-top:-1px; height: 37px" value="CARI KODE POS" />								
							</span>
						</td>
						-->
					</tr>
					<tr>
						<td>PROVINSI</td>
						<td>
							<input readonly style="background-color: #cccccc" name="province" type="text" value="<?php echo $dataHeader['province'] ?>" />
							<div style="color:red"><?php echo isset($msgError['province']) ? $msgError['province'] : '' ?></div>
						</td>
						<td>KOTA</b>
						<td>
							<input readonly style="background-color: #cccccc" name="city" type="text" value="<?php echo $dataHeader['city'] ?>" style="width:280px"  />
							<div style="color:red"><?php echo isset($msgError['city']) ? $msgError['city'] : '' ?></div>
						</td>												
					</tr>
					<tr>
						<td>KECAMATAN</td>
						<td>
							<input name="districts" readonly style="background-color: #cccccc" type="text" value="<?php echo $dataHeader['districts'] ?>" />
							<div style="color:red"><?php echo isset($msgError['districts']) ? $msgError['districts'] : '' ?></div>
						</td>
						<td>KELURAHAN</td>
						<td>
							<input name="districts_sub" readonly style="background-color: #cccccc" type="text" value="<?php echo $dataHeader['districts_sub'] ?>" />
							<div style="color:red"><?php echo isset($msgError['districts_sub']) ? $msgError['districts'] : '' ?></div>
						</td>
					</tr>

				</table>
		</fieldset>	
		<br />
		<fieldset>
			<legend><b>STATUS PENJUALAN<b></legend>			
			<table width="100%">
				<!--
				<tr>
					<td width="20%">DARI MARKETPLACE</td>
					<td width="25%">
						<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
							<select name="statusMarketplace" style="width:180px" disabled>
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />TIDAK</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />YA</option>
							</select>							
						<?php else: ?>
							<select name="statusMarketplace" style="width:180px"  onclick="setMarketPlace(this.value)" >
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />TIDAK</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />YA</option>
							</select>							
						<?php endif; ?>	
					</td>
					<td>NAMA MARKETPLACE</td>
					<td>
						<input type="text" id="marketplace"  name="marketplace" value="<?php echo isset($_POST['marketplace']) ? $_POST['marketplace'] : $dataHeader['marketplace'] ?>" style="width: 155px" />
					</td>	
				</tr>	
				-->
				<tr>
					<td width="20%">STATUS PENJUALAN </td>
					<td width="25%">
						<?php if($_SESSION['loginPosition'] == '1'): ?>									
							<select id="statusOrder" name="statusOrder" style="width:180px" >
								<option value="4" <?php echo 4 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Belum Bayar</option>
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengemasan</option>
								<option value="2" <?php echo 2 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?> >Pengiriman</option>
								<option value="3" <?php echo 3 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Selesai</option>
							</select>				
						<?php else: ?>
							<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
								<select id="statusOrder" name="statusOrder" style="width:180px" disabled>
									<option value="4" <?php echo 4 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Belum Bayar</option>
									<option value="0" <?php echo 0 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
									<option value="1" <?php echo 1 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengemasan</option>
									<option value="2" <?php echo 2 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Pengiriman</option>
									<option value="3" <?php echo 3 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Selesai</option>
								</select>				
							<?php else: ?>
								<select id="statusOrder" name="statusOrder" style="width:180px" >
									<option value="4" <?php echo 4 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Belum Bayar</option>
									<option value="0" <?php echo 0 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
									<option value="1" <?php echo 1 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengemasan</option>
									<option value="2" <?php echo 2 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?><?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?> >Pengiriman</option>
									<option value="3" <?php echo 3 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Selesai</option>
								</select>				
							<?php endif; ?>								
						<?php endif; ?>							
					</td>
					<td  width="20%">TGL PEMESANAN</b>
					<td>
						<input id="dateOrder" name="dateOrder" type="text" id="dateOrder" size="5"   style="width:155px"  />						
						<div style="color:red; font-size: 10px"><?php echo isset($msgError['dateOrder']) ? $msgError['dateOrder'] : '' ?></div>						
					</td>						
				</tr>				
				<tr>
					<td width="" valign="top">TGL PEMBAYARAN</td>
					<td>
						<input id="datePayment" name="datePayment" type="text" id="datePayment" size="5" style="width:180px"/>						
					</td>
					<td  width="">TGL PENGEMASAN</b>
					<td>
						<input id="datePacking" name="datePacking" type="text" id="datePacking" size="5" style="width:155px"/>						
					</td>												
				</tr>					
				<tr>
					<td width="" valign="top">VALIDASI PEMBAYARAN</td>
					<td>
						<select id="statusPayment" name="statusPayment" style="width:180px" <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>
							<option value="0" <?php echo 0 == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $dataHeader['status_payment']) ? 'selected' : '' ?>>Belum Valid</option>
							<option value="1" <?php echo 1 == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $dataHeader['status_payment']) ? 'selected' : '' ?>>Sudah Valid</option>
						</select>				
					</td>
					<td  width="">TGL PENGIRIMAN</b>
					<td>
						<input name="dateShipping" type="text" id="dateShipping" size="5" style="width:155px" readonly <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?> />						
					</td>												
				</tr>
				<tr>
					<td  width="" rowspan="2" valign="top">KET PEMBAYARAN</td>
					<td  rowspan="2" valign="top">
						<select name="finSourceFundId" style="width:180px">
							<option value="0">&nbsp;</option>
							<?php while($valFoundSource = mysql_fetch_array($dataFoundSource)): ?> 
								<?php $finSourceFundCompare = isset($_REQUEST['finSourceFundId']) ? ($valFoundSource[0].'~'.$valFoundSource[1]) : $valFoundSource[0] ?>
								<option value="<?php echo $valFoundSource[0] ?>~<?php echo $valFoundSource[1] ?>" <?php echo  $finSourceFundCompare == (isset($_REQUEST['finSourceFundId']) ? $_REQUEST['finSourceFundId'] : $dataHeader['fin_source_fund_id']) ? 'selected' : '' ?>><?php echo $valFoundSource[1] ?></option>								
							<?php endwhile; ?>
						</select>				
						<textarea name="descriptionPayment" style="height:50px; width:180px; display: none"><?php echo isset($_POST['descriptionPayment']) ? $_POST['descriptionPayment'] : $dataHeader['description_payment'] ?></textarea>
						<!--	
						<br /><small style="font-size:9px">Contoh : BCA: 9098779 A/N Dendie</small>
						-->
					</td>												
					<td  width="" valign="top">NO RESI PENGIRIMAN</td>
					<td valign="top">
						<input name="noResi" type="text" value="<?php echo isset($_POST['noResi']) ? $_POST['noResi'] : $dataHeader['no_resi'] ?>"  size="5" style="width:155px"/>						
					</td>												
				</tr>	
				<tr>
					<td width="" valign="top">TIPE PEMBAYARAN</td>
					<td valign="top">
						<select id="isCod" name="isCod" style="width:155px" >
							<option value="0" <?php echo '0' == (isset($_REQUEST['isCod']) ? $_REQUEST['isCod'] : $dataHeader['is_cod']) ? 'selected' : '' ?>>Transfer</option>
							<!--
							<option value="1" <?php echo '1' == (isset($_REQUEST['isCod']) ? $_REQUEST['isCod'] : $dataHeader['is_cod']) ? 'selected' : '' ?>>COD</option>
							-->
						</select>						
					</td>												
				</tr>										
			</table>
		</fieldset>	
		<br />
		<fieldset id="detailStuff">
			<a name="databarang"></a> 
			<legend><b>DATA BARANG<b></legend>	
			<!--	
			<p>
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
			</p>
			-->
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="30%">NAMA BARANG</th>
							<th align="center" width="10%">QTY</th>							
							<th align="center" width="15%">HARGA JUAL</th>
							<th align="center" width="15%">JUMLAH</th>
							<th></th>
						</tr>	
					</thead>					
					<tbody>
						<?php $i=1; ?>
						<?php $total = 0 ?>
						<?php while($val = mysql_fetch_array($dataDetail)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td>
									<?php echo $val['name'] ?><br /><small>(<?php echo $val['nickname'] ?>)</small><br /><br />
									<small style="font-size: 9px; color: green">[Harga Reseller ke Pembeli <?php echo number_format($val['price_reseller_to_customer'],0,'','.') ?>]</small>																			
								</td>
								<td align="center">
									<?php echo $val['amount'] ?>
								</td>
								<td align="center">
									<?php echo number_format($val['price'],0,'','.') ?><br /><br />
									<small style="font-size: 9px; color: green">[ <?php echo number_format($val['price_reseller_to_customer'],0,'','.') ?> ]</small>																											
								</td>	
								<td align="center">
									<?php echo number_format($val['price'] * $val['amount'] ,0,'','.') ?><br /><br />
									<small style="font-size: 9px; color: green">[ <?php echo number_format($val['price_reseller_to_customer']  * $val['amount'],0,'','.') ?> ]</small>																											
								</td>																
								<td align="center">	
									<!--
									<?php if($_SESSION['loginPosition'] == '1'): ?>									
										<span class="button">
											<input type="button" link="deleteStuff.php?id=<?php echo $id ?>&salesOrderDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>" data-title="KONFIRMASI HAPUS" data-width="320" data-height="100"  style="width:150px" value="HAPUS BARANG" />
										</span>
									<?php else: ?>
										<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
											<input type="button" data-title="KONFIRMASI HAPUS" data-width="320" data-height="100"  style="width:150px" value="HAPUS BARANG" disabled />
										<?php else: ?>
											<span class="button">
												<input type="button" link="deleteStuff.php?id=<?php echo $id ?>&salesOrderDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>" data-title="KONFIRMASI HAPUS" data-width="320" data-height="100"  style="width:150px" value="HAPUS BARANG" />
											</span>
										<?php endif; ?>								
									<?php endif; ?>	
									-->
								</td>
							</tr>	
							<?php $total = $total + ($val['price'] * $val['amount']) ?>
						<?php $i++; ?>
						<?php endwhile; ?>
					</tbody>
					<tfoot>	
						<tr>
							<td align="left" colspan="4"><b>TOTAL</b></td>
							<td align="center"><b><?php echo number_format($total,0,'','.') ?></b></td>
							<td>&nbsp;</td>
						</tr>						
						<tr>
							<td align="left" colspan="2"><b>DISKON</b></td>
							<td colspan="2" align="right"><input onkeyup="calcDiscount(<?php echo $total ?>)" style="text-align:center; font-size:15px; height:30px; width:100px" type="text" name="discount" id="discount" value="<?php echo isset($_POST['discount']) ? $_POST['discount'] : $dataHeader['discount_persen'] ?>" size="3" /> %</td>
							<td align="center" width="20%"><span id="labelDiskon">0</span></td>
							<td></td>
						</tr>	
						<tr>
							<td colspan="6">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="4"><b>TOTAL SETELAH DISKON</b></td>
							<td align="center"><b><span id="labelTotal"><?php echo number_format($total,0,'','.') ?></b></span></td>
							<td>&nbsp;</td>
						</tr>						
						<tr>
							<td align="left" colspan="4"><b>BIAYA KIRIM</b> 
							</td>
							<td align="center"><input onkeyup="updateTotal(<?php echo $total ?>)" name="costShipping" id="costShipping" style="text-align:center; font-size:15px;  fontheight:30px; width:100px" type="text" value="<?php echo isset($_POST['costShipping']) ? $_POST['costShipping'] : $dataHeader['shipping_cost'] ?>" size="5" /></td>
							<td align="center">
								<select name="expeditionId" style="width:150px">
									<?php while($valExpedition = mysql_fetch_array($cmbExpedition)): ?>
										<?php //if($valExpedition[0] == '3'): ?>
											<option value="<?php echo $valExpedition[0] ?>" <?php echo $valExpedition[0] == (isset($_REQUEST['expeditionId']) ? $_REQUEST['expeditionId'] : $dataHeader['expedition_id']) ? 'selected' : '' ?>><?php echo $valExpedition[1] ?></option>								
										<?php //endif; ?>															
									<?php endwhile; ?>
								</select>				
							</td>
						</tr>												
						<tr>
							<th style="text-align:left" width="5%"colspan="4">GRAND TOTAL</th>
							<th style="font-size:15px;"><b><span id="labelGrandTotal"></span></b></th>
							<th>&nbsp;</th>
						</tr>	
					</tfoot>
				</table>
			</div>
		</fieldset>	
		<hr />		
		<?php if($_SESSION['loginPosition'] == '1'): ?>									
			<input type="button" value="SIMPAN" onclick="frmSave()"/>
		<?php else: ?>
			<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
				<input type="button" value="SIMPAN" disabled />
			<?php else: ?>
				<input type="button" value="SIMPAN" onclick="frmSave()"/>
			<?php endif; ?>								
		<?php endif; ?>	

		<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
	</form>
	<script type="text/javascript">

	calcDiscount('<?php echo $total ?>');
	updateTotal('<?php echo $total ?>');
	
	$(document).ready(function() {
		$(function() {
				$( "#dateOrder" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = isset($_REQUEST['dateOrder']) ? strlen(trim($_REQUEST['dateOrder'])) == 0 ?  '' : explode('/',$_REQUEST['dateOrder']) : explode('/',$dataHeader['date_order_frm']) ?>
				<?php if($tmp[0] != '00'): ?>	
					$("#dateOrder" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>
			});
	});
	
	$(document).ready(function() {
		$(function() {
				$( "#datePacking" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				
				<?php $tmp = isset($_REQUEST['datePacking']) ? strlen(trim($_REQUEST['datePacking'])) == 0 ?  '' : explode('/',$_REQUEST['datePacking']) : explode('/',$dataHeader['date_packing_frm']) ?>
				<?php if($tmp[0] != '00'): ?>	
					$("#datePacking" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>
			});
	});

	$(document).ready(function() {
		$(function() {
				$( "#dateShipping" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				
				<?php $tmp = isset($_REQUEST['dateShipping']) ? strlen(trim($_REQUEST['dateShipping'])) == 0 ?  '' : explode('/',$_REQUEST['dateShipping']) : explode('/',$dataHeader['date_shipping_frm']) ?>
				<?php if($tmp[0] != '00'): ?>				
					$("#dateShipping" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>
			});
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
			var iframe = $('<iframe id="externalSite" class="externalSite" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
			var dialog = $("<div></div>").append(iframe).appendTo("body").dialog({
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
		
		function showPeriodePemesanan(p) {
			if(p == 0) { 
				document.getElementById('periodePemesananLabel').style.display='none';		
				document.getElementById('periodePemesananCmb').style.display='none';		
			} else {
				document.getElementById('periodePemesananLabel').style.display='';		
				document.getElementById('periodePemesananCmb').style.display='';		
			}
		}
		
		showPeriodePemesanan(<?php echo $_REQUEST['tipeOrder'] ?>);

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

			
			var total  =  p - lDiskon; 
			
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

		setMarketPlace(<?php echo isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace'] ?>)

	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
