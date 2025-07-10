<?php ob_start(); ?>
<?php include 'editRead.php' ?>
	<h1>EDIT KALENDER PROMOSI</h1>
	<hr />
	<form action="editSave.php" method="post" enctype="multipart/form-data">
		<input type="hidden" value="<?php echo $id ?>" name="id" >
		<table width="100%" class="tableTransaction">
			<tr>
				<td width="25%" valign="top">TANGGAL PROMO</td>
				<td>
					<input name="dateTransaction" type="text" id="dateTransaction" size="5" readonly  style="width:250px" value="<?php echo $data['date_transaction'] ?>" />
					<div style="color:red"><?php echo isset($msgError['dateTransaction']) ? $msgError['dateTransaction'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td>NAMA </td>
				<td>
					<input id="name" name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?><?php echo $data['name'] ?>" style="width:250px" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>					
				</td>
			</tr>			
			<tr>
				<td valign="top">KETERANGAN</td>
				<td>
					<textarea name="description" style="width:250px; height:80px"><?php echo isset($_POST['description']) ? $_POST['description'] : '' ?><?php echo $data['description'] ?></textarea>
				</td>
			</tr>
			<tr>
				<td width="25%" valign="top">PLATFORM MARKET</td>
				<td>
					<select name="platformMarketId[]" id="platformMarketId" style="width:250px; height: 100px" multiple >
						<?php while($val = mysql_fetch_array($cmbPlatformMarket)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo  in_array($val['id'],isset($_REQUEST['platformMarketId']) ? $_REQUEST['platformMarketId'] : $dataPlatformMarketId) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
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
						yearRange: '-2y:c+nn',
					}); 
					<?php $tmp = isset($_REQUEST['dateTransaction']) ? strlen(trim($_REQUEST['dateTransaction'])) == 0 ?  '' : explode('/',$_REQUEST['dateTransaction']) : explode('/',$data['date_transaction_frm_2']) ?>
					<?php if($tmp[0] != '00'): ?>	
						$("#dateTransaction" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
					<?php endif; ?>			
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
