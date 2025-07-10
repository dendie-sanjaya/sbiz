<?php include 'indexRead.php' ?>

<?php ob_start(); ?>
	<h1  style="text-align:center">APPLIKASI BIZ</h1>
	<hr />
	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="error" style="width:380px">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>
	<form action="signin.php" method="post">
		<table width="300px" align="center">
			<tr>
				<td width="140">USER NAME</td>
				<td><input type="text" name="username" value="" size="18" /></td>
			</tr>
			<tr>
				<td>PASSWORD</td>
				<td><input type="password" name="password" value="" size="18" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="LOGIN" /></td>
			</tr>
		</table>
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/login.php' ?>
