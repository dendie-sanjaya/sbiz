<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>FOLLOW UP PENJUALAN</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" id="frm" >					
					<table width="100%">
						<tr>
							<td width="25%">KATA KUNCI</td>
							<td>
								<input placeholder=""name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
								<small style="font-size:8px"><i>NAMA PEMBELI / TELEPON</i></small>
							</td>
							<td width="">STATUS FOLLOWUP</td>
							<td width=>
								<select name="statusFollowup" style="width:180px">
									<option value="x" <?php echo 'x' == (isset($_REQUEST['statusFollowup']) ? $_REQUEST['statusFollowup'] :'') ? 'selected' : '' ?>>Semua</option>							
									<option value="1" <?php echo '1' == (isset($_REQUEST['statusFollowup']) ? $_REQUEST['statusFollowup'] : $statusFollowup) ? 'selected' : '' ?>>Sudah Followup</option>
									<option value="0" <?php echo '2' == (isset($_REQUEST['statusFollowup']) ? $_REQUEST['statusFollowup'] : $statusFollowup) ? 'selected' : '' ?>>Belum Followup</option>
								</select>				
							</td>

						</tr>
						<tr>
							<td>DARI TANGGAL</td>
							<td>
								<input type="text" name="dateFrom" id="dateFrom" value="" readonly  style="width:180px"  />
							</td>
							<td>SAMPAI TANGGAL</td>							
							<td>
								<input type="text" name="dateTo" id="dateTo" value="" readonly  style="width:180px"  />
							</td>							
						</tr>	
						<tr>
							<td colspan="4"><input type="submit" value="FILTER" style="width: 100%; margin-top:20px" /></td>
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

	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="%">TGL PEMESANAN</th>
						<th align="center" width="%">NAMA PEMBELI</th>
						<th align="center" width="%">BARANG</th>
						<th align="center" width="13%">JUMLAH</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i= ((1 * $record) + 1); ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="center">
								<div style="font-size: 12px"><?php echo $val['date_input_frm_2'] ?></div>
								<small style="font-size: 11px">Sales : <?php echo $val['sales_name'] ?></small>								
							</td>
							<td align="center">
								<div><?php echo $val['name'] ?></div>
								<a href="whatsapp://send?phone=<?php echo str_replace(array('-',''), array('',''), $val['country_code'].$val['phone']) ?>">
									<button style="font-weight: bold">Follow Up <?php echo $val['country_code'] ?><?php echo $val['phone'] ?></button>
								</a>	
							</td>
							<td align="center">
								<div style="font-size: 13px">
									<?php echo str_replace(array('(','&'),array('<br />(','<br />&'),$val['stuff_name'],$a) ?>
								</div>
								<small style="font-size: 11px">(Order Form Dari : <?php echo $val['from_ip'] ?>)</small>
							</td>
							<td align="center">
								<?php if($val['is_followup'] == '1'): ?>
									<?php echo $val['qty'] ?> Pcs
								<?php else : ?>	
									<span class="button">
										<a href="editStuff.php?id=<?php echo $val['id_detail'] ?>&qty=<?php echo $val['qty'] ?>"  data-title="EDIT JUMLAH BARANG" data-width="350" data-height="200"><?php echo $val['qty'] ?> Pcs</a>
									</span>								
									<div style="font-size: 10px; <?php echo $val['sisa_stock'] < $val['qty'] ? 'color:red' : '';  ?> ">Sisa Stok : <?php echo $val['sisa_stock'] ?> Pcs
								<?php endif; ?>	
							</td>							
							<td align="center">
								<?php if($val['is_followup'] == '1'): ?>
									<b style="color:green">[CLOSE] </b> 										
								<?php else: ?>
									<input type="button" value="CLOSING" style="width: 100px" onclick="confirm('Anda yakin akan melakukan Closing kemudian di forward ke Sales Order / Penjualan ?') ? window.location='addSave.php?id=<?php echo $val['id'] ?>' : false"  <?php echo $val['sisa_stock'] < $val['qty'] ? 'disabled' : '';  ?>/>
									<input type="button" value="HAPUS" style="width: 100px" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
								<?php endif; ?>									
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'statusFollowup='.$statusFollowup,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo']));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';a
				?>
			</p>			
		</div>
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
	});
	</script>		
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
