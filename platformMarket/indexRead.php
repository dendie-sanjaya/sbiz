<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,name,is_fix,is_marketplace,fee_admin_percent 
		from platform_market
		where is_delete = '0'
		order by name";

	$data = mysql_query($query);

	include '../lib/connection-close.php';
?>
