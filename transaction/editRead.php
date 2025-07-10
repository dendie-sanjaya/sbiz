<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];

	$query = "select id, name, stock, stock_min_alert, const_id, price, category_id, nickname,
			(select name from const as c where c.id = const_id) as const_name,
			(select name from stuff_category as sc where sc.id = category_id) as category_name
		from stuff
		where id = '$id'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);


	$query = "select id,name 
		from suplier
		where is_delete = '0'
		order by name";

	$dataSuplier = mysql_query($query) or die (mysql_error());


	$query = "select id,name 
		from client
		where is_delete = '0'
		order by name";

	$dataClient = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';
?>
