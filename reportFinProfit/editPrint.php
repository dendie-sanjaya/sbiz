	<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
	<center style="font-size:30px; padding:5px"><b>LAPORAN LABA RUGI</b></center>
	<?php $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') ?>
	<center style="font-size:20px;  padding:5px"><b>PERIODE <?php echo strtoupper($month[$dataHeader['month'] - 1]) ?> <?php echo $dataHeader['year'] ?></b></center>
	<center style="font-size:15px;  padding:5px"><b><?php echo $dataHeader['name'] ?></b></center>
	<hr style="border:1px solid black" />
	<hr style="border:2px solid black" />
	<br />
	<?php $totalExpenses = 0 ?>
	<?php $totalExpensesPerhari  = 0 ?>
	<?php $totalExpensesPerbulan = 0 ?>
	<?php $totalRevenue = 0 ?>
	<table width="100%" border="0" cellpadding="5" cellspacing="5">
		<tr id="listRevenue">
			<td width="30%" style="font-size:18px; padding:5px" colspan="4"><b>PENDAPATAN</b></td>
			<td	>&nbsp;</td>
		</tr>
		<?php while($dataRevenue = mysql_fetch_array($revenue)): ?>	
		<tr>
			<td width="53%" style="font-size:16px; padding:5px 5px 5px 25px " align="left">
				<?php echo $dataRevenue['name'] ?>
				<?php if($dataRevenue['fin_expenses_revenue_id'] == '13'): ?>
					<br /><small style="font-size:10px"><i><?php echo $dataRevenue['description'] ?></i></small>
				<?php endif; ?>
			</td>
			<td width="5%" width="%">&nbsp;</td>
			<td width="15%" style="font-size:16px;" align="right">
				<b><?php echo number_format($dataRevenue['nominal'],0,'','.')  ?></b>				
			</td>	
			<td width="20%">&nbsp;</td>
		</tr>
		<?php $totalRevenue = $totalRevenue + $dataRevenue['nominal'] ?>
		<?php endwhile; ?>	
		<tr>
			<td colspan="4" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
			<td style="font-size:16px;" align="right"><b><?php echo number_format($totalRevenue,0,'','.') ?></b></td>
		</tr>			

		<tr id="listExpenses">	
			<td width="30%" style="font-size:18px; padding:5px" colspan="4"><b>BIAYA KELOMPOK PERHARI</b></td>
			<td	>&nbsp;</td>
		</tr>
		<?php while($dataExpenses = mysql_fetch_array($expensesPerhari)): ?>	
		<tr>
			<td colspan="2" style="font-size:16px; padding:5px 5px 5px 25px ">
				<?php echo $dataExpenses['name'] ?>
			</td>
			<td  style="font-size:16px;" align="right">
				<b><?php echo number_format($dataExpenses['nominal'],0,'','.') ?></b>
			</td>
			<td>&nbsp;</td>
		</tr>
		<?php $totalExpenses = ($totalExpenses + $dataExpenses['nominal']) ?>
		<?php $totalExpensesPerhari = ($totalExpensesPerhari + $dataExpenses['nominal']) ?>

		<?php endwhile; ?>	
		<tr>
			<td colspan="4" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
			<td style="font-size:16px;" align="right"><b><?php echo number_format($totalExpenses,0,'','.') ?></b></td>
		</tr>			

		<tr>
			<td colspan="5" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
		</tr>			

		<tr id="listExpenses">	
			<td width="30%" style="font-size:18px; padding:5px; margin-top:40px" colspan="4"><b>BIAYA KELOMPOK PERBULAN</b></td>
			<td	>&nbsp;</td>
		</tr>

		<?php while($dataExpenses = mysql_fetch_array($expensesPerbulan)): ?>	
			<tr>
				<td colspan="2" style="font-size:16px; padding:5px 5px 5px 25px "><?php echo $dataExpenses['name'] ?>
				</td>
				<td  style="font-size:16px;" align="right">
					<b><?php echo number_format($dataExpenses['nominal'],0,'','.') ?></b>
				</td>
				<td>&nbsp;</td>
			</tr>
		<?php $totalExpenses = ($totalExpenses + $dataExpenses['nominal']) ?>
		<?php $totalExpensesPerbulan = ($totalExpensesPerbulan + $dataExpenses['nominal']) ?>
		<?php endwhile; ?>	

		<tr>
			<td colspan="4" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
			<td style="font-size:16px;" align="right"><b><?php echo number_format($totalExpensesPerbulan,0,'','.') ?></b></td>
		</tr>			

		<tr>
			<td colspan="5" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
		</tr>			

		<tr>	
			<td style="font-size:18px" colspan="3"><b>LABA BERSIH <small>(Pendapatan - Biaya)</small></b></td>
			<td style="font-size:16px;" align="right">&nbsp;</td>
			<td style="font-size:20px" style="" align="right" >
				<?php $labaBersih = $totalRevenue-$totalExpenses ?>
				<?php if($labaBersih >= 0): ?>
					<b><?php echo number_format($totalRevenue-$totalExpenses,0,'','.') ?></b>
				<?php else: ?>
					<b style="color:red"><?php echo number_format($totalRevenue-$totalExpenses,0,'','.') ?></b>
				<?php endif; ?>	
			</td>				
		</tr>
	</table>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>
