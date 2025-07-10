<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
		<h1>EDIT KOMPONEN PENGELUARAN HARIAN</h1>
		<hr />
		<form action="editSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />			
			<table width="100%">
				<tr>
					<td width="35%" valign="top">NAMA</td>
					<td>
						<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
						<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
					</td>
				</tr>
				<tr>
					<td valign="top">TAMPILKAN DI LAPORAN KONVERSI IKLAN <?php echo $data['is_show_report_convertion_adds'] ?></td>
					<td valign="top">
						<select name="isShowReport" style="width: 200px">
							<option value="0" <?php echo (isset($_POST['isShowReport']) ? $_POST['isShowReport'] : $data['is_show_report_convertion_adds']) == '0' ? 'selected' : '' ?>>Tidak Sertakan</option>
							<option value="1" <?php echo (isset($_POST['isShowReport']) ? $_POST['isShowReport'] : $data['is_show_report_convertion_adds']) == '1' ? 'selected' : '' ?>>Di Sertakan</option>
						</select>
					</td>
				</tr>				
				<tr>
					<td valign="top">DEFAULT NOMINAL</td>
					<td valign="top">
						<input name="nominal" type="text" value="<?php echo isset($_POST['nominal']) ? $_POST['nominal'] : $data['nominal'] ?>" />
					</td>
				</tr>
			</table>
			<hr />
			<input type="submit" value="SIMPAN"/>
			<input type="button" value="BATAL" onclick="window.location='index.php'" />
		</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
