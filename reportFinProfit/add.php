<?php ob_start(); ?>
<?php include 'addRead.php' ?>

	<h1>TERBITKAN LAPORAN LABA RUGI</h1>
	<hr />
	
	<?php if(isset($msgError['global'])): ?>
	 	<div class="error">
			<h3><?php echo $msgError['global'] ?></h3>
		</div>				
	<?php endif; ?>
		
	<form action="add.php" method="post" onsubmit="this.action='addSave.php'; this.submit()">
		<table width="100%">
			<tr>
				<td width="15%" valign="top">BULAN</td>
				<td width="15%" valign="top">
					<?php $thisMonth = date('m') ?>
					<select name="month" style="width:180px">
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
				<td width="8%" valign="top">&nbsp;&nbsp;&nbsp;TAHUN
				<td valign="top">
					<input name="year" type="number" value="<?php echo isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y') ?>" />
					<div style="color:red"><?php echo isset($msgError['year']) ? $msgError['year'] : '' ?></div>
				</td>												
			</tr>
			<tr>
				<td width="" valign="top">PERIODE</td>
				<td colspan="4">
					<textarea name="name" style="width:500px; height:40px"><?php echo isset($_POST['name']) ? $_POST['name'] : 'LAPORAN LABA RUGI BULAN '.strtoupper(date('F')).' TAHUN '.date('Y') ?></textarea>
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
		</table>
		<hr />
		<input type="submit" value="SIMPAN & LANJUTKAN PENERBITAN LAPORAN LABA RUGI"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?year=<?php echo $_REQUEST['year'] ?>'" />
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
