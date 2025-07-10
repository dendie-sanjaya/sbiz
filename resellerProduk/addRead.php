<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

	$resellerId = general::secureInput(str_replace(' ','',trim($_REQUEST['resellerId'])));	
	$keyword = general::secureInput(str_replace(' ','',trim($_REQUEST['keyword'])));
	$categoryId = isset($_REQUEST['categoryId']) ? general::secureInput($_REQUEST['categoryId']) : 'x';
	$record = isset($_GET['SplitRecord']) ? general::secureInput($_GET['SplitRecord']) : 0;

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : " ";
	
	$query = "select s.id, s.name, s.stock, s.stock_min_alert, s.price, s.price_basic, s.nickname, s.fee_sales, s.is_hidden,
			(select name from location as c where c.id = location_id) as location_name,	s.price as price_publish, 				     
			(select name from const as c where c.id = const_id) as const_name,
			(select name from stuff_category as sc where sc.id = category_id) as category_name								
		from stuff as s		
		where s.is_delete = '0'
		and s.is_hidden = '0'
		and s.id not in (select rs.stuff_id from reseller_stuff as rs where reseller_id = '$resellerId' and rs.is_delete = '0')
		and (replace(s.name, ' ', '' ) like '%$keyword%' or replace(s.nickname, ' ', '' ) like '%$keyword%') 
		  $where
		order by category_id, name
		limit $record,100";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from stuff		
		where is_delete = '0'
		and name like '%$keyword%'
		and is_hidden = '0'		
		  $where
		order by name";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('add.php',$total['total'],100,25);

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	

	include '../lib/connection-close.php';	
?>
