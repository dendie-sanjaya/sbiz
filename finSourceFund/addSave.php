<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';

	$name = $_POST['name'];
	$accountNumber = $_POST['accountNumber'];
	$description = $_POST['description'];

	$query = "insert fin_source_fund
		set name = '$name',
		  account_number = '$accountNumber',
		  description = '$description'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
