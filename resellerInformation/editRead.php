<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';	

	$query = "select id,description 
		from  reseller_information
		where id='1'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
