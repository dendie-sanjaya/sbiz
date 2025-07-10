<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<?php include '../lib/connection.php' ?>

	<h1>RENCANA PENGADAAN BARANG</h1>
	<br />
	<form action="index.php" method="post" >					
		<table width="100%" border="0">
			<tr>
				<td valign="top" width="420">
					<?php if($_REQUEST['periodeOrderId'] != 'x'): ?> 
						PERIODE PEMESANAN  : <b><?php echo $periodeName['name'] ?> (<?php echo $periodeName['date_start'] ?> - <?php echo $periodeName['date_end'] ?>)</b>	
					<?php endif; ?> </b>
				</td>
		</table>
	</form>	
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
			<table width="100%" border="0" style="border:1px solid black" cellpadding="0" cellspacing="0">
				<thead>			
					<tr	>
						<th align="center" style="padding:5px; font-size:12pt; border: 1px solid black" width="2%" >NO</th>
						<th align="center" style="padding:5px; font-size:12pt; border: 1px solid black"  width="">NAMA BARANG</th>
						<th align="center" style="padding:5px; font-size:12pt; border: 1px solid black"  width="">KBTH</th>
						<th align="center" style="padding:5px; font-size:12pt; border: 1px solid black"  width="">HARGA DASAR</th>	
						<th align="center" style="padding:5px; font-size:12pt; border: 1px solid black"  width="">HARGA JUAL</th>							
						<th align="center" style="padding:5px; font-size:12pt; border: 1px solid black"  width="">BIAYA <br /><small style="font-size:8pt">(HARGA DASAR * KBTH)</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = 1 ?>
					<?php $totalBiayaKurangStok = 0 ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr style="background-color:#6661">
							<td align="center" style="padding:5px; font-size:12pt; border: 1px solid black"><?php echo $i ?></td>
							<td width="280" style="padding:5px; font-size:12pt; border: 1px solid black">
								<?php echo $val['stuff_name'] ?><br />
								<small style="font-size:8xp">(<?php echo $val['nickname'] ?>)</small>  	
							</td>
							<td align="center" style="padding:5px; font-size:12pt; border: 1px solid black">
								<?php echo round($val['amount_total'],2) ?> <?php echo $val['satuan'] ?>
							</td>
							<td align="center" style="padding:5px; font-size:12pt; border: 1px solid black">
								<?php echo number_format($val['price_basic'],0,'','.') ?> 
							</td>
							<td align="center" style="padding:5px; font-size:12pt; border: 1px solid black">
								<?php echo number_format( $val['price'],0,'','.') ?> 
							</td>							
							<td align="center" style="padding:5px; font-size:12pt; border: 1px solid black">
								<?php $biaya = $val['amount_total'] * $val['price_basic'] ?>
								<?php echo number_format($biaya,0,'','.') ?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="5">
							<?php 
								
								$stuffId = $val['stuff_id'];
								
								$query = "select so.id, sod.amount, sod.stuff_id, so.name as nama_pembeli,
											so.no_order, date_format(so.date_order,'%d-%m-%Y') as date_order, sod.name,
											sod.name, sod.nickname
										  from sales_order_detail as sod 
										  inner join sales_order as so
										    on so.id = sod.sales_order_id
											  and so.is_delete = '0'
											  and so.status_payment = '1'
											  and so.status_complate_stuff = '0'
											  and so.tipe_order = '1'
											  and so.status_close = '0'
											  $where
										  where sod.stuff_id = '$stuffId'
										  order by sod.amount desc";

								$dataSub = mysql_query($query) or die(mysql_error().'asd');

							?>				
								<table width="100%" style="padding:10px; border: 1px solid black" cellspacing="0" cellpadding="0">
									<thead>
										<td style="padding:5px; font-size:12pt; border: 1px solid black"  align="center">NO</td>
										<td style="padding:5px; font-size:12pt; border: 1px solid black"  align="center">NO SALES ORDER</td>
										<td style="padding:5px; font-size:12pt; border: 1px solid black"  align="center">TGL PEMESANAN</td>
										<td style="padding:5px; font-size:12pt; border: 1px solid black"  align="center">NAMA PEMBELI</td>
										<td style="padding:5px; font-size:12pt; border: 1px solid black"  align="center">JUMLAH PESAN</td>
									</thead>
									<?php $j=1 ?>
									<tbody>
									
									<?php while($rowdataSub = mysql_fetch_array($dataSub)): ?>
										<tr>
											<td style="padding:2px; font-size:12pt; border: 1px solid black"   align="center"><?php echo $i.'.'.$j ?></td>
											<td style="padding:2px; font-size:12pt; border: 1px solid black"   align="center"><?php echo $rowdataSub['no_order'] ?></td>
											<td style="padding:2px; font-size:12pt; border: 1px solid black"   align="center"><?php echo $rowdataSub['date_order'] ?></td>
											<td style="padding:2px; font-size:12pt; border: 1px solid black"   align="center">
												<?php echo $rowdataSub['nama_pembeli'] ?>	
											</td>
											<td style="padding:2px; font-size:12pt; border: 1px solid black"   align="center"><b><?php echo $rowdataSub['amount'] ?></b></td>
										</tr>	
										<?php $j++ ?>	
									<?php endwhile; ?>	
									</tbody>									
								</table>
							</td>
						</td>					
					<?php $totalBiayaKurangStok = $totalBiayaKurangStok + $biaya ?>	
					<?php $i++; ?>
					<?php endwhile; ?>
					<tr>
						<th style="padding:2px; font-size:12pt; border: 1px solid black"  colspan="5" align="center"><b>GRAND TOTAL<b></th>
						<th style="padding:2px; font-size:18pt; border: 1px solid black"  align="center"><b><?php echo number_format( $totalBiayaKurangStok,0,'','.') ?></b></th>
					</tr>
				<tbody>
			</table>	
		</div>
	<?php endif; ?>
	
	<?php include '../lib/connection-close.php' ?>
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
