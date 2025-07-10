<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';


	$salesOrderId = $_REQUEST['salesOrderId'];
	$stuffBundlingId = $_REQUEST['stuffBundlingId'];
	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';
	$isBundling = 1;
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;


	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$query = "select id, category_id, name, nickname, price, price_basic, price_min, fee_sales,
		  (select name from stuff_category as sc where sc.id = category_id) as category_name					
		from stuff_bundling
		where is_delete = '0'
		 and id = '$stuffBundlingId'";
	$tmp = mysql_query($query) or die(mysql_error());			
	$dataHeader = mysql_fetch_array($tmp);

	$query = "select sb.id as stuff_bundling_id, sb.stuff_id, sb.qty as qty_max, s.name, s.*, 
		  (select name from const as c where c.id = const_id) as const_name
		from stuff_bundling_detail as sb
		inner join stuff as s 
		  on s.id = sb.stuff_id
		where s.is_delete = '0'
		 and sb.stuff_bundling_id = '$stuffBundlingId'";
	$data = mysql_query($query) or die(mysql_error());			
	
	include '../lib/connection-close.php';
?>

