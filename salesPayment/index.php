<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>VALIDASI PEMBAYARAN TRANSFER</h1>
		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td width="15%" valign="middle">KATA KUNCI</td>
							<td valign="top">
								<input placeholder="NAMA PEMBELI / NO SALES ORDER" name="keyword" type="text" title="abc" value="<?php echo $_REQUEST['keyword'] ?>" style="width:400px" />
								<input type="submit" value="FILTER" />
							</td>
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
		Data dibawah ini adalah <big style="font-size:14px">PENJUALAN</big> yang belum dilakukan <big style="font-size:14px">VALIDASI PEMBAYARAN</b>
	</div>	

	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="addSave.php" method="post" id="frm" onsubmit="return printLabel()" />	
			<table width="100%">
				<tr>
					<td width="30%">			
						<select name="actionType" id="actionType" style="width:200px;">
							<option value="0">-- PILIH AKSI --</option>
							<option value="1">Validasi Pembayaran</option>
						</select>
						<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
					</td>
				</tr>
			</table>
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th align="center" width="5%"><input class="bigCheckBox" style="cursor:pointer" type="checkbox" onclick="toggleCheckBox(this)" /></th>				
							<th align="center" width="5%">NO</th>
							<th align="center" width="17%">TGL PEMESANAN</th>
							<th align="center" width="15%">NO SALES ORDER</th>						
							<th align="center" width="20%">NAMA PEMBELI</th>
							<th align="center" width="11%">PEMBAYARAN</th>
							<th align="center" width="11%">KURIR</th>							
							<th align="center" width="%">JUMLAH</th>

						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr style="cursor:pointer">
								<td align="center">
									<input class="bigCheckBox" style="cursor:pointer" name="salesOrderId[]" type="checkbox" value="<?php echo $val['id'] ?>" />
								</td>						
								<td align="center"><?php echo $i ?></td>
								<td align="center"><?php echo $val['date_order_frm'] ?></td>
								<td align="center">
									<?php if($val['tipe_order'] == '0'): ?>
										<a href="../salesOrder/print.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a></td>
									<?php else: ?>
										<a href="../salesOrder/print.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a></td>
									<?php endif?>		
								</td>
								<td align="center"><?php echo $val['name'] ?><br />
									<b>
									<?php if($val['is_reseller'] == '1'): ?>
										<small style="font-size: 10px">Reseller: <?php echo $val['reseller_name'] ?></small>
									<?php else: ?>
										<small style="font-size: 10px">Sales: <?php echo $val['sales_name'] ?></small>										
									<?php endif; ?>	
									</b>
								</td>
								<td align="center"><?php echo $val['description_payment'] ?></td>	
								<td align="center"><?php echo $val['expedition_name'] ?></td>						
								<td align="center"><?php echo number_format($val['jml'],0,'','.')?></td>							
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
		</form>	
		<script>
			function printLabel() { 
				var e = document.getElementById ("actionType");
				var p = e.options [e.selectedIndex] .value;
					
				if(p == '0') {
					alert('Mohon untuk memilih aksi terlebih dahulu');
					return false;
				}
				
				if(p == '1') {
					if(confirm('Anda yakin akan melakukan validasi pembayaran ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}
				if(p == '2') {
					if(confirm('Anda yakin akan membatalkan pembayaran ?')) {
						document.getElementById('frm').action = 'addSave.php';	
						document.getElementById('frm').target = '';						
						return true;
					} else {
						return false;
					}				
				}
				
			}
		</script>		
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
