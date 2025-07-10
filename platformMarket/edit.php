<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
		<h1>EDIT PLATFORM MARKET</h1>
		<hr />
		<form action="editSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />			
			<table width="100%">
				<tr>
					<td width="20%" valign="top">NAMA</td>
					<td>
						<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" style="width: 200px" />
						<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
					</td>
				</tr>
			<tr>
				<td  valign="top">BIAYA ADMIN</td>
				<td>
					<input name="fee_admin_percent" type="text" value="<?php echo isset($_POST['fee_admin_percent']) ? $_POST['fee_admin_percent'] : $data['fee_admin_percent'] ?>" style="width: 50px"  />%
					<div style="color:red"><?php echo isset($msgError['fee_admin']) ? $msgError['fee_admin'] : '' ?></div>
				</td>
			</tr>				
				<tr>
					<td valign="top">MARKETPLACE</td>
					<td valign="top">
						<select name="isMarketplace" style="width: 200px" >
							<option value="0" <?php echo (isset($_POST['isMarketplace']) ? $_POST['isMarketplace'] : $data['is_marketplace']) == '0' ? 'selected' : '' ?>>Tidak</option>
							<option value="1" <?php echo (isset($_POST['isMarketplace']) ? $_POST['isMarketplace'] : $data['is_marketplace']) == '1' ? 'selected' : '' ?>>Ya</option>
						</select>
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
