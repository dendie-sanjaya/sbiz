<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN PENDAPATAN BEDASARKAN TRANSAKSI.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>LAPORAN PENDAPATAN BEDASARKAN TRANSAKSI</h1></center>
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
				<td style="font-size:12pt" width="15%">KATEGORIBARANG </td>
				<td style="font-size:12pt" colspan="3"> : 
					<?php while($val = mysql_fetch_array($dataCategoryPrint)): ?>
						<small><?php echo $val['name'] ?></small>,		
					<?php endwhile; ?>							
				</td>
			</tr>	
			<tr>
				<td style="font-size:12pt" width="15%">KETERANGAN PEMBAYARAN </td>
				<td style="font-size:12pt" colspan="3"> : 
					<?php while($val = mysql_fetch_array($dataFinSourceFundPrint)): ?>
						<small><?php echo $val['name'] ?></small>,		
					<?php endwhile; ?>							
				</td>
			</tr>											
			<tr>
			  <td>BIAYA IKLAN </td>	
			  <td>: Rp <?php echo number_format($_REQUEST['costAdds'] > 0 ? $_REQUEST['costAdds'] : 0 ,0,'','.') ?></td>	
			  <td><small style="font-size:9px">[ Untuk menghitung ROAS (Return of Ad Spend) ]</small><br style="margin-bottom: 10px"/></td>
			  <td>&nbsp;</td>
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
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">NO SO</th>						
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">TANGGAL</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">NAMA PEMBELI</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">HARGA DASAR</th>						
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">HARGA JUAL</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">DISKON PERSEN</th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">DISKON NOMINAL</th>							
							<th style="padding:5px; font-size:11pt; border:1px solid black; font-size:10px" align="center" width="%">HARGA JUAL <small style="font-size:9px"><br />(Stl Diskon)<small></th>
							<th style="padding:5px; font-size:11pt; border:1px solid black; font-size:10px" align="center" width="%">LABA <small style="font-size:9px"><br />(Stl Diskon)<small></th>
							<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">BIAYA KIRIM</th>						
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalHargaDasar = 0; ?>
						<?php $totalHargaJual = 0; ?>
						<?php $totalDiskon = 0; ?>
						<?php $totalLaba = 0; ?>
						<?php $totalBiayaKirim = 0; ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center" style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $i ?></td>
								<td align="left" style="padding:5px; font-size:11pt; border:1px solid black">
									<?php echo $val['no_order'] ?>
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<br />
										<small style="font-size: 10px">[<?php echo $val['category_name'] ?>]</small>
									<?php endif; ?>	
								</td>
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="left" style="font-size:10px">
									Pemesanan  : <?php echo $val['date_order_frm'] ?><br />
									Pembayaran : <?php echo $val['date_payment_frm'] ?>
								</td>
									<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									<?php echo $val['name'] ?><br />
									<span style="font-size:8pt">(Sales: <?php echo $val['sales_name'] ?>) <br /></span>		
									<small style="font-size: 9px">
									<!--Pemesanan    : <?php echo $val['date_order_frm'] ?><br />-->
									Tgl Pembayaran : <?php echo $val['date_payment_frm'] ?>	<br />
									</small>																									
									<small style="font-size: 9px">
									Ket Pembayaran : <?php echo $val['fin_source_fund_name'] ?>
									</small>																																																																				
								</td>
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php if($val['platform_market_fee_percent'] > 0): ?>										
											<?php $amount_basic_sale = (($val['price_basic'] * $val['sod_amount']) + (($val['price_basic'] * $val['sod_amount']) * ($val['platform_market_fee_percent'] / 100))) ?>
										<?php else: ?>
											<?php $amount_basic_sale = ($val['price_basic'] * $val['sod_amount']) ?>
										<?php endif; ?>
										
									   <?php echo ($amount_basic_sale ) ?>	

									   <?php if($val['platform_market_fee_percent'] > 0): ?>
										   <?php //echo number_format(($val['amount_basic_sale']),0,'','.')?>	<br />
										   <div style="font-size:  7px">
										   		Biaya Admin <br />Platform Market Place 
										   		<br /> [ <b><?php echo $val['platform_market_fee_percent'] ?> % </b>]
										   		<br /> Harga Dasar Awal : 
										   		<?php echo number_format((($val['price_basic'] * $val['sod_amount'])),0,'','.')?>
										   </div>	
									   <?php endif; ?>	   

									<?php else: ?>	
										<?php if($val['platform_market_fee_percent'] > 0): ?>										
											<?php $amount_basic_sale = ($val['amount_basic_sale'] + ($val['amount_basic_sale'] * ($val['platform_market_fee_percent'] / 100))) ?>
										<?php else: ?>
											<?php $amount_basic_sale = $val['amount_basic_sale'] ?>
										<?php endif; ?>

									   <?php echo ($amount_basic_sale ) ?>	
									   <?php if($val['platform_market_fee_percent'] > 0): ?>
										   <?php //echo number_format(($val['amount_basic_sale']),0,'','.')?>	<br />
										   <div style="font-size:  7px">
										   		Biaya Admin <br />Platform Market Place 
										   		<br /> [ <b><?php echo $val['platform_market_fee_percent'] ?> % </b>]
										   		<br /> Harga Dasar Awal : 
										   		<?php echo $val['amount_basic_sale'] ?>
										   </div>	
									   <?php endif; ?>	   
									<?php endif; ?>									  

								</td>							
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php echo number_format(($val['price']  * $val['sod_amount']),0,'','')?>
									<?php else: ?>	
									   <?php echo number_format($val['amount_sale'],0,'','')?>										
									<?php endif; ?>									  
								</td>							
								<td style="padding:5px; font-size:11pt; border:1px solid black"align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php echo number_format($val['jml_diskon_per_category'],0,'','')?><br />
										<span style="font-size:9px"><?php echo abs($val['discount_persen']) ?> %</span>
									<?php else: ?>	
										<?php echo number_format($val['jml_diskon'],0,'','')?><br />
										<span style="font-size:9px"><?php echo abs($val['discount_persen']) ?> %</span>
									<?php endif; ?>	
								</td>	
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php echo number_format((($val['price']  * $val['sod_amount']) - $val['jml_diskon_per_category']) - $val['discount_amount_div'],0,'','')?>
									<?php else: ?>	
									   <?php echo number_format((($val['amount_sale'] - $val['jml_diskon']) - $val['discount_amount']) ,0,'','')?>										
									<?php endif; ?>									  
								</td>															
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center" style="padding:5px; font-size:11pt; border:1px solid black">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php echo number_format((($val['price'] * $val['sod_amount']) - $val['jml_diskon_per_category']) - $val['discount_amount'],0,'','')?>
									<?php else: ?>	
									   <?php echo number_format(($val['amount_sale'] - $val['jml_diskon']) - $val['discount_amount'],0,'','.')?>										
									<?php endif; ?>									  
								</td>															
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
									  <?php echo number_format($val['jml_laba_per_category'],0,'','') ?>
									<?php else: ?>	
										<?php echo number_format($val['jml_laba'],0,'','') ?>
									<?php endif; ?>	
								</td>	
								<td style="padding:5px; font-size:11pt; border:1px solid black" align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
									   <?php echo number_format($val['shipping_cost_per_category'],0,'','') ?>									
									<?php else:  ?>
									   <?php echo number_format($val['shipping_cost'],0,'','') ?>
									<?php endif; ?>	
								</td>							
							</tr>	
							<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?> 
								<?php //$totalHargaDasar = $totalHargaDasar + ($val['price_basic'] * $val['sod_amount']); ?>
								<?php $totalHargaDasar = $totalHargaDasar + $amount_basic_sale; ?>																
								<?php $totalHargaJual = $totalHargaJual + ($val['price'] * $val['sod_amount']); ?>
								<?php $totalDiskon = $totalDiskon + $val['jml_diskon_per_category']; ?>
								<?php //$grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['discount_amount']; ?>
								<?php $grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['discount_amount_div']; ?>
								<?php //$grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['jml_diskon_amount_per_category']; ?>																
								<?php $totalLaba = $totalLaba + $val['jml_laba_per_category'] ; ?>
								<?php $totalBiayaKirim = $totalBiayaKirim + $val['shipping_cost_per_category'] ; ?>
								<?php $totalHargaJualAfterDiskon = (($totalHargaJual - $totalDiskon) - $grandTotalDiskoNominal); ?>
							<?php else: ?>	
								<?php //$totalHargaDasar = $totalHargaDasar + $val['amount_basic_sale']; ?>
								<?php $totalHargaDasar = $totalHargaDasar + $amount_basic_sale; ?>																
								<?php $totalHargaJual = $totalHargaJual + $val['amount_sale']; ?>
								<?php $totalDiskon = $totalDiskon + $val['jml_diskon']; ?>
								<?php $grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['discount_amount']; ?>
								<?php //$grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['jml_diskon_amount_per_category']; ?>								
								<?php $totalLaba = $totalLaba + $val['jml_laba'] ; ?>
								<?php $totalBiayaKirim = $totalBiayaKirim + $val['shipping_cost'] ; ?>
								<?php $totalHargaJualAfterDiskon = (($totalHargaJual - $totalDiskon) - $grandTotalDiskoNominal); ?>
							<?php endif; ?>
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<tr>
						<th style="padding:5px; font-size:11pt; border:1px solid black" colspan="4" align="left" style="text-align:center">GRAND TOTAL</th>
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $totalHargaDasar ?></th>
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $totalHargaJual ?></th>
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $totalDiskon ?></th>
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $grandTotalDiskoNominal ?></th>						
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $totalHargaJualAfterDiskon ?></th>												
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $totalLaba ?></th>
						<th style="padding:5px; font-size:11pt; border:1px solid black"><?php echo $totalBiayaKirim ?></th>
					</tr>
					<?php if($costAdds > 0): ?>
					<tr>
						<th colspan="3" align="left" style="padding:5px; font-size:11pt; border:1px solid black">
						    NILAI ROAS (Return of Ad Spend) <br />
						    <div style="font-size:10px; margin-top: 5px; margin-bottom: 5px">Rumus (Grand Total Laba - Biaya Iklan) / Biaya Iklan</div>
						</th>
						<th colspan="7" style="padding:5px; font-size:11pt; border:1px solid black">
							<?php $roas = (($totalLaba - $costAdds) / $costAdds) ?>
							<?php echo round($roas,2) ?>							
						</th>
					</tr>	
					<?php endif; ?>													
				</table>			
			</div>
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
