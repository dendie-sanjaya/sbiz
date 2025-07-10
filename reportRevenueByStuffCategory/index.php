<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>LAPORAN PENJUALAN BARANG BERDASARKAN KATEGORI</h1>
	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="post">
			<table width="100%">
				<tr>
					<td width="15%" valign="top">BULAN</td>
					<td width="30%" valign="top">
						<?php $thisMonth = date('m') ?>
						<select name="month" style="width:100%">
							<option value="1" <?php echo '1' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Januari</option>
							<option value="2" <?php echo '2' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Februari</option>
							<option value="3" <?php echo '3' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Maret</option>
							<option value="4" <?php echo '4' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>April</option>
							<option value="5" <?php echo '5' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Mei</option>
							<option value="6" <?php echo '6' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Juni</option>
							<option value="7" <?php echo '7' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Juli</option>
							<option value="8" <?php echo '8' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Agustus</option>
							<option value="9" <?php echo '9' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>September</option>
							<option value="10" <?php echo '10' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Oktober</option>
							<option value="11" <?php echo '11' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>November</option>
							<option value="12" <?php echo '12' == (isset($_REQUEST['month']) ? $_REQUEST['month'] : $thisMonth) ? 'selected' : '' ?>>Desember</option>
						</select>
					</td>
					<td width="13%" valign="top">&nbsp;&nbsp;&nbsp;TAHUN
					<td valign="top">
						<input name="year" type="number" value="<?php echo isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y') ?>" style="height: 30px; text-align: center; width: 100%"  />
						<div style="color:red"><?php echo isset($msgError['year']) ? $msgError['year'] : '' ?></div>	
					</td>												
				</tr>
				<tr  >
				  <td colspan="4">
				  	KATEGORI BARANG<br style="margin-bottom: 20px; margin-top: 30px" />
					<select name="categoryId[]" style="width:100%;">
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option <?php echo in_array($val['id'],$categoryId) ? ' selected ' : '' ?> value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
				  </td>	
				</tr>	
				</tr>	
					<td valign="bottom" valign="top" colspan="4">
						<input type="submit" value="FILTER" style="width: 100%; margin-left: -2px" />
					</td>					
				</tr>
			</table>
		</form>
	</fieldset>

	<br />

	<?php if(!isset($_REQUEST['month'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('filterData') ?></h3>
		</div>		
	<?php else: ?>	
		<?php if(mysql_num_rows($data) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
		 	<div class="info">
				<h3>Laporan ini adalah penjualan yang status penjualannya <b>Sudah Selesai</b> dan <b>Sudah Bayar</b> </h3>
			</div>		

			<p style="margin-bottom: 35px; margin-top: 35px; padding: 0px">
				<input style="width: 100%;"  type="button" value="PRINT LAPORAN" onclick="window.open('print.php?categoryIdChoose=<?php echo $categoryIdChoose ?>&isReseller=<?php echo $_REQUEST['isReseller'] ?>&tipeOrder=<?php echo $_REQUEST['tipeOrder'] ?>&year=<?php echo urlencode($_REQUEST['year']) ?>&month=<?php echo urlencode($_REQUEST['month']) ?>')" />
			</p>	

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
		<?php endif; ?>
	<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
