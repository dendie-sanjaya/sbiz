<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

	$query = "select id,name
		from platform_market
		where is_delete = '0'
		order by name";
	$cmbPlatformMarket = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
