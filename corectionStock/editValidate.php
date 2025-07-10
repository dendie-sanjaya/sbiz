<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['stock'])) < 1) {
		$status = false;
		$msgError['stock'] = 'Silakan mengisikan jumlah koreksi';
	}

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
