<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
		<h1>EDIT SUPLIER</h1>
		<hr />
		<form action="editSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />			
			<table width="100%">
				<tr>
					<td width="15%" valign="top">NAMA</td>
					<td>
						<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
						<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
					</td>
				</tr>
				<tr>
					<td valign="top">KETERANGAN</td>
					<td valign="top">
						<textarea name="description" style="height:100px; width:210px"><?php echo isset($_POST['description']) ? $_POST['name'] : $data['description'] ?></textarea>
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
