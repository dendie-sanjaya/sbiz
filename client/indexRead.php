<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,name,phone,messanger,address,is_fix 
		from client
		where is_delete = '0'
		order by name";

	$data = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';
?>
