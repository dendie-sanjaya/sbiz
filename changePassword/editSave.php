<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$password = trim($_POST['password']);
	$passwordNew = trim($_POST['passwordNew']);
	$passwordNewConf = trim($_POST['passwordNewConf']);
	$username = $_SESSION['login'];

	$passwordNew = md5($passwordNew);
	$query = "update user
		set password = '$passwordNew'
		where username='$username'";

	mysql_query($query);

	include '../lib/connection-close.php';

	header('Location:edit.php?msg=passwordNewSuccess');
?>
