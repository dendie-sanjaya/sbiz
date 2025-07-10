<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['dateTransaction'])) < 1) {
		$status = false;
		$msgError['dateTransaction'] = 'Silakan mengisikan tanggal transaksi';
	}

	if(strlen(trim($_POST['stock'])) < 1) {
		$status = false;
		$msgError['stock'] = 'Silakan mengisikan jumlah';
	}

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
