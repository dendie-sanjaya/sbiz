<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	

	$id = general::secureInput($_POST['id']);
	$name = general::secureInput($_POST['name']);	
	$categoryId = general::secureInput($_POST['categoryId']);
	$isHidden = general::secureInput($_POST['isHidden']);
	$priceMin = general::secureInput($_POST['priceMin']);
	$feeSales = general::secureInput($_POST['feeSales']);		
	
	$query = "update stuff_bundling
		set name = '$name', 
		  nickname = '', 			
		  category_id = '$categoryId',
		  price = '$priceMin',
		  price_min = '$priceMin',
		  fee_sales = '$feeSales',			  		  
		  is_hidden = '$isHidden'
	    where id = '$id'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
