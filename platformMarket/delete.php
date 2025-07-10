<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];

	$query = "update platform_market
		set is_delete = '1'
		where id='$id'";
 
	mysql_query($query);

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess');
?>
