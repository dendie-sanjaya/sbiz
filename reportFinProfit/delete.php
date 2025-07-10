<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];
	$year = $_REQUEST['year'];	

	$query = "update fin_profit_loss
			set is_delete = '1'
		where id = '$id'";	
	mysql_query($query) or die (mysql_error());	
		
	include '../lib/connection-close.php';

	//include 'deleteStuffSaveSuccess.php';		
	header('Location:index.php?msg=deleteSuccess&year='.$year);
?>
