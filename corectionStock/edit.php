<?php ob_start(); ?>
<?php include 'editRead.php' ?>

	<h1>KOREKSI STOK</h1>
	<hr />
	<form action="editSave.php" method="post" enctype="multipart/form-data">
		<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />		
		<input name="name" type="hidden" value="<?php echo $data['name'] ?>" />	
		<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword'] ?>" />
		<input name="categoryId" type="hidden" value="<?php echo $data['category_id'] ?>" />		

		<table width="100%">
			<tr>
				<td width="20%" valign="top">KATEGORI</td>
				<td>
					<b><?php echo $data['category_name'] ?>
				</td>
			</tr>		
			<tr>
				<td width="25%" valign="top">NAMA BARANG</td>
				<td>
					<b><?php echo $data['name'] ?> (<?php echo $data['nickname'] ?>)</b>
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
				<td>KOREKSI SISA STOK MENJADI</td>
				<td>
					<input name="stock" type="text" value="<?php echo isset($_POST['stock']) ? $_POST['stock'] : $data['stock'] ?>"  size="2" />
					<?php echo $data['const_name'] ?>
					<div style="color:red"><?php echo isset($msgError['stock']) ? $msgError['stock'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">KETERANGAN</td>
				<td>
					<textarea name="description" style="width:350px; height:80px"></textarea>
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
	</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
