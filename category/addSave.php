<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$name = general::secureInput($_POST['name']);
	$subCategory1 = general::secureInput($_POST['subCategory1']);
	$subCategory2 = general::secureInput($_POST['subCategory2']);
	$subCategory3 = general::secureInput($_POST['subCategory3']);

	$query = "insert stuff_category
		set name = '$name',
		  cost_cs = '$costCs',
		  cost_ops = '$costOps',
		  cost_riset = '$costRiset',
		  cost_adv = '$costAdv'";		
	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as last_id
		from stuff_category";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataLastId = mysql_fetch_array($tmp);
	$lastId = $dataLastId['last_id'];

	$query = "insert stuff_category_sub
		set stuff_category_id = '$lastId',
		  name = '$subCategory1'";		
	mysql_query($query) or die (mysql_error());

	$query = "insert stuff_category_sub
		set stuff_category_id = '$lastId',
		  name = '$subCategory2'";		
	mysql_query($query) or die (mysql_error());

	$query = "insert stuff_category_sub
		set stuff_category_id = '$lastId',
		  name = '$subCategory3'";		
	mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from stuff_category
		where is_delete = '0'
		order by name";

	$data = mysql_query($query) or die (mysql_error());

	while($val = mysql_fetch_array($data)) {
		$category .= $val['id'].'~';
	}

	$query = "update member
		set access_category_id = '$category'
		where id='1'";

	mysql_query($query) or die (mysql_error());

	$_SESSION['loginAccessCategory'] = $category;

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
