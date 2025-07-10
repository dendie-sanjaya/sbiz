<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	
	$query = "select id,name 
		from position
		where is_delete = '0'
		order by name";

	$dataPosition = mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from stuff_category
		where is_delete = '0'
		order by name";

	$dataCategory = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';	
?>
