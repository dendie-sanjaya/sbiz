<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$tmp = explode('/',$_POST['dateTransaction']); 
	$dateTransaction  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$description = general::secureInput($_POST['description']);
	$name = general::secureInput($_POST['name']);
	$platformMarketId = $_POST['platformMarketId'];

	$query = "insert promotion_calendar
		set name = '$name',
		  description = '$description',
		  date_transaction = '$dateTransaction',
		  date_system = now(),
		  is_delete = '0'";
	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as last_id from promotion_calendar";
	$rst = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($rst);
	$lastId = $data['last_id'];	

	foreach($platformMarketId as $val) {
		$marketId = general::secureInput($val);
		$query = "insert promotion_calendar_platform_market
			set promotion_calender_id = '$lastId',
			  platform_market_id = '$marketId'";
		mysql_query($query) or die (mysql_error());

	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&dateFrom='.$_POST['dateTransaction'].'&dateTo='.$_POST['dateTransaction']);
?>
