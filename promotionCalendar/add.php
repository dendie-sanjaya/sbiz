<?php ob_start(); ?>
<?php include 'addRead.php' ?>
	<h1>TAMBAH KALENDER PROMOSI</h1>
	<hr />
	<form action="addSave.php" method="post" enctype="multipart/form-data">
		<table width="100%" class="tableTransaction">
			<tr>
				<td>TANGGAL PROMO</td>
				<td>
					<input name="dateTransaction" type="text" id="dateTransaction" size="5" readonly  style="width:250px"/>
					<div style="color:red"><?php echo isset($msgError['dateTransaction']) ? $msgError['dateTransaction'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td>NAMA </td>
				<td>
					<input id="name" name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" style="width:250px" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">KETERANGAN</td>
				<td>
					<textarea name="description" style="width:250px; height:80px"><?php echo isset($_POST['description']) ? $_POST['description'] : '' ?></textarea>
				</td>
			</tr>
			<tr>
				<td width="25%" valign="top">PLATFORM MARKET</td>
				<td>
					<select name="platformMarketId[]" id="platformMarketId" style="width:250px; height: 100px" multiple >
						<?php while($val = mysql_fetch_array($cmbPlatformMarket)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['platformMarketId']) ? $_REQUEST['platformMarketId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
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
					yearRange: '-2y:c+nn'
				}); 
				<?php $tmp = strlen(trim($_REQUEST['dateTransaction'])) == 0 ?  '' : explode('/',$_REQUEST['dateTransaction']) ?>
				$("#dateTransaction" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> <?php echo date('d/m/Y') ?> <?php endif; ?>);
			});
	});

	function setNominal(p) {
		var tmp = p.split('~')
		document.getElementById('nominal').value = tmp[1];
	}
	</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
