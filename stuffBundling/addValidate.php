<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['categoryId'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan memilih kategori barang';
	}

	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama barang bundling';
	}

	if(strlen(trim($_POST['priceMin'])) < 1) {
		$status = false;
		$msgError['priceMin'] = 'Silakan mengisikan harga minimal';
	}

	if(strlen(trim($_POST['feeSales'])) < 1) {
		$status = false;
		$msgError['feeSales'] = 'Silakan mengisikan komisi sales';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
