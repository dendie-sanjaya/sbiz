<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>PELANGGAN</h1>

		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td width="20%" valign="top">KATA KUNCI</td>
							<td valign="top">
								<input placeholder=""name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
								<small style="font-size:8px"><i>NAMA  / NO HANDPHONE</i></small>
							</td>
							<td width="" valign="top">KATEGORI PELANGGAN</td>
							<td width="" valign="top">
								<select name="clientId[]" style="width:250px; height: 80px" multiple>
									<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
										<option value="<?php echo $valClient['id'] ?>" <?php echo in_array($valClient['id'],$clientId) == true ? 'selected' : '' ?>><?php echo $valClient['name'] ?></option>	
									<?php endwhile; ?>
								</select>				
							</td>						
						</tr>
						<tr>
							<td align="left" valign="top" >
								DARI TANGGAL
							</td>		
							<td align="left" valign="top">
								<input type="text" name="dateFrom" id="dateFrom" value="" readonly style="width:180px" />
							</td>
							<td align="left" valign="top">
								SAMPAI TANGGAL
							</td>		
							<td align="left" valign="top">
								<input type="text" name="dateTo" id="dateTo" value="" readonly style="width:180px" />
							</td>
						</tr>
						<tr>
							<td colspan="6"><input type="submit" value="FILTER" style="width: 100%; margin-top:20px" /></td>
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

    <div style="margin: 10px 0px 15px 0px">
	    <div><input type="button" value="TAMBAH" onclick="window.location='add.php'" /></div>

		<?php if(mysql_num_rows($data) > 0) : ?>
			<div style="text-align:right">
				<input type="button" value="PRINT" onclick="window.open('print.php?print=1&keyword=<?php echo $keyword ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
				<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?print=1&keyword=<?php echo $keyword ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
			</div>					   
		<?php endif; ?>
	</div>   
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
						<th align="center" width="23%">NAMA</th>
						<th align="center" width="17%">HANDPHONE</th>						
						<th align="center" width="22%">KATEGORI</th>		
						<th align="center" width="15%">PEMBELIAN</th>						
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = (1 + $record); ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td>
								<?php echo $val['name'] ?><br />
								<small style="font-size: 10">(Sales : <?php echo $val['sales_name'] ?>)</small>
							</td>
							<td align="center">
								<?php echo $val['country_code'] ?><?php echo $val['phone_number'] ?><br />
								<small style="font-size: 10">(Tgl : <?php echo $val['date_contact'] ?>)</small>										
							</td>							
							<td align="center">
								<?php 
									$customerId = $val['id'];

									$query = "select cg.client_id,c.name
										from customer_group as cg
										inner join client as c
										  on c.id = cg.client_id
										where cg.customer_id = '$customerId'
										order by c.name";
									
									$tmp = mysql_query($query) or die (mysql_error());
								?>		
								<?php while($valCategory = mysql_fetch_array($tmp)): ?>
									<small style="font-size: 10px"><?php echo $valCategory['name'] ?>,</small>					
								<?php endwhile; ?>		
							</td>
							<td align="center">
								<?php 
								    $fullPhoneNumber = $val['country_code'].$val['phone_number']; 
									$query =  "select count(so.id) as total_pembelian from sales_order as so 
									     where replace(replace(so.phone,'-',''),'+','') = '$fullPhoneNumber'
									     and is_delete = '0'
									     and status_payment = '1'";
									$tmpPhoneNumber = mysql_query($query) or die (mysql_error());
									$rstPhoneNumber = mysql_fetch_array($tmpPhoneNumber);
			 					?>								

								<?php echo $rstPhoneNumber['total_pembelian'] ?> Transaksi <br />
								<small style="font-size: 10">(Kota : <?php echo $val['city'] ?>)</small>								
							</td>
							<td align="center">
								<?php if(in_array($_SESSION['loginPosition'], array('1'))): ?>
									<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
									<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />
								<?php else: ?>
									<?php if($val['sales_id'] == $loginMemberId): ?>
										<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
										<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />																	
									<?php else: ?>		
										<input disabled type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
										<input disabled type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />								
									<?php endif; ?>											
								<?php endif ?>	
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>

			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo']));
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
				<?php $tmp = strlen(trim($_REQUEST['dateFrom'])) == 0 ?  explode('/',$dateFrom) : explode('/',$_REQUEST['dateFrom']) ?>
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

				<?php $tmp = strlen(trim($_REQUEST['dateTo'])) == 0 ?  explode('/',$dateTo) : explode('/',$_REQUEST['dateTo']) ?>
				$("#dateTo" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});
	});
	</script>		
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
