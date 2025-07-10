<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];	

	$query = "update sales_order
			set is_delete_permanent = '1'
		where id = '$id'";	
	mysql_query($query) or die (mysql_error());	
				
	include '../lib/connection-close.php';
	
	header('Location:index.php?msg=deleteSuccess');
?>
