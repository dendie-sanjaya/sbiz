<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$id = general::secureInput($_POST['id']);
	$tmp = explode('/',$_POST['dateTransaction']); 
	$dateTransaction  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$description = general::secureInput($_POST['description']);
	$name = general::secureInput($_POST['name']);
	$platformMarketId = $_POST['platformMarketId'];

	$query = "update promotion_calendar
		set name = '$name',
		  description = '$description',
		  date_transaction = '$dateTransaction',
		  date_system = now()
		where id = '$id'";
	mysql_query($query) or die (mysql_error());

	$query = "delete from promotion_calendar_platform_market
			   where promotion_calender_id = '$id'";
	mysql_query($query) or die (mysql_error());

	foreach($platformMarketId as $val) {
		$marketId = general::secureInput($val);
		$query = "insert ignore promotion_calendar_platform_market
			set promotion_calender_id = '$id',
			  platform_market_id = '$marketId'";
		mysql_query($query) or die (mysql_error());
	}
	
	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&dateFrom='.$_POST['dateTransaction'].'&dateTo='.$_POST['dateTransaction']);
?>
