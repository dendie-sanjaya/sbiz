<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$messanger = $_POST['messanger'];
	$address = $_POST['address'];
	
	$query = "update client
		set name = '$name',
		  phone = '$phone',
		  messanger = '$messanger',
		  address = '$address'
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
