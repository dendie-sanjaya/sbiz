<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>TAMBAH ITEM </h1>
	<hr />
	<form action="addSave.php" method="post">
		<input name="dateForm" type="hidden" value="<?php echo $_REQUEST['dateFrom'] ?>" />			
		<input name="dateTo" type="hidden" value="<?php echo $_REQUEST['dateTo'] ?>" />	
		<table width="100%">
			<tr>
				<td width="15%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">TIPE</td>
				<td valign="top">
					<select name="tipe" style="width:195px">
						<option value="0" <?php echo '0' == (isset($_REQUEST['tipe']) ? $_REQUEST['tipe'] : '') ? 'selected' : '' ?>>Dana Keluar</option>
						<option value="1" <?php echo '1' == (isset($_REQUEST['tipe']) ? $_REQUEST['tipe'] : '') ? 'selected' : '' ?>>Dana Masuk</option>
					</select>		
				</td>
			</tr>			
			<tr>
				<td valign="top">TANGGAL</td>
				<td valign="top">
					<input name="dateTransaction" type="text" id="dateTransaction" size="5"   style="width:155px"/>						
					<div style="color:red"><?php echo isset($msgError['dateTransaction']) ? $msgError['dateTransaction'] : '' ?></div>
				</td>
			</tr>			
			<tr>
				<td valign="top">NOMINAL</td>
				<td valign="top">
					<input name="nominal" type="text" value="0" />
					<div style="color:red"><?php echo isset($msgError['nominal']) ? $msgError['nominal'] : '' ?></div>					
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
				$( "#dateTransaction" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = isset($_REQUEST['dateTransaction']) ? strlen(trim($_REQUEST['dateTransaction'])) == 0 ?  '' : '' :'' ?>
				<?php if($tmp[0] != '00'): ?>	
					$("#dateTransaction" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>
			});
	});
	
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
