<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama';
	}

	if(strlen(trim($_POST['dateTransaction'])) < 1) {
		$status = false;
		$msgError['dateTransaction'] = 'Silakan mengisikan tanggal';
	}

	if(strlen(trim($_POST['nominal'])) < 1) {
		$status = false;
		$msgError['nominal'] = 'Silakan mengisikan nominal';
	}
	
	if($status == false) {
		include 'add.php';
		exit;
	}
?>
