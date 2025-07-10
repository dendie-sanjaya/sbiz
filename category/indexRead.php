<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$type = $_REQUEST['type'];
	
	$query = "select id,name,cost_cs,cost_ops,cost_riset,cost_adv
		from stuff_category
		where is_delete = '0'
		order by name";

	$data = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';
?>
