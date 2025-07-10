<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center style="font-size:20px; padding:5px"><b>LAPORAN PENJUALAN</b></center>
	<?php $monthStr = array('Januari', 'Februari', 'Maret', 'April', 'Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') ?>			
	<center style="font-size:25px;  padding:5px"><b>KATEGORI BARANG <?php echo strtoupper($dataCategoryPrint['name']) ?></b></center>
	<center style="font-size:20px;  padding:5px"><b>PERIODE <?php echo strtoupper($monthStr[$month-1]) ?> <?php echo $year ?></b></center>
	<hr style="border:1px solid black" />
	<hr style="border:2px solid black" />

	<table width="100%" style="margin-top:30px">
		<thead>			
			<tr style="height: 40px; ">
				<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black" align="center" width="5%">NO</th>
				<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black" align="left" width="%">NAMA BARANG</th>						
				<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black" align="center" width="%">BRG TERJUAL</th>
				<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black" align="center" width="%">JML HARGA DASAR</th>						
				<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black" align="center" width="%">JML NILAI TERJUAL</th>						
				<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black" align="center" width="%">JML LABA</th>
			</tr>	
		</thead>
		<tbody>
			<?php $i=1; ?>
			<?php $totalNilaiJual = 0; ?>
			<?php $totalNilaiBasic = 0; ?>
			<?php $totalNilaiProfit = 0; ?>
			<?php while($val = mysql_fetch_array($data)): ?>
				<tr style="height: 40px; font-size:14px">
					<td align="center"><?php echo $i ?></td>
					<td align="left">
						<?php echo $val['stuff_name'] ?><br />
						<span style="font-size:10px"><?php echo $val['nickname'] ?></span>
					</td>
					<td align="center"><?php echo $val['amount_total'] ?> <?php echo $val['satuan'] ?></td>
					<td align="center"><?php echo number_format($val['price_total_basic'],0,'','.') ?></td>							
					<td align="center"><?php echo number_format($val['price_total'],0,'','.') ?></td>							
					<td align="center">
						<?php $laba = ($val['price_total'] - $val['price_total_basic']) ?>
						<?php echo number_format($laba,0,'','.') ?>									
					</td>							
				<?php $totalNilaiJual = $totalNilaiJual + $val['price_total'] ?>
				<?php $totalNilaiBasic = $totalNilaiBasic + $val['price_total_basic'] ?>
				<?php $totalNilaiProfit = $totalNilaiProfit + $laba ?>
				<?php $i++; ?>
			<?php endwhile; ?>
		<tbody>
		<tr>
			<th colspan="3" align="left" style="height: 40px; font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black">GRAND TOTAL</th>
			<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black"><?php echo number_format($totalNilaiBasic,0,'','.') ?></th>
			<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black"><?php echo number_format($totalNilaiJual,0,'','.') ?></th>
			<th style="font-size:14px; border-bottom: 2px solid black; border-top: 2px solid black"><?php echo number_format($totalNilaiProfit,0,'','.') ?></th>
			<th></th>
		</tr>	
	</table>			
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
