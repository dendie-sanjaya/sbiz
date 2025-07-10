<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$accountNumber = $_POST['accountNumber'];	
	$description = $_POST['description'];

	$query = "update fin_source_fund
		set name = '$name',
		  account_number = '$accountNumber',
		  description = '$description' 
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
