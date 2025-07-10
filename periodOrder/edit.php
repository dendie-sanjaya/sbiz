<?php ob_start(); ?>
	<?php include 'editRead.php' ?>

	<h1>EDIT PERIODE<h1>
	<hr />
	<form action="editSave.php" method="post" />
		<input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
		<table width="100%">
			<tr>			
				<td valign="top" width="20%">NAMA</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>			
				<td valign="top">TANGGAL BUKA</td>
				<td>
					<input name="dateStart" type="text" id="dateStart" size="5" style="width:155px"/>													</td>
				</td>
			</tr>
			<tr>			
				<td valign="top">TANGGAL TUTUP</td>
				<td>
					<input name="dateEnd" type="text" id="dateEnd" size="5" style="width:155px"/>										
				</td>
			</tr>
		</table>
		<hr />
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php'" />
	</form>
	
	<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateStart" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:+1y',
					maxDate: '90d',
				}); 
				<?php $tmp = isset($_REQUEST['dateStart']) ? strlen(trim($_REQUEST['dateStart'])) == 0 ?  '' : explode('/',$_REQUEST['dateStart']) : explode('/',$data['date_start_frm']) ?>
				$("#dateStart" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});
	});

	$(document).ready(function() {
		$(function() {
				$( "#dateEnd" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:+1y',
					maxDate: '90d',
				}); 
				<?php $tmp = isset($_REQUEST['dateEnd']) ? strlen(trim($_REQUEST['dateEnd'])) == 0 ?  '' : explode('/',$_REQUEST['dateEnd']) : explode('/',$data['date_end_frm']) ?>
				$("#dateEnd" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});
	});
	</script>
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
