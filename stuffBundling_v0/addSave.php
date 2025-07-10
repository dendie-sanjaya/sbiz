<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$name = general::secureInput($_POST['name']);
	$categoryId = general::secureInput($_POST['categoryId']);
	$priceBasic = general::secureInput($_POST['priceBasic']);
	$isHidden = general::secureInput($_POST['isHidden']);

	$query = "insert stuff_bundling
		set name = '$name',
		  nickname = '', 
		  is_hidden = '$isHidden',
		  category_id = '$categoryId'";

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as last_id
			 from stuff_bundling";
	$rst = mysql_query($query) or die (mysql_error());		 
	$lastId = mysql_fetch_array($rst);

	include '../lib/connection-close.php';

	//header('Location:stuff.php?msg=addSuccess&id='.$lastId['last_id']);
	header('Location:stuff.php?id='.$lastId['last_id']);

?>
