<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';	

	$where = $categoryId != 'x' ? " and s.category_id = '$categoryId'" : " and category_id in ($loginAccessCategory) ";

	$query = "select c.name as client_name, sum(sh.price * sh.amount) as total
		from client as c
		left join stuff_history as sh
		  on sh.client_id = c.id 
		inner join stuff as s
		  on s.id = sh.stuff_id
		  and sh.tipe = '0'
		  and sh.is_delete = '0'	
		where (sh.date >= '$dateFrom' and sh.date <= '$dateTo')
		  $where
		group by c.id		 	
		order by c.name ";

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
