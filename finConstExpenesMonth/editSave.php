<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$id = general::secureInput($_POST['id']);
	$name = general::secureInput($_POST['name']);
	$nominal = general::secureInput($_POST['nominal']);

	$query = "update fin_expenses_revenue
		set name = '$name',
		  nominal = '$nominal'
		where id='$id'
		  and type = '0'
	      and periode = '1'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
