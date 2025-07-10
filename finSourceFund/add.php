<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>TAMBAH SUMBER PENDANAAN</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="15%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="" style="width: 350px" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">NOMOR REKENING</td>
				<td>
					<input name="accountNumber" type="text" value="" style="width: 350px" />
					<div style="color:red"><?php echo isset($msgError['account_number']) ? $msgError['account_number'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">KETERANGAN</td>
				<td valign="top">
					<textarea name="description" style="height:100px; width:350px"></textarea>
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
