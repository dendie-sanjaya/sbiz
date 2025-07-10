<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>TAMBAH PLATFORM MARKET</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="20%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="" style="width: 200px" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">MARKETPLACE</td>
				<td valign="top">
					<select name="isMarketplace" style="width: 200px" >
						<option value="0">Tidak</option>
						<option value="1">Ya</option>
					</select>
				</td>
			</tr>			
			<tr>
				<td  valign="top">BIAYA ADMIN</td>
				<td>
					<input name="fee_admin_percent" type="text" value="0" style="width: 50px"  />%
					<div style="color:red"><?php echo isset($msgError['fee_admin_percent']) ? $msgError['fee_admin_percent'] : '' ?></div>
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
