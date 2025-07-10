<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];

	$query = "update const
		set name = '$name'
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
