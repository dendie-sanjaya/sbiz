<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id =  general::secureInput($_POST['id']);
	$name =  general::secureInput($_POST['name']);
	$isMarketplace =  general::secureInput($_POST['isMarketplace']);
	$fee_admin_percent =  general::secureInput($_POST['fee_admin_percent']);	


	$query = "update platform_market
		set name = '$name',
		  is_marketplace = '$isMarketplace',
		  fee_admin_percent = '$fee_admin_percent'		  
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
