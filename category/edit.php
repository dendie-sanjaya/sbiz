<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
		<h1>EDIT KATEGORI</h1>
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
				<?php $i = 1 ?>
				<?php while($row = mysql_fetch_array($dataSubCategory)): ?>
					<tr>
						<td valign="top">SUB KATEGORI <?php echo $i ?></td>
						<td>
							<input name="idSubCategory<?php echo $i ?>" type="hidden" value="<?php echo $row['id'] ?>" />							
							<input name="subCategory<?php echo $i ?>" type="text" value="<?php echo isset($_POST['subcategory'.$i]) ? $_POST['subcategory'.$i] : $row['name']  ?>" />
						</td>
					</tr>
					<?php $i++ ?>					
				<?php endwhile; ?>	
			</table>
			<hr />
			<input type="submit" value="SIMPAN"/>
			<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
		</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
