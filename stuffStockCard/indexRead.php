<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';

	$_REQUEST['operator'] =  isset($_REQUEST['operator']) ? $_REQUEST['operator'] : '2';   
	$_REQUEST['stock'] =  isset($_REQUEST['stock']) ? $_REQUEST['stock'] : '-1';   
	
	$keyword = str_replace(' ','',$_REQUEST['keyword']);
	$operator = isset($_REQUEST['operator']) ? $_REQUEST['operator'] : '2';
	$stock = isset($_REQUEST['stock']) ? $_REQUEST['stock'] : '-1';
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : explode(',',$_REQUEST['categoryIdChoose']) ;	

	if(count($categoryId) > 0) {
		$categoryIdChoose = '';
		foreach($categoryId as $val) {
			$categoryIdChoose = $categoryIdChoose.$val.',';
		}
		$categoryIdChoose = substr($categoryIdChoose,0,strlen($categoryIdChoose)-1);
	} else {
		$categoryIdChoose = $_REQUEST['categoryIdChoose'] ;
	}

	$fundId = isset($_REQUEST['fundId']) ? $_REQUEST['fundId'] : 'x';	
 	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	//$where .= $categoryId != 'x' ? " and category_id in ($categoryIdChoose )" : " and category_id in ($loginAccessCategory) ";
	//$where .= $categoryId != 'x' ? " " : " and category_id in ($loginAccessCategory) ";
	//$where .= strlen($categoryIdChoose) > 0 ? " and category_id in ($categoryIdChoose)" : " and category_id in ($loginAccessCategory) ";

	$where .= strlen($categoryIdChoose) > 0 ? " and category_id in ($categoryIdChoose)" : " ";

	if($operator == '4') {
		$where .= " and stock_min_alert >= stock ";

	} else {
		if($operator == '1') {
			$operatorStock = '=';
		}

		if($operator == '2') {
			$operatorStock = '>';
		}

		if($operator == '3') {
			$operatorStock = '<';
		}

		$where .=  "  and stock $operatorStock $stock ";
	}

	$record = isset($_GET['SplitRecord']) ? strlen($_GET['SplitRecord']) > 0 ? $_GET['SplitRecord'] : 0 : 0;
	$recordMax = isset($_GET['recordMax']) ? strlen($_GET['recordMax']) > 0 ? $_GET['recordMax'] : 25 : 25;

	$query = "select id, name, stock, stock_min_alert, price, price_basic, nickname, fee_sales,
			(select name from location as c where c.id = location_id) as location_name,					     
			(select name from const as c where c.id = const_id) as const_name,
			(select name from stuff_category as sc where sc.id = category_id) as category_name
		from stuff		
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(nickname, ' ', '' ) like '%$keyword%') 
		  $where
		order by category_name, name
		limit $record,$recordMax ";

	$data = mysql_query($query) or die(mysql_error().'asd');
	
	$query = "select count(id) as total
		from stuff		
		where is_delete = '0'
		and (replace(name, ' ', '' ) like '%$keyword%' or replace(nickname, ' ', '' ) like '%$keyword%') 
		  $where

		order by name";
	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);


	$query = "select count(id) as total
		from stuff		
		where is_delete = '0'
		  $where";

	$query = mysql_query($query) or die(mysql_error());
	$tmp = mysql_fetch_array($query);
	$dataTotalAssetItem = $tmp['total'];


	$query = "select sum(stock * price) as total,
		sum(stock * price_basic) as total_basic
		from stuff		
		where is_delete = '0'
		  $where";

	$query = mysql_query($query) or die(mysql_error());
	$tmp = mysql_fetch_array($query);
	$dataTotalAssetValue = $tmp['total'];
	$dataTotalAssetValueBasic = $tmp['total_basic'];

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());


	//$whereCategoryPrint .= strlen($categoryIdChoose) > 0 ? " and id in ($categoryIdChoose)" : " and id in ($loginAccessCategory) ";

	$whereCategoryPrint .= strlen($categoryIdChoose) > 0 ? " and id in ($categoryIdChoose)" : " ";


	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  $whereCategoryPrint
		order by name";
	$dataCategoryPrint = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';
?>
