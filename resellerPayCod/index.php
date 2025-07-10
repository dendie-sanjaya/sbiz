<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PEMBAYARAN COD KE RESELLER</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%" cellpadding="7">
				<tr>
					<td colspan="2">
						<div style="margin-bottom: 10px;">NO PEMBAYARAN KOMISI</div>
						<input placeholder=""name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%"/><br />
					</td>
				</tr>				
				<tr>
					<td align="left">
						<div style="margin-bottom: 10px;">DARI TANGGAL</div>
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:100%" />
					</td>
					<td  align="left">
						<div style="margin-bottom: 10px;">SAMPAI TANGGAL</div>
						<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:100%" />
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<div style="margin-bottom: 10px;">RESELLER</div>
						<select name="resellerId[]" style="width:100%; height: 94px" multiple  >
							<?php while($val = mysql_fetch_array($cmbReseller)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo in_array($val['id'],$resellerId) == true ? 'selected' : '' ?>><?php echo strtoupper($val['name']) ?></option>	
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

	<?php if(isset($_GET['msg'])) : ?>
		<?php if($_GET['msg'] == 'deleteSuccess'): ?>
		 	<div class="info">
				<h3>Pembayaran komisi nomor <?php echo $_GET['noPayment'] ?> berhasil dibatalkan</h3>
			</div>		
		<?php else: ?>	
		 	<div class="info">
				<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
			</div>		
		<?php endif; ?>	
	<?php endif ?>

	<p><input type="button" value="TAMBAH" onclick="window.location='../resellerPayCodTransaction/index.php'" /></p>

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
							<th style="font-size:12px" align="center" width="%">TGL TRANSFER</th>						
							<th style="font-size:12px" align="center" width="%">NO PEMBAYARAN</th>
							<th style="font-size:12px" align="center" width="%">RESELLER</th>
							<th style="font-size:12px" align="center" width="%">BANK TUJUAN</th>													
							<th style="font-size:12px" align="center" width="%">KETERANGAN</th>
							<th style="font-size:12px" align="center" width="%">TOTAL TRANsSFER</th>
							<th></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalTransaksi = 0; ?>
						<?php $totalNilaiJual = 0; ?>
						<?php $totalKomisi = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $val['date_transfer_frm'] ?></td>
								<td align="center"><?php echo $val['no_payment'] ?></td>
								<td align="center"><?php echo strtoupper($val['reseller_name']) ?></td>
								<td align="center" style="font-size: 10px"><?php echo $val['reseller_bank'] ?></td>
								<td align="center" style="font-size: 10px"><?php echo $val['from_bank'] ?></td>
								<td align="center"><?php echo number_format($val['total_withdraw'],0,'','.') ?></td>							
								<td align="center">
									<span class="button"> 
										<a data-title="DETAIL" data-width="650" data-height="400" href="detail.php?id=<?php echo $val['id'] ?>" />[ DETAIL ]</a>
									<span>
									<input type="button" name="delete" value="BATAL" onclick="cancelPayment(<?php echo $val['id'] ?>)" >		
								</td>	
							<?php $totalKomisi = $totalKomisi + $val['total_withdraw'] ?>
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<tfoot>
						<th colspan="5">TOTAL</th>
						<th><?php echo number_format($totalKomisi,0,'','.') ?></th>
						<th>&nbsp;</th>
					</tfoot>	
				</table>			
			</div>
		<?php endif; ?>
	<?php endif; ?>	

			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'statusClose='.$statusClose,'statusOrder='.$statusOrder,'statusPayment='.$statusPayment,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo']));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';a
				?>
			</p>			
	
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

		function cancelPayment(pId) {
			if(confirm('Anda yakin akan batalkan pembayaran ?')) {
				window.location = 'delete.php?id='+pId;
			}
		}
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
