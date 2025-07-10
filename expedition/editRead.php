<?php 
	include '../login/auth.php';
	include '../lib/connection.php';


	$id = $_REQUEST['id'];

	$query = "select id,name,description 
		from expedition
		where id='$id'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
