<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,name,description,is_fix 
		from suplier
		where is_delete = '0'
		order by name";

	$data = mysql_query($query);

	include '../lib/connection-close.php';
?>
