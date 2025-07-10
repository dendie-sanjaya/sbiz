<?php 	
	include '../lib/connection.php';

	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama ';
	}

	$username = trim($_POST['username']);

	$query = "select count(username) as jml
		from user
		where username = '$username'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	if($data['jml'] > 0) {
		$status = false;
		$msgError['username'] = 'Username sudah digunakan';
	}
	
	if(strlen(trim($_POST['username'])) < 1) {
		$status = false;
		$msgError['username'] = 'Silakan mengisikan username';
	}

	if(strlen(trim($_POST['pwd'])) < 1) {
		$status = false;
		$msgError['pwd'] = 'Silakan mengisikan password';
	}

	include '../lib/connection-close.php';

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
