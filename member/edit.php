<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
		<h1>EDIT MEMBER</h1>
		<hr />
		<form action="editSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />			
			<table width="100%">
				<tr>
					<td width="20%" valign="top">NAMA</td>
					<td>
						<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
						<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
					</td>
				</tr>
				<tr>
					<td valign="top">HANDPHONE</td>
					<td>
						<input name="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $data['phone'] ?>" />
					</td>
				</tr>
				<tr>
					<td>POSISI</td>
					<td>
						<select name="positionId" style="width:155px">
							<?php while($val = mysql_fetch_array($dataPosition)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['positionId']) ? $_REQUEST['positionId'] : $data['position_id'] ) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>
					</td>
				</tr>					
				<tr>
					<td>AKTIF</td>
					<td>
						<select name="aktif" style="width:155px">
							<option value="1" <?php echo isset($_REQUEST['aktif']) ? ($_REQUEST['aktif'] == '1') ? 'selected' : '' : (($data['is_enabled'] == '1') ? 'selected' : '') ?>>YA</option>
							<option value="0" <?php echo isset($_REQUEST['aktif']) ? ($_REQUEST['aktif'] == '0') ? 'selected' : '' : (($data['is_enabled'] == '0') ? 'selected' : '') ?>>TIDAK</option>
						</select>
					</td>
				</tr>
				<!--	
				<tr>
					<td valign="top">AKSES KATEGORI BARANG</td>
					<td>
						<select name="categoriId[]" style="width:200px; height:150px" multiple >
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo isset($_REQUEST['categoriId']) ? in_array($val['id'],$_REQUEST['categoriId'])  ? 'selected' : '' : in_array($val['id'],$dataExecutor) ? 'selected' : '' ?> ><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>
					</td>
				</tr>	
				-->	
			</table>
		<hr />
			<table width="100%">
				<tr>
					<td width="20%" valign="top">USERNAME</td>
					<td>
						<input name="usernameHidden" type="hidden" value="<?php echo $dataUser['username'] ?>" />
						<input name="username" type="text" value="<?php echo isset($_POST['username']) ? $_POST['username'] : $dataUser['username'] ?>" />
						<div style="color:red"><?php echo isset($msgError['username']) ? $msgError['username'] : '' ?></div>
					</td>
				</tr>
				<tr>
					<td valign="top">PASSWORD</td>
					<td>
						<input name="pwd" type="password" value="" />
						<div style="color:red"><?php echo isset($msgError['pwd']) ? $msgError['pwd'] : '' ?></div>
						<small>Kosongkan, apabila tidak akan mengubah password</small>
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
