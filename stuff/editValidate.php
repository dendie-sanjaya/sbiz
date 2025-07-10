<?php 	
	$status = true;
	$msgError = array();
	$sku = strtoupper(trim(general::secureInput($_POST['sku'])));
	$skuHidden = strtoupper(trim(general::secureInput($_POST['sku_hidden'])));

	/*
	if(strlen($sku) > 0) {
		$query = "select count(sku) as jml
			from stuff
			where sku ='$sku'
			  and is_delete = '0'
			  and sku != '$skuHidden'";

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


	if(strlen(trim($_POST['stockMinAlert'])) < 1) {
		$status = false;
		$msgError['stockMinAlert'] = 'Silakan mengisikan minimum stok';
	}

	if( (trim($_POST['price']) < 1) || (empty($_POST['price']) )  ) {
		$status = false;
		$msgError['price'] = 'Silakan mengisikan harga jual';
	}


	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
