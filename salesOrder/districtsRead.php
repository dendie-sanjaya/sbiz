<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	
	$query = "select *
		from district		
		where (replace(code, ' ', '' ) like '%$keyword%' or replace(name, ' ', '' ) like '%$keyword%' or replace(city, ' ', '' ) like '%$keyword%' or replace(province, ' ', '' ) like '%$keyword%') 
		order by code
		limit $record,100";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from district		
		where (replace(code, ' ', '' ) like '%$keyword%' or replace(name, ' ', '' ) like '%$keyword%' or replace(city, ' ', '' ) like '%$keyword%' or replace(province, ' ', '' ) like '%$keyword%') 
		order by code";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('districts.php',$total['total'],100,25);
	
	include '../lib/connection-close.php';
?>
