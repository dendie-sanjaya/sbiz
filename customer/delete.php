<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$id = general::secureInput($_GET['id']);

	$query = "update customer
	      set is_delete = '1'
		where id='$id'";

	mysql_query($query);

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&type=4');
?>
