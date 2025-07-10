<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include 'addValidate.php';
	include '../lib/connection.php';

	$tipeOrder = $_POST['tipeOrder'];
	$clientId = $_POST['clientId'];
	$periodeOrderId = ($tipeOrder == 0) ? 0 : $_POST['periodeOrderId'];
	
	$name = $_POST['name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$tmp = explode('/',$_REQUEST['dateOrder']);
	$dateOrder  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$year = date('y');	
	$query = "select max(no_order) + 1 as no_new
			  from sales_order 
			  where substr(no_order,1,2) = '$year'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataNoOrder =  mysql_fetch_array($tmp); 
	$noOrder = $dataNoOrder['no_new']; 
	
	
	if(strlen($noOrder) < 1) {
		$noOrder = $year.'000001';
	}

	$query = "insert sales_order
		set client_id = '$clientId',
		  period_order_id = '$periodeOrderId',
		  no_order = '$noOrder',
		  name = '$name',
		  phone = '$phone',
		  address_shipping = '$address',
		  tipe_order = '$tipeOrder',
		  date_order = '$dateOrder',
		  status_complate_stuff = '0'";

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as id from sales_order";
	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	$salesOrderId  = $data['id'];

	include '../lib/connection-close.php';

	header('Location:edit.php?id='.$salesOrderId);
?>
