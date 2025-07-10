<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>LAPORAN PENJUALAN BARANG</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="post" id="formFilter">
			<input type="hidden" name="orderBy" id="orderBy" value="<?php echo $orderBy ?>">
			<table width="100%">
				<tr style="height: 60px">
					<td valign="top">
						STATUS PENJUALAN<br style="margin-bottom: 10px" />
						<select name="statusOrder" style="width:100%">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] :'') ? 'selected' : '' ?>>Semua</option>							
							<option value="4" <?php echo '4' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Belum Bayar</option>
							<option value="0" <?php echo '0' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Sudah Bayar</option>
						</select>				
					</td>
					<td valign="top">
						VALIDASI PEMBAYARAN<br style="margin-bottom: 10px" />
						<select name="statusPayment" style="width:100%">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] :$statusPayment) ? 'selected' : '' ?>>Semua</option>							
							<option value="1" <?php echo '1' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Sudah di Validasi</option>
							<option value="0" <?php echo '0' == (isset($_REQUEST['statusPaymenet']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Belum di Validasi</option>
						</select>				
					</td>								
				</tr>	
				<tr style="height: 60px">
					<td width="40%" align="left" valign="top">
						DARI TANGGAL<br style="margin-bottom: 10px" />
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:100%" />
					</td>
					<td width="40%" align="left" valign="top">
						SAMPAI TANGGAL<br style="margin-bottom: 10px" />
						<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:100%" />
					</td>
				</tr>
				<tr>
				  <td>
				  	KATEGORI BARANG<br style="margin-bottom: 10px" />
					<select name="categoryId[]" style="width:100%; height:100px"  multiple>
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option <?php echo in_array($val['id'],$categoryId) ? ' selected ' : '' ?> value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
				  </td>	
				  <td>
					SEMUA MEMBER<br />
					
					<select name="salesId[]" style="width:100%; height: 94px" multiple  >
						<?php while($val = mysql_fetch_array($cmbSales)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo in_array($val['id'],$salesId) == true ? 'selected' : '' ?>><?php echo $val['name'] ?></option>	
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
			<table width="100%">
				<tr>
					<td align="left">
						<select name="orderBy" onchange="orderBy(this.value)">
						   <optgroup label="URUTKAN BERDASARKAN">
							   <option value="0" <?php echo $orderBy == 0 ? 'selected': '' ?>>JUMLAH BARANG TERJUAL</option>	
							   <option value="1" <?php echo $orderBy == 1 ? 'selected': '' ?>>JUMLAH NILAI TERJUAL</option>	
							   <option value="2" <?php echo $orderBy == 2 ? 'selected': '' ?>>NAMA BARANG</option>							   	
						   </optgroup>	
						</select>							
					</td>
					<td align="right">
						<input type="button" value="PRINT" onclick="window.open('print.php?orderBy=<?php echo $orderBy ?>&categoryIdChoose=<?php echo $categoryIdChoose ?>&strSalesId=<?php echo $strSalesId ?>&isReseller=<?php echo $_REQUEST['isReseller'] ?>&tipeOrder=<?php echo $_REQUEST['tipeOrder'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
						<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?orderBy=<?php echo $orderBy ?>&categoryIdChoose=<?php echo $categoryIdChoose ?>&strSalesId=<?php echo $strSalesId ?>&isReseller=<?php echo $_REQUEST['isReseller'] ?>&tipeOrder=<?php echo $_REQUEST['tipeOrder'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />						
					</td>
				</tr>	
			</table>
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th style="font-size:12px" align="center" width="5%">NO</th>
							<th style="font-size:12px" align="center" width="%">NAMA BARANG</th>						
							<th style="font-size:12px" align="center" width="%">JML BARANG TERJUAL</th>
							<th style="font-size:12px" align="center" width="%">JML HARGA DASAR TERJUAL</th>						
							<th style="font-size:12px" align="center" width="%">JML NILAI TERJUAL</th>						
							<th style="font-size:12px" align="center" width="%"></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php $totalHargaDasarJual = 0 ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td align="left" style="font-size: 12px">
									<?php echo $val['stuff_name'] ?>
									<?php if(strlen($strSalesId) > 0): ?>									
										<br />
										<span style="font-size:10px"><?php echo $val['nickname'] ?></span>
										<br />
										<span style="font-size:10px">[Sales : <?php echo $val['sales_name'] ?>]</span>
									<?php endif; ?>	
								</td>
								<td align="center"><?php echo $val['amount_total'] ?> <?php echo $val['satuan'] ?></td>
								<td align="center"><?php echo number_format($val['price_total_basic'],0,'','.') ?></td>					
								<td align="center"><?php echo number_format($val['price_total'],0,'','.') ?></td>							
								<td align="center">
									<span class="button"> 
										<a style="font-size: 11px" data-title="DETAIL" data-width="650" data-height="400" href="detail.php?stuffId=<?php echo $val['stuff_id'] ?>&statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&isReseller=<?php echo $_REQUEST['isReseller'] ?>&tipeOrder=<?php echo $_REQUEST['tipeOrder'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>" />[&nbsp;DETAIL&nbsp;]</a>
									<span>		
								</td>	
							<?php $totalNilaiJual = $totalNilaiJual + $val['price_total'] ?>
							<?php $totalHargaDasarJual = $totalHargaDasarJual + $val['price_total_basic'] ?>
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<tr>
						<th colspan="3" align="left" style="text-align:left">GRAND TOTAL</th>
						<th><?php echo number_format($totalHargaDasarJual,0,'','.') ?></th>
						<th><?php echo number_format($totalNilaiJual,0,'','.') ?></th>
						<th></th>
					</tr>	
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

	function orderBy(p) {
	   $("#orderBy" ).val(p);
	   $("#formFilter" ).submit();		
	}
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
