<?php ob_start(); ?>
<?php include 'editRead.php' ?>

	<h1>TRANSAKSI BARANG</h1>
	<hr />
	<form action="editSave.php" method="post" enctype="multipart/form-data">
		<input name="categoryId" type="hidden" value="<?php echo $data['category_id'] ?>" />	
		<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />		
		<input name="name" type="hidden" value="<?php echo $data['name'] ?>" />		
		<input name="price" type="hidden" value="<?php echo $data['price'] ?>" />
		<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword'] ?>" />
		<table width="100%" class="tableTransaction">
			<tr>
				<td width="25%" valign="top">KATEGORI</td>
				<td>
					<b><?php echo $data['category_name'] ?>
				</td>
			</tr>
			<tr>
				<td width="20%" valign="top">NAMA BARANG</td>
				<td>
					<b><?php echo $data['name'] ?> (<?php echo $data['nickname'] ?>) </b>
				</td>
			</tr>
			<tr>
				<td>TGL TRANSAKSI</td>
				<td>
					<input name="dateTransaction" type="text" id="dateTransaction" size="5" readonly  style="width:155px"/>
					<div style="color:red"><?php echo isset($msgError['dateTransaction']) ? $msgError['dateTransaction'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td>JENIS TRANSAKSI</td>
				<td>
					<select name="type" style="width:155px" onchange="cmbTransaction(this.value)">
						<option value="0" <?php echo isset($_REQUEST['type']) ? $_REQUEST['type'] == 0 ? 'selected' : '' : 'selected'  ?>>BARANG KELUAR</option>
						<option value="1" <?php echo isset($_REQUEST['type']) ? $_REQUEST['type'] == 1 ? 'selected' : '' : ''  ?>>BARANG MASUK</option>
					</select>
				</td>
			</tr>
			<tr id="trSuplier">
				<td>PEMASOK</td>
				<td>
					<select name="suplierId" style="width:155px">
						<?php while($val = mysql_fetch_array($dataSuplier)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_POST['suplierId']) ? $_POST['suplierId'] : $data['suplier_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</td>
			</tr>
			<tr id="trClient">
				<td>KATEGORI PELANGGAN</td>
				<td>
					<select name="clientId" style="width:155px">
						<?php while($val = mysql_fetch_array($dataClient)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_POST['clientId']) ? $_POST['clientId'] : $data['client_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>SISA STOK</td>
				<td>
					<b>
						<?php echo $data['stock'] ?>
						<?php echo $data['const_name'] ?>
					</b>
				</td>
			</tr>
			<tr>
				<td>JUMLAH</td>
				<td>
					<input name="stock" type="text" value="<?php echo isset($_POST['stock']) ? $_POST['stock'] : 1 ?>"  size="2" />
					<?php echo $data['const_name'] ?>
					<div style="color:red"><?php echo isset($msgError['stock']) ? $msgError['stock'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">KETERANGAN</td>
				<td>
					<textarea name="description" style="width:350px; height:80px"><?php echo isset($_POST['description']) ? $_POST['description'] : '' ?></textarea>
				</td>
			</tr>

		</table>
		<hr />
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?categoryId=<?php echo $data['category_id'] ?>&keyword=<?php echo $_REQUEST['keyword'] ?>'" />
	</form>

	<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateTransaction" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = strlen(trim($_REQUEST['dateTransaction'])) == 0 ?  '' : explode('/',$_REQUEST['dateTransaction']) ?>
				$("#dateTransaction" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});
	});

	function cmbTransaction(pValue) {
          $('#trSuplier').hide();
          $('#trClient').hide();

  	  if(pValue == 0) {
	     $('#trClient').toggle()
	  } else {
	     $('#trSuplier').toggle();
	  }		
	}

	cmbTransaction(<?php echo isset($_REQUEST['type']) ? $_REQUEST['type'] : 0  ?>);	
	</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
