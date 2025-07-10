<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<h1>REKAPITULASI KLIEN</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%">
				<tr>
					<td width="20%">DARI TANGGAL </td>
					<td width="25%">
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly />
					</td>
					<td width="20%">KATEGORI</td>
					<td>
						<select name="categoryId" style="width:180px">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
				</tr>
				<tr>
					<td>SAMPAI TANGGAL</td>
					<td>
						<input type="text" name="dateTo" id="dateTo" value="" readonly />
					</td>
					<td></td>
					<td>
						<input type="submit" value="FILTER" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<p></p>
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
				<input type="button" value="PRINT" onclick="window.open('print.php?categoryId=<?php echo $_REQUEST['categoryId'] ?>&clientId=<?php echo $_REQUEST['clientId'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
				<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?categoryId=<?php echo $_REQUEST['categoryId'] ?>&clientId=<?php echo $_REQUEST['clientId'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
			</p>	
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="30%">NAMA KLIEN</th>
							<th align="center" width="15%">TIPE</th>
							<th align="center" width="20%">TOTAL</th>	
						</tr>	
					</thead>
					<tbody>
						<?php $priceTotal = 0; ?>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center" valign="top"><?php echo $i ?></td>
								<td valign="top" align="left">
									<?php echo $val['client_name'] ?>
								</td>
								<td valign="top" align="center">
									BRG. KELUAR
								</td>
								<td valign="top" align="center">
									<?php echo number_format(abs($val['total']),0,'','.') ?>
									<?php $priceTotal = $priceTotal +  abs($val['total']); ?>
								</td>
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
							<tr>
								<td align="center" valign="top" colspan="3"><b>TOTAL</b></td>
								<td valign="top" align="center">
									<b><?php echo number_format($priceTotal,0,'','.') ?></b>
								</td>
							</tr>	
					</tbody>
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

	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
