<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$id = general::secureInput($_GET['id']);

	$query = "update reseller
	      set is_delete = '1',
	       is_active = '0',
	       username = concat('x',username)
		where id='$id'";

	mysql_query($query) or die(mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess');
?>
