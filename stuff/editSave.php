<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include 'editValidate.php';	

	$id = general::secureInput($_POST['id']);
	$name = general::secureInput($_POST['name']);	
	$sku = strtoupper(trim(general::secureInput($_POST['sku'])));	
	$stockMinAlert = general::secureInput($_POST['stockMinAlert']);
	$constId = general::secureInput($_POST['constId']);
	$locationId = general::secureInput($_POST['locationId']);
	$price = general::secureInput($_POST['price']);
	$categoryId = general::secureInput($_POST['categoryId']);
	$priceBasic = general::secureInput($_POST['priceBasic']);
	$nickname = general::secureInput($_POST['nickname']);
	$feeSales = general::secureInput($_POST['feeSales']);
	$isHidden = general::secureInput($_POST['isHidden']);
	$costCs = general::secureInput($_POST['costCs']);
	$costOps = general::secureInput($_POST['costOps']);
	$costRiset = general::secureInput($_POST['costRiset']);
	$costAdv = general::secureInput($_POST['costAdv']);
	$subRowCategory1 = general::secureInput($_POST['subRowCategory1']);
	$subRowCategory2 = general::secureInput($_POST['subRowCategory2']);
	$subRowCategory3 = general::secureInput($_POST['subRowCategory3']);
	$idSubRowCategory1 = general::secureInput($_POST['idSubRowCategory1']);
	$idSubRowCategory2 = general::secureInput($_POST['idSubRowCategory2']);
	$idSubRowCategory3 = general::secureInput($_POST['idSubRowCategory3']);
	$typeSubCategory = general::secureInput($_POST['typeSubCategory']);
	
	$query = "update stuff
		set name = '$name', 
		  sku = '$sku',
		  nickname = '$nickname', 			
		  stock_min_alert = '$stockMinAlert',
		  const_id = '$constId',
		  location_id = '$locationId',
		  price = '$price',
		  price_basic = '$priceBasic',		  
		  category_id = '$categoryId',
		  is_hidden = '$isHidden',
		  fee_sales = '$feeSales',
		  cost_cs = '$costCs',
		  cost_ops = '$costOps',
		  cost_riset = '$costRiset',
		  cost_adv = '$costAdv'
	    where id = '$id'";

	mysql_query($query) or die (mysql_error());

	if($typeSubCategory == '0') { 
		$query = "update stuff_category_sub_row
			set name = '$subRowCategory1'
			  where id = '$idSubRowCategory1'";

		mysql_query($query) or die (mysql_error());

		$query = "update stuff_category_sub_row
			set name = '$subRowCategory2'
			  where id = '$idSubRowCategory2'";

		mysql_query($query) or die (mysql_error());

		$query = "update stuff_category_sub_row
			set name = '$subRowCategory3'
			  where id = '$idSubRowCategory3'";

		mysql_query($query) or die (mysql_error());
	} 	

	if($typeSubCategory == '1') { 
		$query = "insert stuff_category_sub_row
			set stuff_id = '$id',
			  stuff_category_sub_id = '$idSubRowCategory1',
			  name = '$subRowCategory1'";

		mysql_query($query) or die (mysql_error());

		$query = "insert stuff_category_sub_row
			set stuff_id = '$id',
			  stuff_category_sub_id = '$idSubRowCategory2',
			  name = '$subRowCategory2'";

		mysql_query($query) or die (mysql_error());

		$query = "insert stuff_category_sub_row
			set stuff_id = '$id',
			  stuff_category_sub_id = '$idSubRowCategory3',
			  name = '$subRowCategory3'";

		mysql_query($query) or die (mysql_error());
	}
		
	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
