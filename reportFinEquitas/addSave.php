<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';

	$name = $_POST['name'];
	$nominal = $_POST['nominal'];
	$tipe = $_POST['tipe'];
	$tmp = explode('/',$_REQUEST['dateTransaction']);
	$dateTransaction  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	
	$query = "insert fin_equitas
		set name  = '$name',
		  nominal = '$nominal',
		  tipe = '$tipe',
		  date_transaction = '$dateTransaction'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&dateFrom='.urlencode($_REQUEST['dateFrom']).'&dateTo='.urlencode($_REQUEST['dateTo']));
?>
