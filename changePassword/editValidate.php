<?php 	
	$status = true;
	$msgError = array();

	include '../lib/connection.php';

	$username = $_SESSION['login'];
	$password = md5(trim($_POST['password']));

	$query = "select count(username) as jml
		from user
		where username ='$username'
		  and password = '$password'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	if($data['jml'] != 1) {
		$status = false;
		$msgError['password'] = 'Password yang Anda masukan salah';
	}

	include '../lib/connection-close.php';

	
	if(strlen(trim($_POST['password'])) < 1) {
		$status = false;
		$msgError['password'] = 'Silakan mengisikan password';
	}

	if(strlen(trim($_POST['passwordNew'])) < 1) {
		$status = false;
		$msgError['passwordNew'] = 'Silakan mengisikan password baru';
	}

	if(strlen(trim($_POST['passwordNewConf'])) < 1) {
		$status = false;
		$msgError['passwordNewConf'] = 'Silakan mengisikan konfirmasi password baru';
	}

	if(trim($_POST['passwordNew']) != trim($_POST['passwordNewConf']) ) {
		$status = false;
		$msgError['passwordNewConf'] = 'Password konfirmasi tidak sama dengan password baru';
	}

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
