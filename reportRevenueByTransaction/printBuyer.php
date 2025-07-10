<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN DATA PEMBELI</h1></center>
	<fieldset style="border:2px solid black">
		<legend style="font-size:14pt"><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td style="font-size:12pt" width="20%">DARI TANGGAL </td>
				<td style="font-size:12pt" width="25%"> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td style="font-size:12pt"width="20%">STATUS PENJUALAN</td>
				<td style="font-size:12pt">: 
					<?php if($_REQUEST['statusOrder'] == 'x'): ?>
						Semua
					<?php endif; ?>
					
					<?php if($_REQUEST['statusOrder'] == '4'): ?>
						Belum Bayar
					<?php endif; ?>		

					<?php if(in_array($_REQUEST['statusOrder'],array(0,1,2,3))): ?>
						Sudah Bayar
					<?php endif; ?>	
				</td>
			</tr>
			<tr>
				<td style="font-size:12pt">SAMPAI TANGGAL</td>
				<td style="font-size:12pt"> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
				<td style="font-size:12pt">VALIDASI PEMBAYARAN</td>
				<td style="font-size:12pt"> :
					<?php if($_REQUEST['statusPayment'] == 'x'): ?>
							Semua
					<?php endif; ?>		
					
					<?php if($_REQUEST['statusPayment'] == '0'): ?>
							Belum di Validasi
					<?php endif; ?>		

					<?php if($_REQUEST['statusPayment'] == '1'): ?>
							Sudah di Validasi
					<?php endif; ?>	
				</td>
			</tr>
			<tr>
				<td style="font-size:12pt" width="15%">KATEGORI BARANG </td>
				<td style="font-size:12pt" colspan="3"> : 
					<?php while($val = mysql_fetch_array($dataCategoryPrint)): ?>
						<small><?php echo $val['name'] ?></small>,		
					<?php endwhile; ?>							
				</td>
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
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">TANGGAL</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">NAMA PEMBELI</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">HANDPHONE</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">TOTAL TRANSFER</th>						
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $total = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center" style="font-size:12pt; border:1px solid black"><?php echo $i ?></td>
								<td align="left" style="padding:8px; font-size:12pt; border:1px solid black">
									<?php echo $val['date_order_frm'] ?><br />
									<small style="font-size: 10px">[<?php echo $val['category_name'] ?>]</small>
								</td>
									<td align="left" style="padding:5px; font-size:12pt; border:1px solid black">
									<?php echo $val['name'] ?><br />
									<span style="font-size:8pt">(Sales: <?php echo $val['sales_name'] ?>) </span>	

								</td>
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									&nbsp; <?php echo strlen($val['phone']) < 50 ? trim(str_replace(array('+',' ','-'), '',$val['phone'])) : '' ?>&nbsp;
								</td>								
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									<?php echo number_format($val['total'],0,'','.') ?>
								</td>							
							</tr>	
							
							<?php $total = $total + $val['total']; ?>
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<!--	
					<tr>
						<th style="padding:5px; font-size:11pt; border:1px solid black" colspan="4" align="left" style="text-align:center">GRAND TOTAL</th>
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo number_format($total,0,'','.') ?></th>
					</tr>
					-->	
				</table>			
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
