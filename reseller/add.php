<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>TAMBAH RESELLER</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="23%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" style="width:205px" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">HANDPHONE</td>
				<td>
					<input name="countryCode" type="text"  size="1" value="<?php echo isset($_POST['countryCode']) ? $_POST['countryCode'] : '62' ?>" />
					<input name="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>" placeholder="87899609023" size="14" />
					<div style="color:red"><?php echo isset($msgError['countryCode']) ? $msgError['countryCode'] : '' ?></div>
					<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>					
				</td>
			</tr>
			<tr>
				<td valign="top">EMAIL</td>
				<td>
					<input name="email" type="text" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" placeholder="emailsaya@google.com" style="width:205px"  />
				</td>
			</tr>
			<tr>
				<td width="20%" valign="top">KOTA</td>
				<td>
					<input name="city" type="text" value="<?php echo isset($_POST['city']) ? $_POST['city'] : '' ?>" style="width:205px" />
				</td>
			</tr>
			<tr>
				<td valign="top">TIPE</td>
				<td>
					<select name="isDropshipper" style="width:205px;">
						<option value="0" <?php echo isset($_POST['isDropshipper']) ? $_POST['isDropshipper'] == '0'  ? 'selected' : '' : ''  ?>> Reseller Stok</option>
						<option value="1" <?php echo isset($_POST['isDropshipper']) ? $_POST['isDropshipper'] == '1'  ? 'selected' : '' : ''  ?>> Drophipper</option>
					</select>
				</td>
			</tr>	
			<tr>
				<td valign="top">STATUS AKTIF</td>
				<td>
					<select name="isActive" style="width:205px;">
						<option value="1" <?php echo isset($_POST['isActive']) ? $_POST['isActive'] == '1'  ? 'selected' : '' : ''  ?>> Aktif</option>
						<option value="0" <?php echo isset($_POST['isActive']) ? $_POST['isActive'] == '0'  ? 'selected' : '' : ''  ?>> Tidak Aktif</option>
					</select>					
				</td>
			</tr>	
		</table>
		<hr />
		<table width="100%">
			<tr>
				<td width="23%" valign="top">USERNAME</td>
				<td>
					<input name="username" type="text" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" style="width:205px" />
					<div style="color:red"><?php echo isset($msgError['username']) ? $msgError['username'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">PASSWORD</td>
				<td>
					<input name="password" type="text" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>" style="width:205px" />
					<div style="color:red"><?php echo isset($msgError['password']) ? $msgError['password'] : '' ?></div>
				<td>
			</tr>
		</table>	

		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
	</form>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
</table>
