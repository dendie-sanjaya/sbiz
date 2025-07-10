<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	


	$id = general::secureInput($_GET['id']);

	$query = "update fin_expenses_revenue
		set is_delete = '1'
		where id='$id'
		  and type = '0'
	      and periode = '1'";

	mysql_query($query);

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess');
?>
