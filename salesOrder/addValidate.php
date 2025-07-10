<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama ';
	}

	if(strlen(trim($_POST['dateOrder'])) < 1) {
		$status = false;
		$msgError['dateOrder'] = 'Silakan mengisikan tanggal pemesanan';
	}

	if(strlen(trim($_POST['phone'])) < 1) {
		$status = false;
		$msgError['phone'] = 'Silakan mengisikan nomor telepon ';
	}

	if(substr(trim($_POST['phone']),0,2) != '62') {
		$status = false;
		$msgError['phone'] = 'Mohon mengisikan format telepon 62... ';
	}


	if($status == false) {
		include 'add.php';
		exit;
	}
?>
