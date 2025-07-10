<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>LAPORAN PENDAPATAN BEDASARKAN TRANSAKSI</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="post">
			<table width="100%">
				<tr style="height: 60px">
					<td valign="top">
						STATUS PENJUALAN<br style="margin-bottom: 10px" />
						<select name="statusOrder" style="width:100%">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] :'') ? 'selected' : '' ?>>Semua</option>							
							<option value="4" <?php echo '4' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Belum Bayar</option>
							<option value="0" <?php echo '0' == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $statusOrder) ? 'selected' : '' ?>>Sudah Bayar</option>
						</select>				
					</td>
					<td valign="top">
						VALIDASI PEMBAYARAN<br style="margin-bottom: 10px" />
						<select name="statusPayment" style="width:100%">
							<option value="x" <?php echo 'x' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] :$statusPayment) ? 'selected' : '' ?>>Semua</option>							
							<option value="1" <?php echo '1' == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Sudah di Validasi</option>
							<option value="0" <?php echo '0' == (isset($_REQUEST['statusPaymenet']) ? $_REQUEST['statusPayment'] : $statusPayment) ? 'selected' : '' ?>>Belum di Validasi</option>
						</select>				
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
				<tr>
				  <td colspan="2">
				  	KATEGORI BARANG<br style="margin-bottom: 10px" />
					<select name="categoryId[]" style="width:100%; height:200px"  multiple>
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option <?php echo in_array($val['id'],$categoryId) ? ' selected ' : '' ?> value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
				  </td>	
				</tr>	
				<tr>
				  <td colspan="2" style="padding-top:8px">
				  	BIAYA IKLAN <small style="font-size:9px">[ Untuk menghitung ROAS (Return of Ad Spend) ]</small><br style="margin-bottom: 10px"/> 
					<input type="text" name="costAdds" id="costAdds" value="<?php echo isset($_REQUEST['costAdds']) ? $_REQUEST['costAdds'] :'' ?>"  style="width:100%" placeholder="contoh: 900000" />				  	
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
			<div style="margin: 10px 0px 10px 0px">
				<div style="text-align:left; float: left">
					<input type="button" value="PRINT DATA PEMBELI" onclick="window.open('printBuyer.php?categoryIdChoose=<?php echo $categoryIdChoose ?>&buyer=1&statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
					<input type="button" value="EXPORT DATA PEMBELI KE EXCEL" onclick="window.open('excelBuyer.php?categoryIdChoose=<?php echo $categoryIdChoose ?>&buyer=1&statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
				</div>	

				<div style="text-align:right">
					<input type="button" value="PRINT PENJUALAN" onclick="window.open('print.php?costAdds=<?php echo $costAdds ?>&categoryIdChoose=<?php echo $categoryIdChoose ?>&statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
					<input type="button" value="EXPORT PENJUALAN KE EXCEL" onclick="window.open('excel.php?costAdds=<?php echo $costAdds ?>&categoryIdChoose=<?php echo $categoryIdChoose ?>&statusOrder=<?php echo $statusOrder ?>&statusPayment=<?php echo $statusPayment ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
				</div>	
			</div>		
			<div id="tbl">
				<table width="100%">
					<thead>			
						<tr>
							<th style="font-size:12px" align="center" width="5%">NO</th>
							<th style="font-size:12px" align="center" width="%">NO SO</th>						
							<th style="font-size:12px" align="center" width="%">NAMA PEMBELI</th>
							<th style="font-size:12px" align="center" width="%">HARGA DASAR</th>						
							<th style="font-size:12px" align="center" width="%">HARGA JUAL</th>
							<th style="font-size:12px" align="center" width="%">DISKON PERSEN</th>
							<th style="font-size:12px" align="center" width="%">DISKON NOMINAL</th>							
							<th style="font-size:10px" align="center" width="%">HARGA JUAL <small style="font-size:8px"><br />(Stl Diskon)<small></th>
							<th style="font-size:10px" align="center" width="%">LABA <small style="font-size:9px"><br />(Stl Diskon)<small></th>
							<th style="font-size:12px" align="center" width="%">BIAYA KIRIM</th>						
						</tr>	
						<tr>
							<th colspan="3" align="left" style="text-align:left">GRAND TOTAL</th>
							<th><div id="grandTotalHargaDasar">Loading...</div></th>
							<th><div id="grandTotalHargaJual">Loading...</div></th>
							<th><div id="grandTotalDiskom">Loading...</div></th>
							<th><div id="grandTotalDiskoNominal">Loading...</div></th>
							<th><div id="grandTotalHargaJualStlDiskon">Loading...</div></th>
							<th><div id="grandTotalLaba">Loading...</div></th>
							<th><div id="grandTotalBiayaKirim">Loading...</div></th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalHargaDasar = 0; ?>
						<?php $totalHargaJual = 0; ?>
						<?php $totalDiskon = 0; ?>
						<?php $totalNominal = 0; ?>
						<?php $totalLaba = 0; ?>
						<?php $totalBiayaKirim = 0; ?>
						<?php $totalHargaJualAfterDiskon = 0; ?>

						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td align="left">
									<a href="../salesOrder/print.php?id=<?php echo $val['id'] ?>" target="_blank"><?php echo $val['no_order'] ?></a>
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<br />
										<small style="font-size: 10px">[<?php echo $val['category_name'] ?>]</small>
									<?php endif; ?>	
								</td>
								<td align="center" style="font-size:10px">
									<?php echo $val['name'] ?><br />
									<span style="font-size:9px">(Sales: <?php echo $val['sales_name'] ?>) </span><br />
									<small style="font-size: 9px">
									<!--Pemesanan    : <?php echo $val['date_order_frm'] ?><br />-->
									Pembayaran : <?php echo $val['date_payment_frm'] ?>		
									</small>																									
								</td>
								<td align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php echo number_format(($val['price_basic'] * $val['sod_amount']),0,'','.')?>
										<?php // echo number_format(($val['amount_basic_sale']),0,'','.')?>	
									<?php else: ?>	
									   <?php echo number_format(($val['amount_basic_sale']),0,'','.')?>										
									<?php endif; ?>									  
								</td>							
								<td align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
									   <?php echo number_format(($val['price']  * $val['sod_amount']),0,'','.')?>
									   <?php //echo number_format($val['amount_sale'],0,'','.')?>																				
									<?php else: ?>	
									   <?php echo number_format($val['amount_sale'],0,'','.')?>										
									<?php endif; ?>									  
								</td>							
								<td align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php echo number_format($val['jml_diskon_per_category'],0,'','.')?><br />
										<?php //echo number_format($val['jml_diskon'],0,'','.')?><br />
										<span style="font-size:9px">(<?php echo $val['discount_persen'] ?>%)</span>
									<?php else: ?>	
										<?php echo number_format($val['jml_diskon'],0,'','.')?><br />
										<span style="font-size:9px">(<?php echo $val['discount_persen'] ?>%)</span>
									<?php endif; ?>	
								</td>	
								<td align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php //echo number_format($val['discount_amount'],0,'','.')?><br />
										<?php echo number_format($val['discount_amount'],0,'','.')?><br />
									<?php else: ?>	
										<?php echo number_format($val['discount_amount'],0,'','.')?><br />
									<?php endif; ?>	
								</td>	
								<td align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
										<?php echo number_format((($val['price']  * $val['sod_amount']) - $val['jml_diskon_per_category']) - $val['discount_amount'],0,'','.')?>
									    <?php //echo number_format((($val['amount_sale'] - $val['jml_diskon']) - $val['discount_amount']) ,0,'','.')?>																				
									<?php else: ?>	
									   <?php echo number_format((($val['amount_sale'] - $val['jml_diskon']) - $val['discount_amount']) ,0,'','.')?>										
									<?php endif; ?>									  
								</td>							
								<td align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
									  <?php // echo number_format(($val['jml_laba_per_category'] - $val['jml_diskon_per_category']),0,'','.') ?>
									  <?php //echo number_format(($val['jml_laba_per_category']),0,'','.') ?>
									  <?php echo number_format(($val['jml_laba']),0,'','.') ?>									  
									<?php else: ?>	
										<?php echo number_format(($val['jml_laba']),0,'','.') ?>
									<?php endif; ?>	
								</td>	
								<td align="center">
									<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
									   <?php echo number_format($val['shipping_cost_per_category'],0,'','.') ?>
									   <?php //echo number_format($val['shipping_cost'],0,'','.') ?>									   									
									<?php else:  ?>
									   <?php echo number_format($val['shipping_cost'],0,'','.') ?>
									<?php endif; ?>	
								</td>							
							</tr>	
							<?php if(!in_array(count($categoryId), array(0,$jmlDataCategory))): ?>
								<?php $totalHargaDasar = $totalHargaDasar + $val['amount_basic_sale']; ?>
								<?php $totalHargaJual = $totalHargaJual + $val['amount_sale']; ?>
								<?php $totalDiskon = $totalDiskon + $val['jml_diskon']; ?>
								<?php $grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['discount_amount']; ?>
								<?php //$grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['jml_diskon_amount_per_category']; ?>								
								<?php $totalLaba = $totalLaba + $val['jml_laba'] ; ?>
								<?php $totalBiayaKirim = $totalBiayaKirim + $val['shipping_cost'] ; ?>
								<?php $totalHargaJualAfterDiskon = (($totalHargaJual - $totalDiskon) - $grandTotalDiskoNominal); ?>

								<?php //$totalHargaDasar = $totalHargaDasar + ($val['price_basic'] * $val['sod_amount']); ?>
								<?php //$totalHargaJual = $totalHargaJual + ($val['price'] * $val['sod_amount']); ?>
								<?php //$totalDiskon = $totalDiskon + $val['jml_diskon_per_category']; ?>
								<?php //$grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['discount_amount']; ?>
								<?php //$grandTotalDiskoNominal  = $grandTotalDiskoNominal + $val['jml_diskon_amount_per_category']; ?>																
								<?php //$totalLaba = $totalLaba + $val['jml_laba_per_category'] ; ?>
								<?php //$totalLaba = $totalLaba + $val['jml_laba'] ; ?>
								<?php //$totalBiayaKirim = $totalBiayaKirim + $val['shipping_cost_per_category'] ; ?>
								<?php //$totalHargaJualAfterDiskon = (($totalHargaJual - $totalDiskon) - $grandTotalDiskoNominal); ?>
							<?php else: ?>					
								<?php $totalHargaDasar = $totalHargaDasar + $val['amount_basic_sale']; ?>
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
						<th colspan="3" align="left" style="text-align:left">GRAND TOTAL</th>
						<th><?php echo number_format($totalHargaDasar,0,'','.') ?></th>
						<th><?php echo number_format($totalHargaJual,0,'','.') ?></th>
						<th><?php echo number_format($totalDiskon,0,'','.') ?></th>
						<th><?php echo number_format($grandTotalDiskoNominal,0,'','.') ?></th>
						<th><?php echo number_format($totalHargaJualAfterDiskon,0,'','.') ?></th>
						<th><?php echo number_format($totalLaba,0,'','.') ?></th>
						<th><?php echo number_format($totalBiayaKirim,0,'','.') ?></th>
					</tr>	
					<?php if($costAdds > 0): ?>
					<tr>
						<th colspan="3" align="left" style="text-align:left;">
						    NILAI ROAS (Return of Ad Spend) <br />
						    <div style="font-size:9px; margin-top: 5px; margin-bottom: 5px">Rumus (Grand Total Laba - Biaya Iklan) / Biaya Iklan</div>
						</th>
						<th colspan="7">
							<?php $roas = (($totalLaba - $costAdds) / $costAdds) ?>
							<?php echo round($roas,2) ?>								
						</th>
					</tr>	
					<?php endif; ?>	
				</table>			
				<script type="text/javascript">
					$("#grandTotalHargaDasar").html('<?php echo number_format($totalHargaDasar,0,'','.') ?>');
					$("#grandTotalHargaJual").html('<?php echo number_format($totalHargaJual,0,'','.') ?>');
					$("#grandTotalDiskom").html('<?php echo number_format($totalDiskon,0,'','.') ?>');
					$("#grandTotalDiskoNominal").html('<?php echo number_format($grandTotalDiskoNominal,0,'','.') ?>');
					$("#grandTotalHargaJualStlDiskon").html('<?php echo number_format($totalHargaJualAfterDiskon,0,'','.') ?>');
					$("#grandTotalLaba").html('<?php echo number_format($totalLaba,0,'','.') ?>');
					$("#grandTotalBiayaKirim").html('<?php echo number_format($totalBiayaKirim,0,'','.') ?>');
				</script>
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
