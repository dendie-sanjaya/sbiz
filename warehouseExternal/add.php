<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>GUDANG 	ESKTERNAL</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="15%" valign="top">KODE</td>
				<td>
					<input name="code" type="text" value="<?php echo isset($_POST['code']) ? $_POST['code'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['code']) ? $msgError['code'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td width="15%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">ALAMAT</td>
				<td valign="top">
					<textarea name="address" style="height:150px; width:410px"><?php echo isset($_POST['address']) ? $_POST['address'] : '' ?></textarea>
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
