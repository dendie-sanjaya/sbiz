<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['purchaseOrderName'])) < 1) {
		$status = false;
		$msgError['cari'] = 'Silakan mengisikan no sales order ';
	}


	if($status == false) {
		include 'add.php';
		exit;
	}
?>
