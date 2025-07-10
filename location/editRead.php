<?php 
	include '../login/auth.php';
	include '../lib/connection.php';


	$id = $_REQUEST['id'];

	$query = "select id,name 
		from location
		where id='$id'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
