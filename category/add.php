<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>TAMBAH KATEGORI</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="20%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">SUB KATEGORI 1</td>
				<td>
					<input name="subCategory1" type="text" value="" />
				</td>
			</tr>
			<tr>
				<td valign="top">SUB KATEGORI 2</td>
				<td>
					<input name="subCategory2" type="text" value=""/>
				</td>
			</tr>
			<tr>
				<td valign="top">SUB KATEGORI 3</td>
				<td>
					<input name="subCategory3" type="text" value="" />
				</td>
			</tr>
		</table>
		<hr />
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
