<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';


	$keyword = general::secureInput(str_replace(' ','',trim($_REQUEST['keyword'])));
	$categoryId = isset($_REQUEST['categoryId']) ? general::secureInput($_REQUEST['categoryId']) : 'x';
	$record = isset($_GET['SplitRecord']) ? general::secureInput($_GET['SplitRecord']) : 0;

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	//$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : " and category_id in ($loginAccessCategory) ";
	$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : " ";
	
	$query = "select id, name, price, price_basic, nickname, fee_sales, is_hidden, price_min,
			(select name from stuff_category as sc where sc.id = category_id) as category_name					
		from stuff_bundling		
		where is_delete = '0'
		and (replace(name, ' ', '' ) like '%$keyword%' or replace(nickname, ' ', '' ) like '%$keyword%') 
		  $where
		order by name
		limit $record,25";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from stuff_bundling			
		where is_delete = '0'
		and name like '%$keyword%'
		  $where
		order by name";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
