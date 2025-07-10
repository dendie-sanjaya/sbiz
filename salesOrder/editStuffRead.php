<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	
	$id = $_REQUEST['id'];
	$qty = $_REQUEST['amount']; 
	$salesDetailId = $_REQUEST['salesDetilId'];

	$query = "select id,amount,stuff_id,is_bundling
		from sales_order_detail
		where id='$salesDetailId'";

	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);

	$query = "select id,stock
		from stuff
		where id='{$data['stuff_id']}'";

	$tmp = mysql_query($query) or die (mysql_error());
	$dataStuff = mysql_fetch_array($tmp);
	$sisaStock = $dataStuff['stock'];
	
	
	include '../lib/connection-close.php';
?>
