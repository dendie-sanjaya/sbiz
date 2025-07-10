<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>MUTASI REKENING BANK</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" id="frmFilter" >	
				   <input type="hidden" name="orderBy" id="orderBy" value="<?php echo $orderBy ?>">				
					<table width="100%">
						<tr>
							<td width="100%" valign="middle" colspan="2">KATA KUNCI &nbsp;&nbsp;&nbsp;&nbsp;
								<input placeholder="NOMOR REKENING / JUMLAH UANG" name="keyword" type="text" title="abc" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%" />
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
						<tr  >
						  <td width="50%"  colspan="2">
						  	KATERANGAN PEMBAYARAN <sup style="font-size: 10px">Hanya Menampilan Yang Ada Nomor Rekening</sup><br style="margin-bottom: 10px; margin-top:30px" />
							<select name="paymentId[]" style="width:100%; height:200px"  multiple>
								<?php while($val = mysql_fetch_array($cmbFoundSource)): ?>
									<option <?php echo in_array($val['id'],$paymentId) ? ' selected ' : '' ?> value="<?php echo $val['account_number'] ?>" <?php echo $val['id'] == (isset($_REQUEST['paymentId']) ? $_REQUEST['paymentId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?> [No Rek: <?php echo empty($val['account_number']) ? 'Tidak Ada Nomor' : $val['account_number']; ?>]</option>
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
		
	<?php if(isset($_GET['msgType'])) : ?>
	 	<div class="error">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>	
	<?php elseif(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif; ?>
		
	
	<div class="warning" style="min-height:20px;">
		Data dibawah ini Mutasi Bank yang terintegrasi dengan system <a href="http://moota.co" target="_blank">moota.co</a>
	</div>	

	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
	    <!--
		<table width="100%">
			<tr>
				<td width="30%">	
				   &nbsp;		
				</td>
				<td align="right">
					<b>Urutkan Beradasarkan</b> &nbsp; 
					<select name="oderBy" style="width:150px;" onchange="orderBy(this.value)">
						<option value="expedition_name" <?php echo $orderBy == 'expedition_name' ? 'selected' : '' ?> >EKSEDISI</option>
						<option value="no_order" <?php echo $orderBy == 'no_order' ? 'selected' : '' ?>>NO SALES ORDER</option>
					</select>												
				</td>	
			</tr>
		</table>
		-->
		<div id="tbl">
			<table width="100%">
				<thead>			
					<tr>
						<th align="center" width="20%" style="font-size: 12px">TGL MUTASI</th>
						<th align="center" width="%">MUTASI ID</th>						
						<th align="center" width="20%">NO REKENING</th>
						<th align="center" width="">TIPE</th>
						<th align="center" width="">JUMLAH</th>
						<!--
						<th align="center" width="">SALDO</th>
						-->
						<th align="center" width="25%">KETERANGAN</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $val['date'] ?></td>
							<td align="center"><?php echo $val['mutation_id'] ?></td>
							<td align="center"><sup><?php echo $val['bank_name'] ?></sup>&nbsp;<br /><?php echo $val['account_number'] ?></td>							
							<td align="center"><?php echo $val['type'] ?></td>							
							<td align="center"><?php echo number_format($val['amount'],0,0,'.') ?></td>	
							<!--
							<td align="center"><?php echo number_format($val['balance'],0,0,'.') ?></td>
							-->
							<td align="center"><?php echo $val['description'] ?></td>							
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<!--
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'isReseller='.$isReseller,'tipeOrder='.$tipeOrder,'statusOrder='.$statusOrder,'statusPayment='.$statusPayment));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>
			-->			
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
