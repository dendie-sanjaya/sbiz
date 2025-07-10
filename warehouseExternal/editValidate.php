<?php 	
	$status = true;
	$msgError = array();

	$code = general::secureInput($_POST['code']);
	$codeHidden = general::secureInput($_POST['code_hidden']);

	$query = "select count(code) as jml
		from warehouse_external
		where code ='$code'
		  and is_delete = '0'
		  and code != '$codeHidden'";

	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);

	if($data['jml'] == 1) {
		$status = false;
		$msgError['code'] = 'Kode gudang sudah digunakan';
	}	
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama gudang';
	}

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
