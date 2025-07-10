<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	include 'addValidate.php';

	$sku = strtoupper(trim(general::secureInput($_POST['sku'])));
	$name = general::secureInput($_POST['name']);
	$stock = general::secureInput($_POST['stock']);
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
	$subCategory1 = general::secureInput($_POST['subCategory1']);
	$subCategory2 = general::secureInput($_POST['subCategory2']);
	$subCategory3 = general::secureInput($_POST['subCategory3']);
	$idSubCategory1 = general::secureInput($_POST['idSubCategory1']);
	$idSubCategory2 = general::secureInput($_POST['idSubCategory2']);
	$idSubCategory3 = general::secureInput($_POST['idSubCategory3']);


	$query = "insert stuff
		set name = '$name',
		  sku = '$sku', 	
		  nickname = '$nickname', 	
		  stock = '$stock',
		  stock_min_alert = '$stockMinAlert',
		  const_id = '$constId',
		  location_id = '$locationId',
		  price = '$price',
		  price_basic = '$priceBasic',
		  fee_sales = '$feeSales',		  
		  is_hidden = '$isHidden',
		  category_id = '$categoryId',
		  cost_cs = '$costCs',
		  cost_ops = '$costOps',
		  cost_riset = '$costRiset',
		  cost_adv = '$costAdv'";

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as stuff_id from stuff";
	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	$stuffId  = $data['stuff_id'];

	$query = "insert stuff_category_sub_row
		set stuff_id = '$stuffId',
		  stuff_category_sub_id = '$idSubCategory1',
		  name = '$subCategory1'";

	mysql_query($query) or die (mysql_error());

	$query = "insert stuff_category_sub_row
		set stuff_id = '$stuffId',
		  stuff_category_sub_id = '$idSubCategory2',
		  name = '$subCategory2'";

	mysql_query($query) or die (mysql_error());

	$query = "insert stuff_category_sub_row
		set stuff_id = '$stuffId',
		  stuff_category_sub_id = '$idSubCategory3',
		  name = '$subCategory3'";

	mysql_query($query) or die (mysql_error());

	$query = "insert stuff_history
		set stuff_id = '$stuffId',
		  tipe = '1',
		  amount = '$stock',
		  date = now(),
		  description = '::STOK AWAL::'";

	mysql_query($query) or die (mysql_error());


	if(isset($_POST['submitCopy'])) {
	    $query = "select max(id) as last_id from stuff";
		$tmp = mysql_query($query) or die (mysql_error());	    
		$data = mysql_fetch_array($tmp);
		$lastId  = $data['last_id'];

		include '../lib/connection-close.php';
		header('Location:add.php?msg=addSuccess&id='.$lastId);
	} else {
		include '../lib/connection-close.php';
		header('Location:index.php?msg=addSuccess');
	}
?>
