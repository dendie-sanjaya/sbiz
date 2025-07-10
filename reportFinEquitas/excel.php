<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN PEDAGANG / RESSELER.xls");
?>
<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><b style="font-size:20pt">LAPORAN PERUBAHAN MODAL / EKUITAS</b></center>
	<center><b style="font-size:14pt">UNTUK PERIODE <?php echo date("j M Y", strtotime($dateFrom)) ?> S/D <?php echo date("j M Y", strtotime($dateTo)) ?></b></center>
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
				<table width="100%" style="border:1px solid black" cellpadding="0" cellspacing="0">
					<thead>			
						<tr>
							<th style="padding:5px; border:1px solid black; font-size:12pt" align="center" width="5%">NO</th>
							<th style="padding:5px; border:1px solid black; font-size:12pt" align="center" width="17%">TANGGAL</th>						
							<th style="padding:5px; border:1px solid black; font-size:12pt" align="center" width="30%">ITEM</th>						
							<th style="padding:5px; border:1px solid black; font-size:12pt" align="center" width="15%">KREDIT</th>
							<th style="padding:5px; border:1px solid black; font-size:12pt" align="center" width="15%">DEBET</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $totalDanaMasuk = 0; ?>
						<?php $totalDanaKeluar = 0; ?>	
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>
								<td style="padding:5px; border:1px solid black; font-size:12pt" align="center"><?php echo $i ?></td>
								<td style="padding:5px; border:1px solid black; font-size:12pt" align="center" style="text-align:left; padding-left:5px">
									<?php echo $val['date_transaction_frm'] ?>
								</td>
								<td style="padding:5px; border:1px solid black; font-size:12pt" align="left">
									<?php echo $val['name'] ?>
								</td>							
								<td style="padding:5px; border:1px solid black; font-size:12pt" align="center">
									<?php if($val['tipe'] == '1'): ?>
										<?php echo number_format($val['nominal'],0,'','.')?>
									<?php endif; ?>
								</td>
								<td style="padding:5px; border:1px solid black; font-size:12pt" align="center">
									<?php if($val['tipe'] == '0'): ?>
										<?php echo number_format($val['nominal'],0,'','.')?>
									<?php endif; ?>
								</td>
							</tr>	
							<?php $i++; ?>		
							<?php if($val['tipe'] == '1'): ?>
								<?php $totalDanaMasuk = $totalDanaMasuk + $val['nominal']; ?>
							<?php endif; ?>		

							<?php if($val['tipe'] == '0'): ?>
								<?php $totalDanaKeluar = $totalDanaKeluar + $val['nominal']; ?>
							<?php endif; ?>							
						<?php endwhile; ?>
						<tr>
							<th style="padding:5px; border:1px solid black; font-size:12pt" align="center" colspan="3">TOTAL</th>
							<th style="padding:5px; border:1px solid black; font-size:12pt"><?php echo number_format($totalDanaMasuk,0,'','.')?></th>
							<th style="padding:5px; border:1px solid black; font-size:12pt" ><?php echo number_format($totalDanaKeluar,0,'','.')?></th>
						</tr>
						<tr>
							<th style="padding:5px; border:1px solid black; font-size:12pt" align="center" colspan="3">MODAL AKHIR</th>
							<th style="padding:5px; border:1px solid black; font-size:12pt" colspan="2" align="center"><?php echo number_format($totalDanaMasuk - $totalDanaKeluar,0,'','.')?></th>
						</tr>						
					<tbody>
				</table>			
			</div>
		<?php endif; ?>
	<?php endif; ?>		
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>
