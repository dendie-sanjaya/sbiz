<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>RETUR PENJUALAN</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td align="left" valign="top">
								DARI TANGGAL
							</td>
							<td>	
								<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:90%" />
							</td>
							<td  align="left" valign="top">							
								SAMPAI TANGGAL
							</td>
							<td>	
								<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:100%" />
							</td>						
						</tr>							
						<tr>
							<td width="20%">KATA KUNCI</td>
							<td colspan="3" >
								<input placeholder=""name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%"/><br />
								<small style="font-size:8px"><i>NO SALES ORDER / NO RETUR PENJUALAN</i></small>								
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<input type="submit" value="FILTER" style="width: 100%"  />							
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

	<p><input type="button" value="TAMBAH" onclick="window.location='add.php'" /></p>
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
						<th align="center" width="20%">TANGGAL RETUR</th>
						<th align="center" width="%">NO RETUR</th>						
						<th align="center" width="%">NO SALES ORDER</th>
						<th align="center" width="%">JUMLAH</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i=1 + $_REQUEST['SplitRecord']; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="center"><?php echo $val['date_retur_frm'] ?></td>
							<td align="center"><?php echo $val['no_retur'] ?></td>
							<td align="center">
								<a href="../salesOrder/print.php?id=<?php echo $val['so_id'] ?>" target="_blank"><?php echo $val['no_so'] ?></a><br />
								<small>sales: <?php echo $val['sales_name'] ?></small>	
							</td>
							<td align="center"><?php echo number_format($val['amount_sale'],0,'','.')?></td>							
							<td align="center">
							<input type="button" value="BATALKAN" onclick="confirm('Anda yakin akan membatalkan retur penjualan ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'statusClose='.$statusClose,'statusOrder='.$statusOrder,'statusPayment='.$statusPayment,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo']));
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
		});
		</script>		
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
