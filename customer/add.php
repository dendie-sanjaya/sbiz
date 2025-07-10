<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>TAMBAH PELANGGAN</h1>
	<hr />
	<form action="addSave.php" method="post">
		<table width="100%">
			<tr>
				<td valign="top">KATEGORI PELANGGAN</td>
				<td>
					<select name="categoriId[]" style="width:250px; height:80px" multiple >
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo isset($_REQUEST['categoriId']) ? in_array($val['id'],$_REQUEST['categoriId'])  ? 'selected' : '' : '' ?> ><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>
					<div style="color:red"><?php echo isset($msgError['categoriId']) ? $msgError['categoriId'] : '' ?></div>
				</td>
			</tr>	
			<tr style="height: 40px">
				<td valign="middle">SALES</td>
				<td valign="middle">
					<?php if(in_array($_SESSION['loginPosition'], array('3'))): ?>
						<input type="hidden" name="salesId" value="<?php echo $dataSalesDefault['id'] ?>" />			
						<?php echo $dataSalesDefault['name'] ?>
					<?php else: ?>	
						<select name="salesId" style="width:200px;">
							<?php while($val = mysql_fetch_array($dataSales)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo isset($_REQUEST['salesId']) ? $val['id'] == $_REQUEST['salesId'] ? 'selected' : '' : '' ?> ><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>
					<?php endif; ?>						
				</td>
			</tr>	
			<tr>
				<td width="23%" valign="top">TGL KONTAK</td>
				<td>
					<input name="dateInput" type="text" id="dateInput" value="<?php echo isset($_POST['dateInput']) ? $_POST['dateInput'] : '' ?>" style="width:205px; height: 30px" />
					<div style="color:red"><?php echo isset($msgError['dateInput']) ? $msgError['dateInput'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td width="23%" valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" style="width:205px" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">HANDPHONE</td>
				<td>
					<input name="countryCode" type="text" value="62" size="1" value="<?php echo isset($_POST['countryCode']) ? $_POST['counteryCode'] : '' ?>" />
					<input name="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>" placeholder="87899609023" size="14" />
					<div style="color:red"><?php echo isset($msgError['countryCode']) ? $msgError['countryCode'] : '' ?></div>
					<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>					
				</td>
			</tr>
			<tr>
				<td width="20%" valign="top">KOTA</td>
				<td>
					<input name="city" type="text" value="<?php echo isset($_POST['city']) ? $_POST['city'] : '' ?>" style="width:205px" />
				</td>
			</tr>
		</table>
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
	</form>

<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateInput" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = strlen(trim($_REQUEST['dateInput'])) == 0 ?  '' : explode('/',$_REQUEST['dateInput']) ?>
				$("#dateInput" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});
	});
	
</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
