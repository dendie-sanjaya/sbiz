<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$stock = $_POST['stock'];	
	$description = $_POST['description'];
	$categoryId = $_POST['categoryId'];

	$query = "insert stuff_history
		set stuff_id = '$id',
		  amount = '$stock',	
		  tipe = '3',		  
		  date = now(),
		  description = ':: KOREKSI STOK ::$description'";

	mysql_query($query) or die (mysql_error());

	$query = "update stuff
		set stock = '$stock'
	    where id = '$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&keyword='.$name.'&categoryId='.$categoryId);
?>
