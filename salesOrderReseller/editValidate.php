<?php 	
	$status = true;
	$msgError = array();
	
	/*
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama ';
	}
	*/

	if(strlen(trim($_POST['dateOrder'])) != 10) { 
		$status = false;
		$msgError['dateOrder'] = 'Silakan mengisikan tanggal pesanan dengan benar ';
	}

	if($status == false) {
		include 'edit.php';
		exit;
	}

?>
