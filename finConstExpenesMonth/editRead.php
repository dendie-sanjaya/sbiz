<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	


	$id = general::secureInput($_REQUEST['id']);

	$query = "select id,name,nominal
		from fin_expenses_revenue
		where id='$id'
		 and type = '0'
		 and periode = '1'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
