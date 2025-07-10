<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,name,code,address,is_fix 
		from warehouse_external
		where is_delete = '0'
		order by code, name";

	$data = mysql_query($query);

	include '../lib/connection-close.php';
?>
