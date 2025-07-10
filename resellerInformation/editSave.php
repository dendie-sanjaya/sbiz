<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$description = addslashes(preg_replace('#<script(.*?)>(.*?)</script>#is', '',$_POST['description']));

	$query = "update reseller_information
		set description = '$description' 
		where id='1'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:edit.php?msg=editSuccess');
?>
