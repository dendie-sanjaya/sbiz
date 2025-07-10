<?php ob_start(); ?>
<?php include 'editRead.php' ?>
<h1>EDIT BARANG BUNDLING</h1>
<hr />
<form action="editSave.php" method="post" enctype="multipart/form-data">
	<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />		
	<table width="100%">
		<tr>
			<td width="30%">KATEGORI</td>
			<td>
				<select name="categoryId" >
					<?php while($val = mysql_fetch_array($dataCategory)): ?>
						<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : $data['category_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
					<?php endwhile; ?>
				</select>			
				<div style="color:red"><?php echo isset($msgError['categoryId']) ? $msgError['categoryId'] : '' ?></div>	
			</td>
		</tr>		
		<tr>
			<td width="20%" valign="top">NAMA BARANG</td>
			<td>
				<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
				<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
			</td>
		</tr>			
		<tr>
			<td width="20%" valign="top">HARGA BUNDLING</td>
			<td>
				<div id="divHargaBundlingLabel" style="height: 25px; font-weight: bold"><?php echo number_format($data['price'],0,'','.') ?></div>
			</td>
		</tr>			
		<tr>
			<td width="20%" valign="top">KOMISI SALES</td>
			<td>
				<div id="divHargaBundlingLabel" style="height: 25px; font-weight: bold"><?php echo number_format($data['fee_sales'],0,'','.') ?></div>
			</td>
		</tr>			
		<tr>
			<td>SEMBUNYIKAN</td>
			<td>
				<select name="isHidden" style="width: 95px">
					<option value="0" <?php echo 0 == isset($_POST['isHidden']) ? $_POST['isHidden'] : $data['is_hidden']  ? 'selected' : '' ?>>Tidak</option>
					<option value="1" <?php echo 1 == isset($_POST['isHidden']) ? $_POST['isHidden'] : $data['is_hidden']  ? 'selected' : '' ?>>Ya</option>
				</select>
				<small style="margin-top: 20px"><i>Sembunyikan, agar tidak tampil dipilih menu penjualan</i></small>
			</td>
		</tr>			
	</table>
	<br />
	<hr />
	<div>
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php'" />
	</div>
</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
