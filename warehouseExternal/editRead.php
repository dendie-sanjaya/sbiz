<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']);

	$query = "select id,code,name,address
		from warehouse_external
		where id='$id'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
