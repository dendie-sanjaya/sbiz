<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>REKAPITULASI AKTIVITAS PENJUALAN</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%">
				<tr>
					<td width="40%" align="left" valign="top">
						DARI TANGGAL<br />
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:100%" />
					</td>
					<td width="40%" align="left" valign="top">
						SAMPAI TANGGAL<br />
						<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:100%" />
					</td>
					<td valign="bottom" valign="top">
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
		<?php if(count($dataSum) < 1) : ?>
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
							<th style="font-size:12px" align="center" width="%">PENJUALAN</th>
							<th style="font-size:12px" align="center" width="%">VALIDASI PEMBAYARAN</th>
							<th style="font-size:12px" align="center" width="%">PENGEMASAN</th>
							<th style="font-size:12px" align="center" width="%">PENGIRIMAN</th>
							<th style="font-size:12px" align="center" width="%">HAPUS PENJUALAN</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php foreach($dataSum as $key => $val): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td align="center">
									<?php echo date('d M Y ',strtotime($key)) ?>		
								</td>
								<td align="center">
									<span class="button"> 
										<a data-title="DETAIL" data-width="650" data-height="400" href="detail.php?type=1&date=<?php echo urlencode($key) ?>" /><?php echo $val['order'] ?> Transaksi</a>
									<span>											
								</td>
								<td align="center">
									<span class="button"> 
										<a data-title="DETAIL" data-width="650" data-height="400" href="detail.php?type=2&date=<?php echo urlencode($key) ?>" /><?php echo $val['validationPayment'] ?> Transaksi</a>
									<span>											
								</td>
								<td align="center">
									<span class="button"> 
										<a data-title="DETAIL" data-width="650" data-height="400" href="detail.php?&type=3&date=<?php echo urlencode($key) ?>" /><?php echo $val['packing'] ?> Transaksi</a>
									<span>											
								</td>
								<td align="center">
									<span class="button"> 
										<a data-title="DETAIL" data-width="650" data-height="400" href="detail.php?type=4&date=<?php echo urlencode($key) ?>" /><?php echo $val['shipping'] ?> Transaksi</a>
									<span>											
								</td>
								<td align="center">
									<span class="button"> 
										<a data-title="DETAIL" data-width="650" data-height="400" href="detail.php?type=5&date=<?php echo urlencode($key) ?>" /><?php echo $val['deleteOrder'] ?> Transaksi</a>
									<span>											
								</td>
							<?php $i++; ?>
						<?php endforeach; ?>
					<tbody>
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
