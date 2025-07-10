<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<style>
	/* Ensure that the demo table scrolls */
	   div.dataTables_scrollBody {
	      scrollbar-width: thin;
	   }
	</style>

	<link rel="stylesheet" type="text/css" media="screen" href="../asset/vendor/datatable/jquery.dataTables.min.css" />
	<script type="text/javascript" src="../asset/vendor/datatable/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../asset/vendor/datatable/dataTables.fixedColumns.min.js"></script>	
	<script type="text/javascript" src="../asset/vendor/datatable/dataTables.buttons.min.js"></script>	
	<script type="text/javascript" src="../asset/vendor/datatable/jszip.min.js"></script>	
	<script type="text/javascript" src="../asset/vendor/datatable/pdfmake.min.js"></script>	
	<script type="text/javascript" src="../asset/vendor/datatable/vfs_fonts.js"></script>	
	<script type="text/javascript" src="../asset/vendor/datatable/buttons.html5.min.js"></script>	
	<script type="text/javascript" src="../asset/vendor/datatable/buttons.print.min.js"></script>	

	<h1>LAPORAN KONVERSI PENJUALAN TERHADAP IKLAN</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="post" id="formFilter">
			<input type="hidden" name="orderBy" id="orderBy" value="<?php echo $orderBy ?>">
			<table width="100%">
				<tr style="height: 60px">
					<!--
					<td valign="top">
						STATUS PENJUALAN<br style="margin-bottom: 10px" />
						<select name="statusOrder" style="width:100%">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] :'') ? 'selected' : '' ?>>Semua</option>							
							<option value="4" <?php echo '4' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Belum Bayar</option>
							<option value="0" <?php echo '0' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Sudah Bayar</option>
						</select>				
					</td>
					-->
					<td valign="top" colspan="2">
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
				  <!--	
				  <td colspan="2">
				  	KATEGORI BARANG<br style="margin-bottom: 10px" />
					<select name="categoryId[]" style="width:100%; height:100px"  multiple>
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option <?php echo in_array($val['id'],$categoryId) ? ' selected ' : '' ?> value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
				  </td>
				  -->	
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
		<?php if(count($listDateDay) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>		
	  		<div id="tbl">
				<table id="example" class="stripe row-border order-column" style="width:100%; margin-top:6px" border="1px">       
					<thead>			
						<tr>
							<th style="font-size:10px" align="center" width="5%" rowspan="3">NO</th>
							<th style="font-size:10px" align="center" width="%"  rowspan="3">HARI</th>						
							<th style="font-size:10px" align="center" width="%"  rowspan="3">TANGGAL</th>
							<th style="font-size:10px" align="center" width="%"  rowspan="3">PROMO</th>						
							<th style="font-size:10px" align="center" width="%"  colspan="<?php echo (count($dataSetMarketPlace) * 3) ?>">PLATFORM MARKET</th>
							<th style="font-size:10px" align="center" width="%"  rowspan="2" colspan="<?php echo count($dataSetAds) ?>">PLATFORM IKLAN</th>
							<th style="font-size:8px"  align="center" width="%"  rowspan="3">TOTAL OMSET</th>
							<th style="font-size:8px"  align="center" width="%"  rowspan="3">TOTAL IKLAN</th>
							<th style="font-size:8px"  align="center" width="%"  rowspan="3">OMSET / IKLAN</th>
						</tr>	
						<tr>
						   <?php foreach($dataSetMarketPlace as $key => $val): ?>
						   	  <?php $marketPlaceLabel = explode('~',$key) ?>
						   	 <th style="font-size: 9px" colspan="3"><?php echo $marketPlaceLabel[1] ?></th>
						   <?php endforeach; ?>	
						</tr>	
						<tr>
						   <?php foreach($dataSetMarketPlace as $key => $val): ?>
							  <th style="font-size: 9px">OMSET</th>
							  <th style="font-size: 9px">QTY</th>
							  <th style="font-size: 9px">TRX</th>
						   <?php endforeach; ?>	
						   <?php foreach($dataSetAds as $key => $val): ?>
						   	  <?php $adsLabel = explode('~',$key) ?>
						   	  <th style="font-size: 6px"><?php echo $adsLabel[1] ?></th>
						   <?php endforeach; ?>						   
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?> 
						<?php $grand_total_per_marketplace = [] ?>
						<?php $grand_total_per_platform_ads = [] ?>
						<?php $grand_total_omset = 0 ?>
						<?php $grand_total_ads = 0 ?>
						<?php $total_ads = 0 ?>
						<?php foreach($listDateDay as $vallListDateDay): ?>
							<?php $total_omset = 0 ?>
							<?php $total_ads = 0 ?>
							<tr> 
								<td style="text-align: center; font-size: 10px; background-color: #E7E9EB"><?php echo $vallListDateDay[0] ?></td>
								<td style="text-align: center;  font-size: 10px; background-color: #E7E9EB "><?php echo $vallListDateDay[1] ?></td>
								<td style="text-align: center;  font-size: 10px;  background-color: #E7E9EB"><?php echo $vallListDateDay[2] ?></td>
								<td style="text-align: left; font-size: 9px">
									<?php $dtPromo = !empty($dataSetPromo[$vallListDateDay[2]]) ? $dataSetPromo[$vallListDateDay[2]] : '-'  ?>
									<?php echo $dtPromo ?>									
								</td>
								<?php foreach($dataSetMarketPlace as $key => $val): ?>
									<td style="font-size: 9px; text-align: center;">
										<?php if(!empty($val[$vallListDateDay[2]]['total_revenue'])): ?>
										 	<?php $tmp_total_revenue = $val[$vallListDateDay[2]]['total_revenue'] ?>
										 	<?php echo number_format($tmp_total_revenue,0,",",".") ?>
										 	<?php $total_omset = ($total_omset + $tmp_total_revenue) ?>
										 	<?php $grand_total_per_marketplace[$key]['total_revenue'] = ($grand_total_per_marketplace[$key]['total_revenue'] + $tmp_total_revenue); ?>
										<?php else: ?>
											0		
										 	<?php $grand_total_per_marketplace[$key]['total_revenue'] = ($grand_total_per_marketplace[$key]['total_revenue'] + 0); ?>
										<?php endif; ?> 	
									</td>
									<td style="font-size: 9px; text-align: center;">
										<?php $tmp_total_qty = !empty($val[$vallListDateDay[2]]['total_qyt']) ? number_format($val[$vallListDateDay[2]]['total_qyt'],0,",",".") : 0 ?>
										<?php echo $tmp_total_qty ?>																					
										<?php $grand_total_per_marketplace[$key]['total_qty'] = ($grand_total_per_marketplace[$key]['total_qty'] +  $tmp_total_qty); ?>
									</td>
									<td style="font-size: 9px; text-align: center;">
										<?php $tmp_total_trx =  !empty($val[$vallListDateDay[2]]['total_trx']) ? number_format($val[$vallListDateDay[2]]['total_trx'],0,",",".") : 0 ?>											
										<?php echo $tmp_total_trx ?>																					
										<?php $grand_total_per_marketplace[$key]['total_trx'] = ($grand_total_per_marketplace[$key]['total_trx'] +  $tmp_total_trx); ?>
									</td>
								<?php endforeach; ?>	
								<?php $grand_total_omset = ($grand_total_omset + $total_omset) ?>

								<?php foreach($dataSetAds as $key => $val): ?>
									<td style="font-size: 9px; text-align: center;">
										<?php if(!empty($val[$vallListDateDay[2]]['total_ads'])): ?>
										 	<?php $tmp_total_ads = $val[$vallListDateDay[2]]['total_ads'] ?>
										 	<?php echo number_format($tmp_total_ads,0,",",".") ?>
										 	<?php $total_ads = ($total_ads + $tmp_total_ads) ?>
										 	<?php $grand_total_per_platform_ads[$key] = $total_ads ?>
										<?php else: ?>
											0
											<?php $grand_total_per_platform_ads[$key] = 0 ?>		
										<?php endif; ?> 	
									</td>
								<?php endforeach; ?>
								<?php $grand_total_ads = ($grand_total_ads + $total_ads) ?>

								<td style="font-size: 9px; text-align: center; font-weight: bold; background-color: #E7E9EB"><?php echo number_format($total_omset,0,",",".") ?></td>	
								<td style="font-size: 9px; text-align: center; font-weight: bold; background-color: #E7E9EB"><?php echo number_format($total_ads,0,",",".") ?></td>	
								<td style="font-size: 9px; text-align: center; font-weight: bold; background-color: #E7E9EB">
									<?php $tmp_total_revenue = $tmp_total_revenue > 0 ? $tmp_total_revenue : 1 ?>
									<?php echo round((($total_ads/$tmp_total_revenue) * 100),2) ?>%
								</td>	
							</tr>	
						<?php endforeach; ?>
					</tbody>
					<tfoot>		
						<tr>
							<th colspan="4" align="left" style="text-align:left; font-size: 9px">GRAND TOTAL</th>
							<?php foreach($grand_total_per_marketplace as $val): ?>
								<th style="font-size: 9px"><?php echo number_format($val['total_revenue'],0,",",".") ?></th>
								<th style="font-size: 9px"><?php echo $val['total_qty'] ?></th>
								<th style="font-size: 9px"><?php echo $val['total_trx'] ?></th>
							<?php endforeach ?>	
							<?php foreach($grand_total_per_platform_ads as $val): ?>
								<th style="font-size: 9px"><?php echo number_format($val,0,",",".") ?></th>
							<?php endforeach; ?>	
							<th style="font-size: 9px; text-align: center; font-weight: bold">
								<?php echo number_format($grand_total_omset,0,",",".") ?>
							</th>		
							<th style="font-size: 9px; text-align: center; font-weight: bold">
								<?php echo number_format($grand_total_ads,0,",",".") ?>
							</th>		
							<th></th>			
						</tr>	
					</tbody>	
	        	</table>  
	        </div>
			<div style="font-size: 11px; margin: 3px 0px 5px 0px; font-weight: bold; text-align: right; width: 100%">Catatan: Omset adalah:  Harga Jual - Diskon </div>	        
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

	$(document).ready(function() {
	    var table = $('#example').DataTable( {
	    	ordering: 		false,
	        scrollY:        "400px",
	        scrollX:        true,
	        scrollCollapse: true,
	        paging:         false,
	        fixedColumns:   {
	            left: 3,
	            right: 3
	        },
	        dom: 'Bfrtip',
	        buttons: ['excel','print']	        
	    } );
	} );

	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
