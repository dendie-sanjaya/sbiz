<?php ob_start(); ?>
<?php include 'addRead.php' ?>

	<h1>TAMBAH PEMESANAN</h1>
	<hr />
	<form action="add.php" method="post" onsubmit="this.action='addSave.php'; this.submit()">
		<fieldset>
			<legend><b>JENIS PEMBELIAN<b></legend>			
				<table width="100%">
					<tr>
						<td width="20%">TIPE PENJUALAN</td>
						<td width="25%" ><b>Pemesanan / Pre Order</b>
							<input type="hidden" name="tipeOrder" value="1" />
							<!--
							<select name="tipeOrder" style="width:180px" onchange="showPeriodePemesanan(this.value)">
								<option value="0" <?php echo 0 == (isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : '') ? 'selected' : '' ?>>Langsung</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : '') ? 'selected' : '' ?>>Pemesanan</option>
							</select>
							-->		
						</td>
						<td>Pedagang</td>
						<td>
							<input type="hidden" name="hiddenClientId" value="<?php echo $_REQUEST['clientId'] ?>" 	/>
							<select name="clientId" style="width:280px" onchange='this.form.submit()'>
								<option value="0" <?php echo 0 == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : '') ? 'selected' : '' ?>>Bukan Pedagang</option>
								<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
										<option value="<?php echo $valClient[0] ?>" <?php echo $valClient[0] == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : '') ? 'selected' : '' ?>><?php echo $valClient[1] ?> - <?php echo $valClient[2] ?></option>								
								<?php endwhile; ?>
							</select>				

						</td>
					<tr>
					</tr>		
						<td  width="20%" id="periodePemesananLabel" style="">PERIODE PEMESANAN</b>
						<td style="" id="periodePemesananCmb">
							<select name="periodeOrderId" style="width:180px">
								<?php while($val = mysql_fetch_array($dataPeriodeOrder)): ?>
									<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['periodeOrderId']) ? $_REQUEST['periodeOrderId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
								<?php endwhile; ?>
							</select>				
						</td>
					</tr>
				</table>
		</fieldset>
		<br />	
		<fieldset>
			<legend><b>DATA PEMBELI<b></legend>			
				<table width="100%">
					<tr>
						<td width="20%" valign="top">NAMA</td>
						<td width="25%" valign="top">
							<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $dataClient['name'] ?>" />
							<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
						</td>
						<td width="15%"  valign="top">TELEPON</b>
						<td valign="top">
							<input name="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $dataClient['phone'] ?>" />
							<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
						</td>												
					</tr>
					<tr>
						<td width="" valign="top">ALAMAT PENGIRIMAN</td>
						<td colspan="4">
							<textarea name="address" style="width:600px; height:50px"><?php echo isset($_POST['address']) ? $_POST['address'] : $dataClient['address'] ?></textarea>
							<div style="color:red"><?php echo isset($msgError['address']) ? $msgError['address'] : '' ?></div>
						</td>
					</tr>
					<tr>
						<td  width="20%">TGL PEMESANAN</b>
						<td>
							<input name="dateOrder" type="text" id="dateOrder" size="5"   style="width:155px"/>						
						</td>											
					</tr>	
				</table>
		</fieldset>	
		<hr />
		<input type="submit" value="SIMPAN & LANJUTKAN MEMILIH BARANG"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
	</form>
	
	<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateOrder" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = strlen(trim($_REQUEST['dateOrder'])) == 0 ?  '' : explode('/',$_REQUEST['dateOrder']) ?>
				$("#dateOrder" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});
	});

		function showPeriodePemesanan(p) {
			if(p == 0) { 
				document.getElementById('periodePemesananLabel').style.display='none';		
				document.getElementById('periodePemesananCmb').style.display='none';		
			} else {
				document.getElementById('periodePemesananLabel').style.display='';		
				document.getElementById('periodePemesananCmb').style.display='';		
			}
		}
		
		//showPeriodePemesanan(<?php echo $_REQUEST['tipeOrder'] ?>);
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
