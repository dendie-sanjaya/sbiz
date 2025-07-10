<?php 	
	$status = true;
	$msgError = array();

	if(strlen(trim($_POST['dateTransaction'])) < 1) {
		$status = false; 
		$msgError['dateTransaction'] = 'Silakan mengisikan tanggal transaksi';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
