<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];
	
	$query = "select id,name,cost_cs,cost_ops,cost_riset,cost_adv 
		from stuff_category
		where id='$id'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	$query = "select id,name
		from stuff_category_sub
		where stuff_category_id='$id'";

	$dataSubCategory = mysql_query($query);

	include '../lib/connection-close.php';
?>