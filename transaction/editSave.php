<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$tmp = explode('/',$_POST['dateTransaction']); 
	$dateTransaction  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$stock = $_POST['type'] == 0 ? '-'.$_POST['stock'] : $_POST['stock'];
	$description = $_POST['description'];
	$type = $_POST['type'];
	$suplierId = $_POST['suplierId'];
	$clientId = $_POST['clientId'];
	$price = $_POST['price'];
	$name = $_POST['name'];
	$categoryId = $_POST['categoryId'];


	if($type == 0) {
		$query = "insert stuff_history
			set stuff_id = '$id',
			  tipe = '$type',
			  amount = '$stock',
			  date = '$dateTransaction',
			  description = '$description',
			  price = '$price',	
			  client_id = '$clientId'";
	} else {
		$query = "insert stuff_history
			set stuff_id = '$id',
			  tipe = '$type',
			  amount = '$stock',
			  date = '$dateTransaction',
			  description = '$description',
			  price = '$price',
			  suplier_id = '$suplierId'";
	}

	mysql_query($query) or die (mysql_error());

	$query = "update stuff
		set stock = stock + '$stock'
	    where id = '$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&keyword='.$name.'&categoryId='.$categoryId);
?>
