<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>LAPORAN KINERJA SALES</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%" cellpadding="7">
				<tr>
					<td width="33%">
						STATUS PENJUALAN<br />
						<select name="statusOrder" style="width:100%">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] :'') ? 'selected' : '' ?>>Semua</option>							
							<option value="4" <?php echo '4' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Belum Bayar</option>
							<option value="0" <?php echo '0' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
							<option value="1" <?php echo '1' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pengemaasan</option>
							<option value="2" <?php echo '2' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Pengiriman</option>
							<option value="3" <?php echo '3' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Selesai</option>
						</select>				
					</td>
					<td width="33%">
						VALIDASI PEMBAYARAN<br />
						<select name="statusPayment" style="width:100%">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] :$statusPayment) ? 'selected' : '' ?>>Semua</option>							
							<option value="1" <?php echo '1' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Sudah di Validasi</option>
							<option value="0" <?php echo '0' == (isset($_REQUEST['statusPaymenet']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Belum di Validasi</option>
						</select>				
					</td>								
				</tr>
				<tr>
					<td align="left">
						DARI TANGGAL<br />
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:100%" />
					</td>
					<td  align="left">
						SAMPAI TANGGAL<br />
						<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:100%" />
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
			<p style="text-align:right">
				<input type="button" value="PRINT" onclick="window.open('print.php?statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>&strSalesId=<?php echo $strSalesId ?>')" />
				<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>&strSalesId=<?php echo $strSalesId ?>')" />
			</p>		
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th style="font-size:12px" align="center" width="5%">NO</th>
							<th style="font-size:12px" align="center" width="%">TANGGAL</th>						
							<th style="font-size:12px" align="center" width="%">JUMLAH TRANSAKSI</th>
							<th style="font-size:12px" align="center" width="%">JUMLAH NILAI TRANSAKSI</th>
							<th style="font-size:12px" align="center" width="%">KOMISI SALES</th>													
							<th style="font-size:12px" align="center" width="%"></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalTransaction = 0; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php $totalKomisi = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td align="center">
									<?php echo $val['date_order_format'] ?>
								</td>
								<td align="center"><?php echo $val['total_transaction'] ?> Transaksi</td>
								<td align="center"><?php echo number_format($val['total_nilai'],0,'','.') ?></td>							
								<td align="center"><?php echo number_format($val['total_fee_sales'],0,'','.') ?></td>							
								<td align="center">
									<span class="button"> 
										<a data-title="DETAIL" data-width="650" data-height="400" href="detail.php?salesId=<?php echo $val['sales_id'] ?>&statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&dateFrom=<?php echo urlencode($val['date_order_frm_2']) ?>&dateTo=<?php echo urlencode($val['date_order_frm_2']) ?>" />[ DETAIL ]</a>
									<span>		
								</td>	
							<?php $totalTransaction += $val['total_transaction']; ?>
							<?php $totalNilaiJual += $val['total_nilai'] ?>
							<?php $totalKomisi += $val['total_fee_sales']; ?>							
							<?php $i++; ?>
						<?php endwhile; ?>						
					<tbody>
					<tfoot>
						<tr>
							<th colspan="2" align="center">TOTAL</th>
							<th><?php echo $totalTransaction ?> TRANSAKSI</th>
							<th><?php echo number_format($totalNilaiJual,0,'.','.') ?></th>
							<th><?php echo number_format($totalKomisi,0,'.','.') ?></th>
							<th>&nbsp;</th>
						</tr> 
					</tfoot>	
				</table>			
			</div>
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
	});

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
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
