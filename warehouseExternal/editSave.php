<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include 'editValidate.php';

	$id = general::secureInput($_POST['id']);
	$code = general::secureInput($_POST['code']);
	$name = general::secureInput($_POST['name']);
	$address = general::secureInput($_POST['address']);

	$query = "update warehouse_external
		set code = '$code', 
		  name = '$name',
		  address = '$address' 
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
