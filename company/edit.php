<?php ob_start(); ?>
	<?php include 'editRead.php' ?>

		<?php if(isset($_GET['msg'])) : ?>
			<div class="info">
				<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
			</div>		
		<?php endif ?>
	
		<h1>IDENTITAS TOKO</h1>
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
					<td valign="top">TELEPON</td>
					<td>
						<input name="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $data['phone'] ?>" />
						<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
					</td>
				</tr>
				<tr>
					<td valign="top">ALAMAT</td>
					<td valign="top">
						<textarea name="address" style="height:100px; width:350px"><?php echo isset($_POST['address']) ? $_POST['address'] : $data['address'] ?></textarea>
					</td>
				</tr>
			</table>
			<hr />
			<input type="submit" value="SIMPAN"/>
		</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
