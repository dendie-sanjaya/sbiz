<?php ob_start(); ?>
	<?php include 'addRead.php' ?>

	<h1>TAMBAH BARANG BUNDLING</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td width="30%">KATEGORI</td>
				<td>
					<select name="categoryId">
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
					<div style="color:red"><?php echo isset($msgError['categoryId']) ? $msgError['categoryId'] : '' ?></div>
				</td>
			</tr>
			<tr>			
				<td valign="top">NAMA BARANG BUNDLING</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>			
				<td valign="top">HARGA MININUM BUNDLING</td>
				<td>
					<input name="priceMin" type="text" value="<?php echo isset($_POST['priceMin']) ? $_POST['priceMin'] : '0' ?>" />
					<div style="color:red"><?php echo isset($msgError['priceMin']) ? $msgError['priceMin'] : '' ?></div>
				</td>
			</tr>
			<tr>			
				<td valign="top">KOMISI SALES</td>
				<td>
					<input name="feeSales" type="text" value="<?php echo isset($_POST['feeSales']) ? $_POST['feeSales'] : '0' ?>" />
					<div style="color:red"><?php echo isset($msgError['feeSales']) ? $msgError['feeSales'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td>SEMBUNYIKAN</td>
				<td>
					<select name="isHidden" style="width: 95px">
						<option value="0" <?php echo 0 == isset($_POST['isHidden']) ? $_POST['isHidden'] : ''  ? 'selected' : '' ?>>Tidak</option>
						<option value="1" <?php echo 1 == isset($_POST['isHidden']) ? $_POST['isHidden'] : ''  ? 'selected' : '' ?>>Ya</option>
					</select>
					<small style="margin-top: 20px"><i>Sembunyikan, agar tidak tampil dipilih menu penjualan</i></small>
				</td>
			</tr>

		</table>
		<hr />
		<input type="submit" value="SIMPAN & LANJUTKAN MEMILIH BARANG"/>
		<input type="button" value="BATAL" onclick="window.location='index.php'" />
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
