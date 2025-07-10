<?php ob_start(); ?>
<?php include 'indexRead.php' ?>
	<h1>LAPORAN LABA RUGI</h1>
	<p style="font-size:16pt">TAHUN LAPORAN LABA - RUGI <?php echo $_REQUEST['year'] ?> </p> 
	
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
			<table width="100%" ="0" cellspacing="0" style="border:1px solid black">
				<thead>			
					<tr>
						<th style="border:1px solid black; font-size:12pt" align="center" width="20%">BULAN</th>
						<th style="border:1px solid black; font-size:12pt" align="center" width="%">TOTAL BIAYA</th>
						<th style="border:1px solid black; font-size:12pt" align="center" width="%">TOTAL PENDAPATAN</th>						
						<th style="border:1px solid black; font-size:12pt" align="center" width="%">LABA BERSIH</th>
					</tr>	
				</thead>
				<tbody>
					<?php $grandTotalBiaya = 0 ?>
					<?php $grandTotalPendapatan = 0 ?>
					<?php $grandTotalLabaBersih = 0 ?>
					
					<?php $i=1; ?>
					<?php $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td style="border:1px solid black; font-size:12pt" align="center"><?php echo $month[($val['month']-1)] ?></td>
							<td style="border:1px solid black; font-size:12pt" align="center"><?php echo number_format($val['total_expenses'],0,'','.') ?></td>
							<td style="border:1px solid black; font-size:12pt" align="center"><?php echo number_format($val['total_revenue'],0,'','.') ?></td>
							<td style="border:1px solid black; font-size:12pt" align="center">
								<?php if($val['profit'] >= 0): ?>
									<b><?php echo number_format($val['profit'],0,'','.') ?></b>
								<?php else: ?>
									<b style="color:red"><?php echo number_format($val['profit'],0,'','.') ?></b>
								<?php endif; ?>								
							</td>
						</tr>	
						<?php $grandTotalBiaya = $grandTotalBiaya + $val['total_expenses'] ?>
						<?php $grandTotalPendapatan = $grandTotalPendapatan + $val['total_revenue'] ?>
						<?php $grandTotalLabaBersih = $grandTotalLabaBersih + $val['profit'] ?>
					<?php $i++; ?>
					<?php endwhile; ?>
						<tr>
							<th style="border:1px solid black; font-size:12pt"  colspan="">GRAND TOTAL</th>
							<th style="border:1px solid black; font-size:12pt" ><?php echo number_format($grandTotalBiaya,0,'','.') ?></th>
							<th style="border:1px solid black; font-size:12pt" ><?php echo number_format($grandTotalPendapatan,0,'','.') ?></th>
							<th style="border:1px solid black; font-size:12pt" ><?php echo number_format($grandTotalLabaBersih,0,'','.') ?></th>
						</tr>		
				<tbody>
			</table>		
		</div>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>
