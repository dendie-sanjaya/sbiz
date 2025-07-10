<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>PELANGGAN</h1></center>
	<fieldset style="border:2px solid black">
		<legend style="font-size:14pt"><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td style="font-size:12pt" valign="top"  width="20%">KATA KUNCI</td>
				<td style="font-size:12pt" valign="top"  width="25%"> : <?php echo $keyword ?></td>
				<td style="font-size:12pt" valign="top"  width="20%">KATEGORI PELANGGAN</td>
				<td style="font-size:10pt" valign="top">: 
				   <?php while($val = mysql_fetch_array($dataClient)): ?>
				   		<?php echo $val['name'] ?> <br />&nbsp;
				   <?php endwhile; ?>	
				</td>
			</tr>
			<tr>
				<td style="font-size:12pt" width="20%">DARI TGL KONTAK </td>
				<td style="font-size:12pt" width="25%"> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td style="font-size:12pt" width="20%">SAMPAI TGL KONTAK</td>
				<td style="font-size:12pt">: <?php echo date("j M Y", strtotime($dateTo)) ?></td>
			</tr>
		</table>
	</fieldset>
	<p></p>
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
			<div id="tbl">
				<table width="100%" style="font-size:12pt; border:1px solid black" cellpadding="0" cellspacing="0">
					<thead>			
						<tr>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="5%">NO</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">NAMA</th>						
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">TANGGAL</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">HANDPHONE</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">KATEGORI</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">PEMBELIAN</th>						
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalBiayaKirim = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr style="height: 0px">
								<td align="center" style="border:1px solid black"><?php echo $i ?></td>
								<td align="left"   style="padding:8px; border:1px solid black"><?php echo $val['name'] ?></td>
								<td align="center" style="border:1px solid black"><?php echo $val['date_contact'] ?></td>
								<td align="center" style="border:1px solid black"><?php echo $val['country_code'] ?><?php echo str_replace('-','',$val['phone_number']) ?></td>
								<td align="center" style="border:1px solid black">
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
										<?php echo $valCategory['name'] ?>,
									<?php endwhile; ?>											
								</td>	
								<td align="center" style="border:1px solid black">
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
								</td>	
							</tr>						
						<?php $i++ ?>			
						<?php endwhile; ?>
					<tbody>
				</table>			
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
