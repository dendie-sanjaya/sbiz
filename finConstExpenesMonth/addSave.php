<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';


	$name = general::secureInput($_POST['name']);
	$nominal = general::secureInput($_POST['nominal']);

	$query = "insert fin_expenses_revenue
		set name = '$name',
		  nominal = '$nominal',
		  type = '0',
	      periode = '1'
		  ";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
