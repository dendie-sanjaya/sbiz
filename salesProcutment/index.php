<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<?php include '../lib/connection.php' ?>
	
	<h1>RENCANA PENGADAAN BARANG</h1>
	<br />
	<form action="index.php" method="post" >					
		<table width="100%" border="0">
			<tr>
				<td valign="top" width="420">
					PERIODE PEMESANAN 
					<select name="periodeOrderId" style="width:200px; height:30px" onchange="this.form.submit()">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['periodeOrderId']) ? $_REQUEST['periodeOrderId'] : '') ? 'selected' : '' ?>>Semua</option>
						<?php while($val = mysql_fetch_array($dataPeriodeOrder)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['periodeOrderId']) ? $_REQUEST['periodeOrderId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>						
				</td>
				<td align="right">
						<?php if(mysql_num_rows($data) > 0) : ?>
							<input type="button" value="PRINT" onclick="window.open('print.php?periodeOrderId=<?php echo $periodeOrderId ?>')" />
						<?php endif; ?>	
				</td>
		</table>
	</form>	
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
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="2%" >NO</th>
						<th align="center" width="">NAMA BARANG</th>
						<th align="center" width="">KBTH</th>
						<th align="center" width="">HARGA DASAR</th>	
						<th align="center" width="">HARGA JUAL</th>							
						<th align="center" width="">BIAYA <br /><small style="font-size:8px">(HARGA DASAR * KBTH)</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = 1 ?>
					<?php $totalBiayaKurangStok = 0 ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr style="">
							<td align="center" style="color:white; font-weight:bold; background-color:gray"><?php echo $i ?></td>
							<td width="280" style="color:white; font-weight:bold; background-color:gray">
								<?php echo $val['stuff_name'] ?><br />
								<small style="font-size:8xp">(<?php echo $val['nickname'] ?>)</small>  	
							</td>
							<td align="center" style="color:white; font-weight:bold; background-color:gray">
								<?php echo round($val['amount_total'],2) ?> <?php echo $val['satuan'] ?>
							</td>
							<td align="center" style="color:white; font-weight:bold; background-color:gray">
								<?php echo number_format($val['price_basic'],0,'','.') ?> 
							</td>
							<td align="center" style="color:white; font-weight:bold; background-color:gray">
								<?php echo number_format( $val['price'],0,'','.') ?> 
							</td>							
							<td align="center" style="color:white; font-weight:bold; background-color:gray">
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
								<table width="100%">
									<thead>
										<td style="font-size:12px; font-weight:bold" align="center">NO</td>
										<td style="font-size:12px; font-weight:bold" align="center">NO SALES ORDER</td>
										<td style="font-size:12px; font-weight:bold" align="center">TGL PEMESANAN</td>
										<td style="font-size:12px; font-weight:bold" align="center">NAMA PEMBELI</td>
										<td style="font-size:12px; font-weight:bold" align="center">JUMLAH PESAN</td>
									</thead>
									<?php $j=1 ?>
									<tbody>
									
									<?php while($rowdataSub = mysql_fetch_array($dataSub)): ?>
										<tr>
											<td style="font-size:12px"  align="center"><?php echo $i.'.'.$j ?></td>
											<td style="font-size:12px"  align="center"><a target="_blank" href="../salesOrder/print.php?id=<?php echo $rowdataSub['id'] ?>"><?php echo $rowdataSub['no_order'] ?></a></td>
											<td style="font-size:12px"  align="center"><?php echo $rowdataSub['date_order'] ?></td>
											<td style="font-size:12px"  align="center">
												<?php echo $rowdataSub['nama_pembeli'] ?>	
											</td>
											<td style="font-size:12px"  align="center"><b><?php echo $rowdataSub['amount'] ?></b></td>
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
						<th colspan="5" align="center"><b>GRAND TOTAL<b></th>
						<th align="center"><b><?php echo number_format( $totalBiayaKurangStok,0,'','.') ?></b></th>
					</tr>
				<tbody>
			</table>	
		</div>
	<?php endif; ?>
	<?php include '../lib/connection-close.php'; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
