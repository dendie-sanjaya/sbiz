<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['dateTransaction'])) < 1) {
		$status = false;
		$msgError['dateTransaction'] = 'Silakan mengisikan tanggal transaksi';
	}

	if(strlen(trim($_POST['name'])) < 1) {
		$status = false; 
		$msgError['name'] = 'Silakan mengisikan nama promo';
	}

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
