<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';

	$name = $_POST['name'];

	$query = "insert const
		set name = '$name',
		  type ='1'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
