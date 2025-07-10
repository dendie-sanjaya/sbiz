<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];
	$status = $_GET['status'];

	$query = "update period_order
		set is_status = '$status'
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&periodeStatus='.$status);
?>
