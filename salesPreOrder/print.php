<?php ob_start(); ?>
<?php include 'editRead.php' ?>
	<table width="100%">
		<tr>
			<td width="210"><image src="../asset/image/logo.jpg" width="250" /></td>
			<td align="right" style="text-valign:middle"><h1>FAKTUR PENJUALAN</h1></td>
		</tr>
	</table>
	<br />
	<fieldset style="border:2px black solid; font-size:14pt;" />
		<legend><b>JENIS PEMBELIAN<b></legend>			
			<table width="100%" style="font-size:12pt">
				<tr>
					<td>NO SALES ORDER</td>
					<td><b>: <?php echo $dataHeader['no_order'] ?></b></td>
					<td>TGL PEMBELIAN</td>	
					<td>: 
						<?php echo $dataHeader['date_order_frm'] ?>
					</td>
				<tr>
				<tr>
					<td width="25%">TIPE PENJUALAN</td>
					<td width="25%" >: 
						<?php if($dataHeader['tipe_order'] == '0'): ?>
							Langsung
						<?php endif; ?>		

						<?php if($dataHeader['tipe_order'] == '1'): ?>
							Pemesanan
						<?php endif; ?>		
					<td width="20%	">PEDAGANG</td>
					<td>: 
						<?php if($dataHeader['client_id'] == '0'): ?>
							Pembeli Langsung
						<?php endif; ?>		

						<?php if($dataHeader['client_id'] != '0'): ?>
							Pedagang / Reseller
						<?php endif; ?>							
					</td>
				<tr>
				</tr>		
					<td  width="20%" id="periodePemesananLabel" style="display:none">PERIODE PEMESANAN</b>
					<td style="display:none" id="periodePemesananCmb">: 
						<?php echo $dataHeader['period_order_id'] ?>						
					</td>
				</tr>
			</table>
	</fieldset>
	<br />	
	<fieldset style="border:2px solid black; font-size:14pt;">
		<legend><b>DATA PEMBELI<b></legend>			
			<table style="font-size:12pt" width="100%" cellpadding="0" cellspacing="0"  width="100%" border="0">
				<tr>
					<td width="25%" valign="top" >NAMA</td>
					<td width="25%" valign="top">:
						<?php echo $dataHeader['name'] ?>
					</td>
					<td width="20%"  valign="top">TELEPON</b>
					<td valign="top">: 
						<?php echo $dataHeader['phone'] ?>
					</td>												
				</tr>
				<tr>
					<td width="" valign="top">ALAMAT PENGIRIMAN</td>
					<td colspan="4">: 
						<?php echo $dataHeader['address_shipping'] ?>
					</td>
				</tr>
			</table>
	</fieldset>	
	<br />
	<fieldset id="detailStuff" style="border:2px solid black; font-size:14pt;">
		<legend><b>DATA BARANG<b></legend>	
		<div id="tbl">
			<table width="100%" border="0" style=" border:1px solid black; padding:0; font-size:14pt;" cellspacing="0" cellpadding="0">
				<thead>			
					<tr>
						<th align="center" width="5%" style="padding:5px; font-size:12pt;  border:1px solid black;">NO</th>
						<th align="center" width="30%" style="padding:5px; font-size:12pt;  border:1px solid black;">NAMA BARANG</th>
						<th align="center" width="10%" style="padding:5px; font-size:12pt;  border:1px solid black;">QTY</th>							
						<th align="center" width="15%" style="padding:5px; font-size:12pt;  border:1px solid black;">HARGA JUAL</th>
						<th align="center" width="" style="padding:5px;  font-size:12pt;  border:1px solid black;">JUMLAH</th>
					</tr>	
				</thead>					
				<tbody>
					<?php $i=1; ?>
					<?php $total = 0 ?>
					<?php while($val = mysql_fetch_array($dataDetail)): ?>
						<tr>
							<td style="padding:5px; font-size:12pt;  border:1px solid black;" align="center" ><?php echo $i ?></td>
							<td style="padding:5px; font-size:12pt;  border:1px solid black;"><?php echo $val['name'] ?><br /><small>(<?php echo $val['nickname'] ?>)</small></td>
							<td style="padding:5px; font-size:12pt;  border:1px solid black;" align="center">
								<?php echo $val['amount'] ?>
							</td>
							<td style="padding:5px; font-size:12pt;  border:1px solid black;" align="center">Rp. <?php echo number_format($val['price'],0,'','.') ?></td>	
							<td style="padding:5px; font-size:12pt;  border:1px solid black;" align="center">Rp. <?php echo number_format($val['price'] * $val['amount'] ,0,'','.') ?></td>								
						</tr>	
						<?php $total = $total + ($val['price'] * $val['amount']) ?>
					<?php $i++; ?>
					<?php endwhile; ?>
				</tbody>
				<tfoot>	
					<tr>
						<td style="padding:5px;  font-size:12pt;  border:1px solid black;" align="left" colspan="3	"><b>TOTAL</b></td>
						<td style="padding:5px; font-size:12pt;  border:1px solid black;"align="center"><b>Rp. <?php echo number_format($total,0,'','.') ?></b></td>
						<td style="padding:5px; font-size:12pt;  border:1px solid black;"	>&nbsp;</td>
					</tr>						
					<tr>
						<td style="padding:5px;  font-size:12pt;  border:1px solid black;" align="left" colspan="2"><b>DISKON</b></td>
						<td style="padding:5px; font-size:12pt;  border:1px solid black;" colspan="2" align="center"><?php echo $dataHeader['discount_persen'] ?> %</td>
						<td style="padding:5px; font-size:12pt;  border:1px solid black;" align="center" width="20%">
							<span id="labelDiskon">Rp. <?php echo  number_format(($total/100) * $dataHeader['discount_persen'],0,'','.') ?></span>
						</td>
					</tr>	
					<tr>
						<td style="padding:5px;  font-size:12pt;  border:1px solid black;" align="left" colspan="4"><b>TOTAL SETELAH DISKON</b></td>
						<td style="padding:5px; font-size:12pt;  border:1px solid black;" align="center"><b><span id="labelTotal">Rp. <?php echo number_format($total - (($total/100) * $dataHeader['discount_persen']),0,'','.') ?></b></span></td>
					</tr>						
					<tr>
						<td  style="padding:5px;  font-size:12pt;  border:1px solid black;"align="left" colspan="4"><b>BIAYA KIRIM</b></td>
						<td  style="padding:5px; font-size:12pt;  border:1px solid black;"align="center">Rp. <?php echo number_format($dataHeader['shipping_cost'],0,'','.') ?></td>
					</tr>												
					<tr>
						<th  style="padding:5px;  font-size:12pt;  border:1px solid black; text-align:left"   width="5%"colspan="4">GRAND TOTAL</th>
						<th style="padding:5px; font-size:12pt;  border:1px solid black;" ><b>
							Rp. <?php echo number_format(($total - (($total/100) * $dataHeader['discount_persen'])) + $dataHeader['shipping_cost'],0,'','.') ?>
						</b></th>
					</tr>	
				</tfoot>
			</table>
		</div>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>
