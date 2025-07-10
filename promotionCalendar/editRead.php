<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';		

	$id = general::secureInput($_REQUEST['id']);

	$query = "select id, name, description, date_transaction,  	
		  date_format(date_transaction,'%d %M %Y') as date_transaction_frm,
		  date_format(date_transaction,'%d/%m/%Y') as date_transaction_frm_2		  
		from promotion_calendar		
		where is_delete = '0'
		 and id = '$id'";
	$tmp = mysql_query($query) or die(mysql_error());
	$data = mysql_fetch_array($tmp);

	$query = "select id, platform_market_id	  
		from  promotion_calendar_platform_market	
		where promotion_calender_id = '$id'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataPlatformMarketId = array();
	while($val = mysql_fetch_array($tmp)){
		$dataPlatformMarketId[] = $val['platform_market_id'];
	}

	$query = "select id,name
		from platform_market
		where is_delete = '0'
		order by name";
	$cmbPlatformMarket = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';
?>