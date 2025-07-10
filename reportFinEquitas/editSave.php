<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$nominal = $_POST['nominal'];
	$tipe = $_POST['tipe'];
	$tmp = explode('/',$_REQUEST['dateTransaction']);
	$dateTransaction  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	
	$query = "update fin_equitas
		set name  = '$name',
		  nominal = '$nominal',
		  tipe = '$tipe',
		  date_transaction = '$dateTransaction'
		  where id = '$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess&dateFrom='.urlencode($_REQUEST['dateFrom']).'&dateTo='.urlencode($_REQUEST['dateTo']));
?>
