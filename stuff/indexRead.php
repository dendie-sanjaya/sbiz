<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

	$keyword = general::secureInput(str_replace(' ','',trim($_REQUEST['keyword'])));
	$categoryId = isset($_REQUEST['categoryId']) ? general::secureInput($_REQUEST['categoryId']) : 'x';
	$record = isset($_GET['SplitRecord']) ? general::secureInput($_GET['SplitRecord']) : 0;
	$categorySubRowJoin = array();
	$categorySubRowJoin[] = $_REQUEST['categorySubRow1'] != 'x' ? general::secureInput($_REQUEST['categorySubRow1']) : '';
	$categorySubRowJoin[] = $_REQUEST['categorySubRow2'] != 'x' ? general::secureInput($_REQUEST['categorySubRow2']) : '';
	$categorySubRowJoin[] = $_REQUEST['categorySubRow3'] != 'x' ? general::secureInput($_REQUEST['categorySubRow3']): '';
	$categorySubRowJoin = array_values(array_filter($categorySubRowJoin));

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	//$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : " and category_id in ($loginAccessCategory) ";
	$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : " ";
	
	if(count($categorySubRowJoin) > 0) {
	        $categorySubRowJoinStr = implode(',',$categorySubRowJoin);
			$query = "select s.id, s.sku, s.name, s.stock, s.stock_min_alert, s.price, s.price_basic, s.nickname, s.fee_sales, s.is_hidden,
				(select name from location as c where c.id = location_id) as location_name,					     
				(select name from const as c where c.id = const_id) as const_name,
				(select name from stuff_category as sc where sc.id = category_id) as category_name					
			from stuff as s
			inner join stuff_category_sub_row as row
  			  on row.stuff_id = s.id
			where s.is_delete = '0'
			and (replace(s.name, ' ', '' ) like '%$keyword%' or replace(s.nickname, ' ', '' ) like '%$keyword%') or replace(s.sku, ' ', '' ) like '%$keyword%') 			  
			  $where
			order by s.name
			limit $record,25";		

			$data = mysql_query($query) or die(mysql_error());
				
			$query = "select count(id) as total
				from stuff		
				where is_delete = '0'
				and (replace(s.name, ' ', '' ) like '%$keyword%' or replace(s.nickname, ' ', '' ) like '%$keyword%') or replace(s.sku, ' ', '' ) like '%$keyword%') 			  
				  $where
				order by name";

			$dataTotal = mysql_query($query) or die(mysql_error());
			$total = mysql_fetch_array($dataTotal);

			$split = new Split('index.php',$total['total'],25,25);
	} else {
			$query = "select id, sku, name, stock, stock_min_alert, price, price_basic, nickname, fee_sales, is_hidden,
				(select name from location as c where c.id = location_id) as location_name,					     
				(select name from const as c where c.id = const_id) as const_name,
				(select name from stuff_category as sc where sc.id = category_id) as category_name					
			from stuff		
			where is_delete = '0'
			and (replace(name, ' ', '' ) like '%$keyword%' or replace(nickname, ' ', '' ) like '%$keyword%' or replace(sku, ' ', '' ) like '%$keyword%' ) 
			  $where
			order by name
			limit $record,25";		

			$data = mysql_query($query) or die(mysql_error());
				
			$query = "select count(id) as total
				from stuff		
				where is_delete = '0'
				and (replace(name, ' ', '' ) like '%$keyword%' or replace(nickname, ' ', '' ) like '%$keyword%' or replace(sku, ' ', '' ) like '%$keyword%' ) 
				  $where
				order by name";

			$dataTotal = mysql_query($query) or die(mysql_error());
			$total = mysql_fetch_array($dataTotal);

			$split = new Split('index.php',$total['total'],25,25);
	}


	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());

	$query = "select id , name
		from stuff_category_sub
		where stuff_category_id ='$categoryId'";
	$dataSubCategory = mysql_query($query) or die (mysql_error());		
	
	//include '../lib/connection-close.php';
?>
