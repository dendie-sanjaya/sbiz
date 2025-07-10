<?php 	
	include '../lib/connection.php';

	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama';
	}

	$username = trim($_POST['username']);
	$usernameHidden = trim($_POST['usernameHidden']);

	$query = "select count(username) as jml
		from user
		where username = '$username'
		and username != '$usernameHidden'";

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

	include '../lib/connection-close.php';

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
