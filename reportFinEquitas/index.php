<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>LAPORAN PERUBAHAN MODAL / EKUITAS</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%">
				<tr>
					<td width="20%" align="left">
						DARI TANGGAL<br />
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:250px" />
					</td>
					<td width="20%" align="left">
						SAMPAI TANGGAL<br />
						<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:250px" />
					</td>
					<td valign="bottom">
						<input type="submit" value="FILTER" />
					</td>					
				</tr>
			</table>
		</form>
	</fieldset>

	<br />
	<table width="100%">
		<tr>
			<td><input type="button" value="TAMBAH ITEM" onclick="window.location='add.php?dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>'" /></td>
			<td align="right">
				<?php if(mysql_num_rows($data) > 0) : ?>
					<input type="button" value="PRINT" onclick="window.open('print.php?dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
					<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />				
				<?php endif; ?>
			</td>
		</tr>
	</table>
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
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th style="font-size:12px" align="center" width="5%">NO</th>
							<th style="font-size:12px" align="center" width="17%">TANGGAL</th>						
							<th style="font-size:12px" align="center" width="30%">ITEM</th>						
							<th style="font-size:12px" align="center" width="15%">KREDIT</th>
							<th style="font-size:12px" align="center" width="15%">DEBET</th>
							<th style="font-size:12px" align="center" width="%"></th>						
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalDanaMasuk = 0; ?>
						<?php $totalDanaKeluar = 0; ?>	
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td align="center" style="text-align:left; padding-left:5px">
									<?php echo $val['date_transaction_frm'] ?>
								</td>
								<td align="left">
									<?php echo $val['name'] ?>
								</td>							
								<td align="center">
									<?php if($val['tipe'] == '1'): ?>
										<?php echo number_format($val['nominal'],0,'','.')?>
									<?php endif; ?>
								</td>
								<td align="center">
									<?php if($val['tipe'] == '0'): ?>
										<?php echo number_format($val['nominal'],0,'','.')?>
									<?php endif; ?>
								</td>
								<td align="center">
									<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>'" />
									<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>' : false" />								
								</td>							
							</tr>	
							<?php $i++; ?>		
							<?php if($val['tipe'] == '1'): ?>
								<?php $totalDanaMasuk = $totalDanaMasuk + $val['nominal']; ?>
							<?php endif; ?>		

							<?php if($val['tipe'] == '0'): ?>
								<?php $totalDanaKeluar = $totalDanaKeluar + $val['nominal']; ?>
							<?php endif; ?>							
						<?php endwhile; ?>
						<tr>
							<th align="center" colspan="3">TOTAL</th>
							<th><?php echo number_format($totalDanaMasuk,0,'','.')?></th>
							<th><?php echo number_format($totalDanaKeluar,0,'','.')?></th>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<th align="center" colspan="3">MODAL AKHIR</th>
							<th colspan="2" align="center"><?php echo number_format($totalDanaMasuk - $totalDanaKeluar,0,'','.')?></th>
							<th>&nbsp;</th>
						</tr>						
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
