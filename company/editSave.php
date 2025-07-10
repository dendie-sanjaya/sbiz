<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	
	$query = "update company
		set name = '$name',
		  phone = '$phone',
		  address = '$address'
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:edit.php?msg=editSuccess');
?>
