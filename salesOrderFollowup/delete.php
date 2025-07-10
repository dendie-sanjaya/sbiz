<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$id = general::secureInput($_REQUEST['id']);	

	$query = "update sales_order_followup
		set is_delete = '1'
		where id = '$id'";
	mysql_query($query) or die (mysql_error());	
		
	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess');
?>
