<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<table width="100%">
		<tr>
			<td align="left"><h1>KOMISI RESELLER BELUM DI BAYAR</h1></td>
			<td align="right">
				<input type="button" value="KEMBALI" style="width:200px" onclick='window.location="../resellerWithdrawFee/index.php"' />
			</td>
		</tr>	
	</table>	

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%" cellpadding="7">
				<tr>
					<td align="left">
						<div style="margin-bottom: 10px;">DARI TANGGAL TRANSAKSI</div>
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:100%" />
					</td>
					<td  align="left">
						<div style="margin-bottom: 10px;">SAMPAI TANGGAL TRANSAKSI</div>
						<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:100%" />
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<div style="margin-bottom: 10px;">RESELLER</div>
						<select name="resellerId" style="width:100%;"  >
							<?php while($val = mysql_fetch_array($cmbReseller)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $resellerId == $val['id'] ? 'selected' : '' ?>><?php echo strtoupper($val['name']) ?></option>	
							<?php endwhile; ?>	
						</select>				
					</td>													
				</tr>	
				<tr>
					<td valign="bottom" colspan="3">
					   <input type="submit" value="FILTER" style="width: 100%" />
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

	<?php if(!isset($_REQUEST['dateFrom'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('filterData') ?></h3>
		</div>		
	<?php else: ?>	
		<?php if(mysql_num_rows($data) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
		<form action="addSave.php" method="post" id="transfetCommision">
			<!--
			<span class="button" style="margin: 10px 2px 10px -2px"> 
				<input data-title="PEMBAYARAN KOMISI" data-width="750" data-height="450" type="button" value="LAKUKAN PEMBAYARAN KOMISI"  style="width: 100%" />
			</span>	
			-->

			<div id="tbl">
				<table width="100%" id="tblReseller">
					<thead>			
						<tr>
							<th style="font-size:12px" align="center">
							</th>							
							<th style="font-size:12px" align="center" width="5%">NO</th>
							<th style="font-size:12px" align="center" width="%">TGL TRANSAKSI</th>							
							<th style="font-size:12px" align="center" width="%">NO SALES ORDER</th>
							<th style="font-size:12px" align="center" width="%">NAMA PEMBELI</th>
							<th style="font-size:12px" align="center" width="%" style="font-size: 11px">NILAI TRANSAKSI</th>
							<th style="font-size:12px" align="center" width="%">KOMISI RESELLER</th>													
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalTransaksi = 0; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php $totalKomisi = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr style="cursor:pointer">
								<td align="center">
									<input style="cursor:pointer" name="salesOrderId[]" class="chkSalesOrderId" type="checkbox" value="<?php echo $val['id']  ?>-<?php echo $val['no_order']  ?>-<?php echo $val['amount_fee_reseller'] ?>" />																			
								</td>
								<td align="center"><?php echo $i ?></td>
								<td align="center">
									<?php echo $val['date_order_frm'] ?>
								</td>
								<td align="center">
									<a href="../salesOrder/print.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a></td>									
								</td>
								<td align="center">
									<?php echo $val['name'] ?>
								</td>
								<td align="center"><?php echo number_format($val['total_nilai'],0,'','.') ?></td>							
								<td align="center"><?php echo number_format($val['amount_fee_reseller'],0,'','.') ?></td>
							</tr>																
							<?php $totalNilaiJual = $totalNilaiJual + $val['total_nilai'] ?>
							<?php $totalKomisi = $totalKomisi + $val['amount_fee_reseller'] ?>
							<?php $i++; ?>
						<?php endwhile; ?>
					</tbody>
					<tfoot>
						<th colspan="5">TOTAL</th>
						<th><?php echo number_format($totalNilaiJual,0,'','.') ?></th>
						<th><?php echo number_format($totalKomisi,0,'','.') ?></th>
					</tfoot>	
				</table>			
			</div>


			<fieldset style="margin-top: 15px">
			   <div id="modalPaymentx" style="margin:2px" style="display: block;">
				<input type="hidden" name="resellerId" value="<?php echo $resellerId ?>" > 
				<input type="hidden" name="dateFrom" id="dateFrom" value="<?php echo $_REQUEST['dateFrom'] ?>" />
				<input type="hidden" name="dateTo" id="dateFrom" value="<?php echo $_REQUEST['dateTo'] ?>"  />
				<table width="100%" >
					<tr>
						<td width="25%">NAMA RESELLER</td>
						<td><b><?php echo strtoupper($dataReseller['name']) ?></td>
					</tr>	
					<tr>
						<td>TANGGAL TRANSFER</td>
						<td><input type="text" name="resellerDateTransfer" id="resellerDateTransfer" value="" readonly style="width:100%" /></td>
					</tr>	
					<tr>
						<td>TUJUAN TRANSFER</td>
						<td>
							<select name="resellerBankTo" style="width:100%;"  >
								<?php while($val = mysql_fetch_array($cmbResellerBank)): ?>
									<option value="<?php echo $val['id'] ?>" ><?php echo strtoupper($val['bank_to']) ?></option>	
								<?php endwhile; ?>	
							</select>										
						</td>
					</tr>	
					<tr>
						<td valign="top">KETERANGAN</td>
						<td><textarea name="fromBank" style="width: 100%; height: 50px"></textarea></td>
					</tr>	
					<tr>
						<td>JUMLAH KOMISI</td>
						<td>
						  <input type="hidden" name="resellerTotalTransfer" id="resellerTotalTransfer" value="0">	
						  <b><div id="resellerTotalTransferLabel">0</div></b>
						 </td>
					</tr>	
					<tr>
						<td colspan="2"><input type="button" onclick="sendTransferCommision()" value="TRANSFER KOMISI" style="width: 100%" /></td>
					</tr>	
				</table>
			   </div>		
			</fieldset>   
		</form>	
		<?php endif; ?>
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


		$(function() {
				$( "#resellerDateTransfer" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-100y:c+nn',
					maxDate: '0d',
				});

				<?php $tmp = strlen(trim($_REQUEST['resellerDateTransfer'])) == 0 ?  '' : explode('/',$_REQUEST['resellerDateTransfer']) ?>
				$("#resellerDateTransfer" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});


	    $(".chkSalesOrderId").click(function () {
            //Fetch all row CheckBoxes in the Table.
            var chkRows = $("#tblReseller").find(".chkSalesOrderId");
            var total = 0;	
            //Execute loop over the CheckBoxes and if even one CheckBox
            //is unchecked then Uncheck the Header CheckBox.
            chkRows.each(function () {
                if ($(this).is(":checked")) {
                   var str = this.value.split('-');
                   total += parseFloat(str[2]);
                } else {
                    //this.attr("checked", "checked");
                }
            });

			$("#resellerTotalTransferLabel").html(total);
			$("#resellerTotalTransferLabel").simpleMoneyFormat();
			$("#resellerTotalTransfer").val(total);

            console.log(total);
        });		

	});

	$(function () {
		var iframe = $('#modalPayment');
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
		$(".button button").on("click", function (e) {
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

	function sendTransferCommision() {
		if(confirm('Anda yakin akan melakukan pembayaran ?')) {
		  $("#transfetCommision").submit();
		}  
	}
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
