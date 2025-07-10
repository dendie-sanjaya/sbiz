<?php include 'editRead.php' ?>

<?php ob_start(); ?>
	<h1>UBAH PASSWORD</h1>
	<hr />
	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>
	
	<form action="editSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="25%">PASSWORD SEKARANG</td>
				<td>
					<input name="password" type="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['password']) ? $msgError['password'] : '' ?></div>
				</td>
			</tr>
		</table>
		<hr />
		<table width="100%">
			<tr>
				<td width="25%">PASSWORD BARU</td>
				<td>
					<input name="passwordNew" type="password" value="<?php echo isset($_POST['passwordNew']) ? $_POST['passwordNew'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['passwordNew']) ? $msgError['passwordNew'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td>KONFIRMASI PASSWORD BARU</td>
				<td>
					<input name="passwordNewConf" type="password" value="<?php echo isset($_POST['passwordNewConf']) ? $_POST['passwordNewConf'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['passwordNewConf']) ? $msgError['passwordNewConf'] : '' ?></div>
				</td>
			</tr>
		</table>
		<hr />
		<input type="submit" value="UBAH PASSWORD"/>
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
