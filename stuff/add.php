<?php ob_start(); ?>
	<?php include 'addRead.php' ?>
	<h1>TAMBAH BARANG</h1>
	<hr />

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>
	
	<form action="addSave.php" method="post" id="frm">
		<table width="100%">
			<tr>
				<td width="30%">KATEGORI</td>
				<td>
					<select name="categoryId" style="width:90%" onchange="window.location='add.php?id=<?php echo $id ?>&categoryId='+this.value">
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : $dataCopy['category_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
					<div style="color:red"><?php echo isset($msgError['categoryId']) ? $msgError['categoryId'] : '' ?></div>
				</td>
			</tr>
			<?php $i = 1 ?>
			<?php while($row = mysql_fetch_array($dataSubCategory)): ?>
				<tr>
					<td valign="top">SUB KATEGORI <?php echo strtoupper($row['name']) ?></td>
					<td>
						<input name="idSubCategory<?php echo $i ?>" type="hidden" value="<?php echo $row['id'] ?>" />							
						<input name="subCategory<?php echo $i ?>" type="text" value="<?php echo isset($_POST['subCategory'.$i]) ? $_POST['subCategory'.$i] : $row['row_name']  ?>" />
					</td>
				</tr>
				<?php $i++ ?>					
			<?php endwhile; ?>			
			<tr>			
				<td valign="top">SKU</td>
				<td>
					<input style="width: 90%; text-transform: uppercase;" name="sku" type="text" value="<?php echo isset($_POST['sku']) ? $_POST['sku'] : $dataCopy['sku'] ?>" />
					<div style="color:red"><?php echo isset($msgError['sku']) ? $msgError['sku'] : '' ?></div>
				</td>
			</tr>
			<tr>			
				<td valign="top">NAMA BARANG</td>
				<td>
					<input style="width: 90%" name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $dataCopy['name'] ?>" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>			
				<td valign="top">DESKRIPSI PRODUK</td>
				<td>
					<input style="width: 90%" name="nickname" type="text" value="<?php echo isset($_POST['nickname']) ? $_POST['nickmane'] : $dataCopy['nickname'] ?>" />
					<div style="color:red"><?php echo isset($msgError['nickname']) ? $msgError['nickname'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">STOK AWAL</td>
				<td>
					<input name="stock" type="text" value="<?php echo isset($_POST['stock']) ? $_POST['stock'] : $dataCopy['stock'] ?>"  size="2" />
					<div style="color:red"><?php echo isset($msgError['stock']) ? $msgError['stock'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">STOK MINIMUM</td>
				<td>
					<input name="stockMinAlert" type="text" value="<?php echo isset($_POST['stockMinAlert']) ? $_POST['stockMinAlert'] : $dataCopy['stock_min_alert'] ?>" size="2" />
					<small>Stok minimun adalah sebuah pemberitahuan yang akan dilaporan oleh sistem apabila persedian akan habis</small>
					<div style="color:red"><?php echo isset($msgError['stockMinAlert']) ? $msgError['stockMinAlert'] : '' ?></div>
					
				</td>
			</tr>
			<tr>
				<td valign="top">HARGA JUAL</td>
				<td>
					<input name="price" type="text" value="<?php echo isset($_POST['price']) ? $_POST['price'] : $dataCopy['price'] ?>" size="6" />
					<small>Contoh: 25000</small>
					<div style="color:red"><?php echo isset($msgError['price']) ? $msgError['price'] : '' ?></div>
					
				</td>
			</tr>
			<tr>
				<td valign="top">HARGA DASAR</td>
				<td>
					<input name="priceBasic" type="text" value="<?php echo isset($_POST['priceBasic']) ? $_POST['priceBasic'] : $dataCopy['price_basic'] ?>" size="6" />
					<small>Contoh: 25000</small>
					<div style="color:red"><?php echo isset($msgError['priceBasic']) ? $msgError['priceBasic'] : '' ?></div>
					
				</td>
			</tr>	
			<tr>
				<td valign="top">KOMISI SALES</td>
				<td>
					<input name="feeSales" type="text" value="<?php echo isset($_POST['feeSales']) ? $_POST['feeSales'] : $dataCopy['fee_sales'] ?>" size="6" />
					<small>Contoh: 2500</small>
					<div style="color:red"><?php echo isset($msgError['feeSales']) ? $msgError['feeSales'] : '' ?></div>					
				</td>
			</tr>	
			<tr>
				<td valign="top">BIAYA CS</td>
				<td>
					<input name="costCs" type="text" value="<?php echo isset($_POST['costCs']) ? $_POST['costCs'] : $dataCopy['cost_cs'] ?>" size="6" />
					<small>Contoh: 2500</small>
				</td>
			</tr>
			<tr>
				<td valign="top">BIAYA OPERATION / PACKING</td>
				<td>
					<input name="costOps" type="text" value="<?php echo isset($_POST['costOps']) ? $_POST['costOps'] : $dataCopy['cost_ops'] ?>" size="6" />
					<small>Contoh: 2500</small>					
				</td>
			</tr>
			<tr>
				<td valign="top">BIAYA RISET</td>
				<td>
					<input name="costRiset" type="text" value="<?php echo isset($_POST['costRiset']) ? $_POST['costRiset'] : $dataCopy['cost_riset'] ?>" size="6" />
					<small>Contoh: 2500</small>					
				</td>
			</tr>
			<tr>
				<td valign="top">BIAYA ADVERTISING</td>
				<td>
					<input name="costAdv" type="text" value="<?php echo isset($_POST['costAdv']) ? $_POST['costAdv'] : $dataCopy['cost_adv'] ?>" size="6" />
					<small>Contoh: 2500</small>					
				</td>
			</tr>										
			<tr>
				<td>SATUAN PERSEDIAAN</td>
				<td>
					<select name="constId">
						<?php while($val = mysql_fetch_array($data)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_POST['constId']) ? $_POST['constId'] : $dataCopy['const_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>LOKASI PENYIMPANAN</td>
				<td>
					<select name="locationId">
						<?php while($val = mysql_fetch_array($dataLocation)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo ($val['id'] == isset($_POST['locationId']) ? $_POST['locationId'] : $dataCopy['location_id']) ? 'selected' : '' ?> ><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>SEMBUNYIKAN</td>
				<td>
					<select name="isHidden" style="width: 95px">
						<option value="0" <?php echo 0 == isset($_POST['isHidden']) ? $_POST['isHidden'] : $dataCopy['is_hidden']  ? 'selected' : '' ?>>Tidak</option>
						<option value="1" <?php echo 1 == isset($_POST['isHidden']) ? $_POST['isHidden'] : $dataCopy['is_hidden']  ? 'selected' : '' ?>>Ya</option>
					</select>
					<small style="margin-top: 20px"><i>Sembunyikan, agar tidak tampil dipilih menu penjualan</i></small>
				</td>
			</tr>

		</table>
		<hr />
		<input type="submit" value="SIMPAN" name="submit"/>
		<input type="submit" value="SIMPAN & SALIN" name="submitCopy"/>
		<input type="button" value="BATAL" onclick="window.location='index.php'" />
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
