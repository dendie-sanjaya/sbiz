<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';


	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$periodeStatus = isset($_REQUEST['periodeStatus']) ? $_REQUEST['periodeStatus'] : '0';
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where .= $statusPeriode != 'x' ? " and is_status = '$periodeStatus'" : " is_status = '0'";
	
	$query = "select id, name, date_format(date_start,'%d %M %Y') as date_start_frm,
			 date_format(date_end,'%d %M %Y') as date_end_frm,is_status
		from period_order		
		where is_delete = '0'
		and replace(name, ' ', '' ) like '%$keyword%' 
		  $where
		order by is_status asc, date_start desc
		limit $record,25";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from period_order		
		where is_delete = '0'
		and name like '%$keyword%'
		  $where
		order by name";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);	
	include '../lib/connection-close.php';
?>
