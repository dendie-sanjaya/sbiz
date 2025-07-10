	<?php ob_start(); ?>
<?php include 'editRead.php' ?>
	<h1>EDIT PEMESANAN</h1>
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
						<td>NO SALES ORDER</td>
						<td colspan="4"><b><?php echo $dataHeader['no_order'] ?></b></td>
					<tr>
					<tr>
						<td width="20%">TIPE PENJUALAN</td>
						<td width="25%" ><b>Pemesanan / Pre Order</b>
							<input type="hidden" name="tipeOrder" value="1" />
							<!--	
							<select name="tipeOrder" style="width:180px" onchange="showPeriodePemesanan(this.value)">
								<option value="0" <?php echo 0 == (isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : $dataHeader['tipe_order']) ? 'selected' : '' ?>>Langsung</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : $dataHeader['tipe_order']) ? 'selected' : '' ?>>Pemesanan</option>
							</select>
							-->	
						</td>
						<td>Pedagang</td>
						<td>
							<input type="hidden" name="hiddenClientId" value="<?php echo $_REQUEST['clientId'] ?>" 	/>
							<select name="clientId" style="width:280px" onchange='this.form.submit()'>
								<option value="0" <?php echo 0 == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : '') ? 'selected' : '' ?>>Bukan Pedagang</option>
								<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
										<option value="<?php echo $valClient[0] ?>" <?php echo $valClient[0] == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : $dataHeader['client_id']) ? 'selected' : '' ?>><?php echo $valClient[1] ?> - <?php echo $valClient[2] ?></option>								
								<?php endwhile; ?>
							</select>				

						</td>
					<tr>
					</tr>		
						<td  width="20%" id="periodePemesananLabel" style="display:none">PERIODE PEMESANAN</b>
						<td style="display:none" id="periodePemesananCmb">
							<select name="periodeOrderId" style="width:180px">
								<?php while($val = mysql_fetch_array($dataPeriodeOrder)): ?>
									<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['periodeOrderId']) ? $_REQUEST['periodeOrderId'] : $dataHeader['period_order_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
								<?php endwhile; ?>
							</select>				
						</td>
					</tr>
				</table>
		</fieldset>
		<br />	
		<fieldset>
			<legend><b>DATA PEMBELI<b></legend>			
				<table width="100%">
					<tr>
						<td width="20%" valign="top">NAMA</td>
						<td width="25%" valign="top">
							<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $dataHeader['name'] ?>" />
							<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
						</td>
						<td width="15%"  valign="top">TELEPON</b>
						<td valign="top">
							<input name="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $dataHeader['phone'] ?>" />
							<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
						</td>												
					</tr>
					<tr>
						<td width="" valign="top">ALAMAT PENGIRIMAN</td>
						<td colspan="4">
							<textarea name="address" style="width:600px; height:50px"><?php echo isset($_POST['address']) ? $_POST['address'] : $dataHeader['address_shipping'] ?></textarea>
							<div style="color:red"><?php echo isset($msgError['address']) ? $msgError['address'] : '' ?></div>
						</td>
					</tr>
				</table>
		</fieldset>	
		<br />
		<fieldset>
			<legend><b>STATUS PENJUALAN<b></legend>			
			<table width="100%">
					<tr>
						<td width="20%">STATUS PENJUALAN</td>
						<td width="25%">
							<select name="statusOrder" style="width:180px">
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pemesanan</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengemaasan</option>
								<option value="2" <?php echo 2 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengiriman</option>
							</select>				
						</td>
						<td  width="20%">TGL PEMESANAN</b>
						<td>
							<input name="dateOrder" type="text" id="dateOrder" size="5"   style="width:155px"/>						
						</td>						
					</tr>				
					<tr>
						<td width="" valign="top">STATUS PEMBAYARAN</td>
						<td>
							<select name="statusPayment" style="width:180px">
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $dataHeader['status_payment']) ? 'selected' : '' ?>>Belum Bayar</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $dataHeader['status_payment']) ? 'selected' : '' ?>>Sudah Bayar</option>
							</select>				
						</td>
						<td  width="">TGL PENGEMASAN</b>
						<td>
							<input name="datePacking" type="text" id="datePacking" size="5" style="width:155px"/>						
						</td>												
					</tr>
					<tr>
						<td width="" valign="top">TGL PEMBAYARAN</td>
						<td>
							<input name="datePayment" type="text" id="datePayment" size="5" style="width:180px"/>						
						</td>
						<td  width="">TGL PENGIRIMAN</b>
						<td>
							<input name="dateShipping" type="text" id="dateShipping" size="5" style="width:155px"/>						
						</td>												
					</tr>
					<tr>
						<td  width="" valign="top">KET PEMBAYARAN</td>
						<td>
							<textarea name="descriptionPayment" style="height:50px; width:180px"><?php echo isset($_POST['descriptionPayment']) ? $_POST['descriptionPayment'] : $dataHeader['description_payment'] ?></textarea>
							<br /><small style="font-size:9px">Contoh : BCA: 9098779 A/N Dendie</small>
						</td>												
						<td  width="" valign="top">KET PENGIRIMAN</td>
						<td>
							<textarea name="descriptionShipping" style="height:50px; width:250px"><?php echo isset($_POST['descriptionShipping']) ? $_POST['descriptionShipping'] : $dataHeader['description_shipping'] ?></textarea>
							<br /><small  style="font-size:9px">Contoh : No Resi JNE: 9098779883</small>
						</td>												
					</tr>	
					<tr>
						<td width="" valign="top">STATUS TRANSAKSI</td>
						<td>
							<select name="statusClose" style="width:180px">
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusClose']) ? $_REQUEST['statusClose'] : $dataHeader['status_close']) ? 'selected' : '' ?>>Belum Selesai</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusClose']) ? $_REQUEST['statusClose'] : $dataHeader['status_close']) ? 'selected' : '' ?>>Telah Selesai</option>
							</select>				
						</td>
						<td  width="">NO RESI</b>
						<td>
							<input name="noResi" type="text" value="<?php echo isset($_POST['no_resi']) ? $_POST['no_resi'] : $dataHeader['no_resi'] ?>"  size="5" style="width:155px"/>						
						</td>												
					</tr>					
				</table>
		</fieldset>	
		<br />
		<fieldset id="detailStuff">
			<legend><b>DATA BARANG<b></legend>	
			<table width="100%">
				<tr>
					<td>
						<span class="button">
							<input type="button" link="addStuff.php?id=<?php echo $id ?>" data-title="TAMBAH BARANG" data-width="650" data-height="400"  style="width:220px" value="TAMBAH BARANG" />
						</span>
					</td>
					<td align="right"><b>STATUS BARANG</b>		
						<select name="complateStuff" style="color:inherit; width:230px;">
							<option style="color:red"   value="0" <?php echo '0' == (isset($_REQUEST['complateStuff']) ? $_REQUEST['complateStuff'] : $dataHeader['status_complate_stuff']) ? 'selected' : '' ?>>Barang Belum Tersedia</option>
							<option style="color:green" value="1" <?php echo '1' == (isset($_REQUEST['complateStuff']) ? $_REQUEST['complateStuff'] : $dataHeader['status_complate_stuff']) ? 'selected' : '' ?>>Barang Sudah Terpenuhi</option>
						</select>
					</td>
				</tr>
			</table>		
			
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
								<td><?php echo $val['name'] ?><br /><small>(<?php echo $val['nickname'] ?>)</small></td>
								<td align="center">
									<span class="button">
										<a href="editStuff.php?id=<?php echo $id ?>&salesDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>"  data-title="EDIT JUMLAH BARANG" data-width="350" data-height="200"><?php echo $val['amount'] ?></a>
									</span>
								</td>
								<td align="center"><?php echo number_format($val['price'],0,'','.') ?></td>	
								<td align="center"><?php echo number_format($val['price'] * $val['amount'] ,0,'','.') ?></td>								
								<td align="center">	
									<span class="button">
										<input type="button" link="deleteStuff.php?id=<?php echo $id ?>&salesOrderDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>" data-title="KONFIRMASI HAPUS" data-width="320" data-height="100"  style="width:150px" value="HAPUS BARANG" />
									</span>
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
						</tr
						<tr>
							<td align="left" colspan="4"><b>TOTAL SETELAH DISKON</b></td>
							<td align="center"><b><span id="labelTotal"><?php echo number_format($total,0,'','.') ?></b></span></td>
							<td>&nbsp;</td>
						</tr>						
						<tr>
							<td align="left" colspan="4"><b>BIAYA KIRIM</b></td>
							<td align="center"><input onkeyup="updateTotal(<?php echo $total ?>)" name="costShipping" id="costShipping" style="text-align:center; font-size:15px;  fontheight:30px; width:100px" type="text" value="<?php echo isset($_POST['costShipping']) ? $_POST['costShipping'] : $dataHeader['shipping_cost'] ?>" size="5" /></td>
							<td>
								<input type="button" onclick="window.open('http://jet.co.id/tariff','','height=500,width=400,fullscreen=no')"  value="CEK BIAYA KIRIM J&T Express" />
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
		<input type="button" value="SIMPAN" onclick="frmSave()"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
	</form>
	
	<script type="text/javascript">
	
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
		
		calcDiscount(<?php echo $total ?>);
		
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
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
