<?php ob_start(); ?>
<?php include 'addRead.php' ?>
	<h1>TAMBAH PENGELUARAN PERHARI</h1>
	<hr />
	<form action="addSave.php" method="post" enctype="multipart/form-data">
		<table width="100%" class="tableTransaction">
			<tr>
				<td width="25%" valign="top">KOMPONEN PENGELUARAN</td>
				<td>
					<select name="componentId" id="componentId" style="width:250px" onchange="setNominal(this.value)">
						<?php while($val = mysql_fetch_array($cmbComponent)): ?>
							<option value="<?php echo $val['id'] ?>~<?php echo $val['nominal'] ?>" <?php echo $val['id'] == (isset($_REQUEST['componentId']) ? $_REQUEST['componentId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
				</td>
			</tr>
			<tr>
				<td width="25%" valign="top">SUMBER PENDANAAN</td>
				<td>
					<select name="sourceFoundId" id="sourceFoundId" style="width:250px">
						<?php while($val = mysql_fetch_array($cmbSourceFund)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['sourceFoundId']) ? $_REQUEST['sourceFoundId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>				
				</td>
			</tr>
			<tr>
				<td>TGL TRANSAKSI</td>
				<td>
					<input name="dateTransaction" type="text" id="dateTransaction" size="5" readonly  style="width:250px"/>
					<div style="color:red"><?php echo isset($msgError['dateTransaction']) ? $msgError['dateTransaction'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td>JUMLAH PENGERLUARAN</td>
				<td>
					<input id="nominal" name="nominal" type="text" value="0" style="width:250px" />
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
