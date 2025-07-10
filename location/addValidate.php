<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama lokasi penyimpanan';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
