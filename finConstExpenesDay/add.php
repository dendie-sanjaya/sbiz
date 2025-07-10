<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>TAMBAH KOMPONEN PENGELUARAN HARIAN</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="35%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="" style="width: 200px" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">TAMPILKAN DI LAPORAN KONVERSI IKLAN</td>
				<td valign="top">
					<select name="isShowReport" style="width: 200px">
						<option value="0">Tidak Sertakan</option>
						<option value="1">Di Sertakan</option>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">DEFAULT NOMINAL</td>
				<td valign="top">
					<input name="nominal" type="text" value="0"  style="width: 200px"/>
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
