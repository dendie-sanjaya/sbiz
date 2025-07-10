<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	
	$id = general::secureInput($_REQUEST['id']);	
	$qty = general::secureInput($_REQUEST['total']);	
	$qtyHidden = general::secureInput($_REQUEST['totalHidden']);	
		
	$query = "update sales_order_followup_detail
		set qty = '$qty'
		where sales_order_followup_id = '$id'";

	mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';	
	include 'editSaveStuffSuccess.php';	
?>
