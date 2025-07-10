<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=REKAPITULASI-KLIEN.xls");
?>

<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<center><h1>REKAPITULASI KLIEN</h1></center>
	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td width="20%">DARI TANGGAL </td>
				<td width="25%"> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td width="20%">KATEGORI</td>
				<td>
					: <?php echo $categoryId == 'x' ? 'SEMUA' : $printDataCategory['name'] ?>
				</td>
			</tr>
			<tr>
				<td>SAMPAI TANGGAL</td>
				<td> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</fieldset>
	<p></p>
	<div id="tbl">
		<?php if(mysql_num_rows($data) < 1) : ?>
		 	<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="30%">NAMA KLIEN</th>
						<th align="center" width="15%">TIPE</th>
						<th align="center" width="20%">TOTAL</th>	
					</tr>	
				</thead>
				<tbody>
					<?php $priceTotal = 0; ?>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center" valign="top"><?php echo $i ?></td>
							<td valign="top" align="left">
								<?php echo $val['client_name'] ?>
							</td>
							<td valign="top" align="center">
								BRG. KELUAR
							</td>
							<td valign="top" align="center">
								<?php echo abs($val['total']) ?>
								<?php $priceTotal = $priceTotal +  abs($val['total']); ?>
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
						<tr>
							<td align="center" valign="top" colspan="3"><b>TOTAL</b></td>
							<td valign="top" align="center">
								<b><?php echo $priceTotal ?></b>
							</td>
						</tr>	
				</tbody>			
			</table>	
		<?php endif; ?>
	</div>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/excel.php' ?>	
