<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama ';
	}

	if(strlen(trim($_POST['dateOrder'])) != 10) { 
		$status = false;
		$msgError['dateOrder'] = 'Silakan mengisikan tanggal pesanan dengan benar ';
	}

    if($_POST['isWarehouseExternal'] == '1') {		
		if(strlen(trim($_POST['districtsCode'])) < 1) { 
			$status = false;
			$msgError['disctritCode'] = 'Silakan memilih kode kecamatan ';
		}
	}	

    if($_POST['isWarehouseExternal'] == '1') {		
		if(strlen(trim($_POST['postalCode'])) < 1) { 
			$status = false;
			$msgError['postalCode'] = 'Silakan mengisikan kode pos';
		}
	}	

    if($_POST['isWarehouseExternal'] == '0') {		
		if(strlen(trim($_POST['ekpedisiPostalCode'])) < 1) { 
			$status = false;
			$msgError['ekspedisiPostalCode'] = 'Silakan mengisikan kode pos';
		}
	}	
	
	if(strlen(trim($_POST['phone'])) < 1) {
		$status = false;
		$msgError['phone'] = 'Silakan mengisikan nomor telepon ';
	}
	
	if(substr(trim($_POST['phone']),0,2) != '62') {
		$status = false;
		$msgError['phone'] = 'Mohon mengisikan format telepon 62... ';
	}

	if(isset($_POST['is_dropshipper'])) {
		if(strlen(trim($_POST['dropshipper_name'])) < 1) { 
		  $status = false;
		  $msgError['dropshipper_name'] = 'Mohon mengisikan format telepon 62... ';
		}		

		if(substr(trim($_POST['dropshipper_phone']),0,2) != '62') {
			$status = false;
			$msgError['dropshipper_phone'] = 'Mohon mengisikan format telepon 62... ';
		}

		/*
		if(strlen(trim($_POST['dropshipper_address'])) < 1) { 
			$status = false;
			$msgError['dropshipper_address'] = 'Mohon mengisikan alamat dropshipper';
		}
		*/
	}


	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
