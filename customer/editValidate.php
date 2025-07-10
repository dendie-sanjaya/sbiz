<?php 	
	include '../lib/connection.php';

	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama';
	}

	if(strlen(trim($_POST['countryCode'])) < 1) {
		$status = false;
		$msgError['countryCode'] = 'Silakan isikan kode negara';
	}

	if(substr(trim($_POST['phone']),0,1) == 0) {
		$status = false;
		$msgError['phone'] = 'Silakan isikan no telepon tidak diawali 0';
	}

	if(strlen(trim($_POST['phone'])) < 1) {
		$status = false;
		$msgError['phone'] = 'Silakan isikan no telepon';
	}

	if(count($_POST['categoriId']) < 1) {
		$status = false;
		$msgError['categoriId'] = 'Silakan memilih kategori pelanggan';
	}

	$phone = $_POST['phone'];
	$countryCode = $_POST['countryCode'];
	$phoneNumber = $countryCode.$phone;
	$phoneHidden = $_POST['phoneHidden'];

 	$query = "select count(id) as total
	 from customer
	 where concat(country_code,phone_number) = '$phoneNumber'
	  and concat(country_code,phone_number) != '$phoneHidden' ";		


	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	
	if($data['total'] != 0) {
		$status = false;
		$msgError['phone'] = 'Nomor telepon sudah ada';		
	}

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
