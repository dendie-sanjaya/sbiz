<?php 	
	$status = true;
	$msgError = array();

	if(strlen(trim($_POST['categoryId'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan memilih kategori barang';
	}
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama barang bundlig';
	}


	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
