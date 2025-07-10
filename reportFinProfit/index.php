<?php include 'indexRead.php' ?>
<?php include '../lib/connection.php' ?>

<?php ob_start(); ?>
	<h1>LAPORAN LABA RUGI</h1>
	<fieldset>
		<legend><b>FILTER<b></legend>	
			<form action="index.php" method="post" >					
				<table width="100%" border="0">
					<tr>
						<td valign="top">
							TAHUN LAPORAN LABA - RUGI &nbsp;&nbsp;   
							<select name="year" style="width:200px; height:30px">
								<?php while($val = mysql_fetch_array($cmbYear)): ?>
									<option value="<?php echo $val['year'] ?>" <?php echo $val['year'] == (isset($_REQUEST['year']) ? $_REQUEST['year'] : $year) ? 'selected' : '' ?>><?php echo $val['year'] ?></option>
								<?php endwhile; ?>
							</select>&nbsp;&nbsp;
							<input type="submit" value="FILTER" style="height:34px" />
						</td>
				</table>
			</form>	
	</fieldset>
	<br />
	
	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>
	<table width="100%">
		<tr>
			<td>
				<input type="button" value="TERBITKAN LAPORAN LABA RUGI" onclick="window.location='add.php?year=<?php echo $year ?>'" />
			</td>
			<td align="right">
				<input type="button" value="PRINT" onclick="window.open('print.php?year=<?php echo $year ?>')" />
				<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?year=<?php echo $year ?>')" />		
			</td>
		</tr>
	</table>	
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%">
				<thead>			
					<tr>
						<th align="center" width="20%">BULAN</th>
						<th align="center" width="%">TOTAL BIAYA</th>
						<th align="center" width="%">TOTAL PENDAPATAN</th>						
						<th align="center" width="%">LABA BERSIH</th>
						<th align="center" width="%"></th>
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
							<td align="center"><?php echo $month[($val['month']-1)] ?></td>
							<td align="center"><?php echo number_format($val['total_expenses'],0,'','.') ?></td>
							<td align="center"><?php echo number_format($val['total_revenue'],0,'','.') ?></td>
							<td align="center">
								<?php if($val['profit'] >= 0): ?>
									<b><?php echo number_format($val['profit'],0,'','.') ?></b>
								<?php else: ?>
									<b style="color:red"><?php echo number_format($val['profit'],0,'','.') ?></b>
								<?php endif; ?>								
							</td>
							<td align="center">
								<a href="edit.php?id=<?php echo $val['id'] ?>&year=<?php echo $year ?>" />[ DETAIL ] </a>
								<?php 
									$query = "select count(id) as total
											from fin_equitas
											where  fin_profit_loss_id = '{$val['id']}'";
									
									$tmpCek = mysql_query($query) or die (mysql_error());
									$aryCek = mysql_fetch_array($tmpCek);												
								?>
								<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>&year=<?php echo $year ?>' : false" />
							</td>
						</tr>	
						<?php $grandTotalBiaya = $grandTotalBiaya + $val['total_expenses'] ?>
						<?php $grandTotalPendapatan = $grandTotalPendapatan + $val['total_revenue'] ?>
						<?php $grandTotalLabaBersih = $grandTotalLabaBersih + $val['profit'] ?>
					<?php $i++; ?>
					<?php endwhile; ?>
						<tr>
							<th colspan="">GRAND TOTAL</th>
							<th><?php echo number_format($grandTotalBiaya,0,'','.') ?></th>
							<th><?php echo number_format($grandTotalPendapatan,0,'','.') ?></th>
							<th><?php echo number_format($grandTotalLabaBersih,0,'','.') ?></th>
							<th></th>
						</tr>		
				<tbody>
			</table>		
		</div>
	<?php endif; ?>
	
<?php include '../lib/connection-close.php' ?> 	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
