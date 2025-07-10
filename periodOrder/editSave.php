<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$tmp = explode('/',$_POST['dateStart']); 
	$dateStart  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_POST['dateEnd']); 
	$dateEnd  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	echo $query = "update period_order
		set name = '$name',
		  date_start = '$dateStart', 	
		  date_end = '$dateEnd'
		 where id = '$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
