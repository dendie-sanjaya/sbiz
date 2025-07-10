<?php ob_start(); ?>
<?php include 'addRead.php' ?>

	<h1>TAMBAH PENJUALAN</h1>
	<hr />
	<form action="add.php" method="post" onsubmit="this.action='addSave.php'; this.submit()">
		<fieldset>
			<legend><b>DATA PEMBELI<b></legend>			
				<table width="100%">
					<tr>
						<td width="25%" valign="top">NAMA  </td>
						<td width="40%" valign="top">
							<input name="name" type="text" value="<?php echo isset($_REQUEST['name']) ? $_REQUEST['name'] : $dataClient['name'] ?>" />
							<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
						</td>
						<td width="15%"  valign="top">TELEPON</b>
						<td valign="top">
							<input name="phone" id="phone"  type="text" value="<?php echo isset($_REQUEST['phone']) ? $_REQUEST['phone'] : $dataClient['phone'] ?>" placeholder="62..." onkeyup="validationPhone()" />
							<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
						</td>												
					</tr>
					<tr>
						<td  width="20%">TGL PEMESANAN</b>
						<td>
							<input name="dateOrder" type="text" id="dateOrder" readonly />						
							<div style="color:red"><?php echo isset($msgError['dateOrder']) ? $msgError['dateOrder'] : '' ?></div>
						</td>											
						<td>
						   PELANGGAN	
						</td>
						<td>
							<select name="clientId" style="width:200px" >
								<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
										<option value="<?php echo $valClient[0] ?>" <?php echo $valClient[0] == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : '') ? 'selected' : '' ?>><?php echo $valClient[1] ?> - <?php echo $valClient[2] ?></option>								
								<?php endwhile; ?>
							</select>											
						</td>												
					</tr>	
					<tr>
						<td width="" valign="top" >ALAMAT PENGIRIMAN</td>
						<td colspan="4">
							<textarea name="address" style="width:645px; height:50px;"><?php echo isset($_REQUEST['address']) ? $_REQUEST['address'] : $dataClient['address'] ?></textarea>
							<div style="color:red"><?php echo isset($msgError['address']) ? $msgError['address'] : '' ?></div>
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

		function validationPhone() {
		  /*	
		  var validasiAngka = /^[0-9]+$/;
		  var phone = document.getElementById("phone");
		  if (!phone.value.match(validasiAngka)) {
		      document.getElementById("phone").value = '';
		  } else {
		  	var res = phone.value.substring(0, 2);
		  	var newnumber;
		  	if(res != 62) {
 			   newnumber = '62' + phone.value.substring(3, 15); 			   
 			   document.getElementById("phone").value = newnumber; 
		  	}
		  }
		  */
		}	

		function showPeriodePemesanan(p) {
			/*
			if(p == 0) { 
				document.getElementById('periodePemesananLabel').style.display='none';		
				document.getElementById('periodePemesananCmb').style.display='none';		
			} else {
				document.getElementById('periodePemesananLabel').style.display='';		
				document.getElementById('periodePemesananCmb').style.display='';		
			}
			*/
		}
		
		//showPeriodePemesanan(<?php echo $_REQUEST['tipeOrder'] ?>);


</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
