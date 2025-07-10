<?php 	
	$status = true;
	$msgError = array();
	
	$sku = strtoupper(trim(general::secureInput($_POST['sku'])));

	/*
	if(strlen($sku) > 0) {
		$query = "select count(sku) as jml
			from stuff
			where sku ='$sku'
			  and is_delete = '0'";

		$tmp = mysql_query($query) or die (mysql_error());
		$data = mysql_fetch_array($tmp);

		if($data['jml'] == 1) {
			$status = false;
			$msgError['sku'] = 'SKU sudah digunakan';
		}	
	}	
	*/
	
	if(strlen(trim($_POST['categoryId'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan memilih kategori barang';
	}

	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama barang';
	}

	if(strlen(trim($_POST['stock'])) < 1) {
		$status = false;
		$msgError['stock'] = 'Silakan mengisikan persedian awal';
	}

	if(strlen(trim($_POST['stockMinAlert'])) < 1) {
		$status = false;
		$msgError['stockMinAlert'] = 'Silakan mengisikan minimum persediaan';
	}

	if( (trim($_POST['price']) < 1) || (empty($_POST['price']) )  ) {
		$status = false;
		$msgError['price'] = 'Silakan mengisikan harga jual';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
