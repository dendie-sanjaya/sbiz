<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';


	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	
	$type = $_REQUEST['type'];
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';	

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$where = $type != 3 ? " and sh.tipe = '$type'" : "";		
	$where .= $categoryId != 'x' ? " and s.category_id = '$categoryId'" : " and s.category_id in ($loginAccessCategory) ";

	

	$query = "select sh.id, sh.stuff_id, sh.tipe, sh.amount, sh.description, date_format(sh.date,'%d %M %Y') as date, s.name, sh.price,
		   (select c.name from const as c where c.id = s.const_id) as const_name, 
		   (select s.name from suplier as s where s.id = sh.suplier_id) as suplier_name,
		   (select k.name from client as k where k.id = sh.client_id) as client_name,
			(select name from stuff_category as sc where sc.id = s.category_id) as category_name
		from stuff_history as sh
		inner join stuff as s
		  on s.id = sh.stuff_id	
		where sh.is_delete = '0'
		and (sh.date >= '$dateFrom' and sh.date <= '$dateTo')
		$where		
		order by sh.date, sh.id ";

	$data = mysql_query($query) or die(mysql_error());

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());

	$query = "select id,name 
		from stuff_category
		where id = '$categoryId'";
	$tmp = mysql_query($query) or die (mysql_error());
	$printDataCategory = mysql_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
