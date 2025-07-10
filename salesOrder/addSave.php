<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';


	$salesId = $_SESSION['loginMemberId'];
	$tipeOrder = general::secureInput($_POST['tipeOrder']);
	$clientId = general::secureInput($_POST['clientId']);
	$periodeOrderId = ($tipeOrder == 0) ? 0 : general::secureInput($_POST['periodeOrderId']);
	
	$name = general::secureInput($_POST['name']);
	$address = general::secureInput($_POST['address']);
	$phone = general::secureInput($_POST['phone']);
	$tmp = explode('/',$_REQUEST['dateOrder']);
	$dateOrder  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

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
		  sales_id = '$salesId',
		  no_order = '$noOrder',
		  name = '$name',
		  phone = '$phone',
		  address_shipping = '$address',
		  tipe_order = '$tipeOrder',
		  date_order = '$dateOrder'";

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as id from sales_order";
	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	$salesOrderId  = $data['id'];

	$countryCode = substr($phone,0,2); 
	$phoneSplit = substr($phone,2); 

	$query = "select count(*) as total  
	          from customer
		  	  where is_delete = '0'
		  	  and country_code = '$countryCode'
		  	  and phone_number ='$phoneSplit'";		

	$tmp = mysql_query($query) or die (mysql_error());
	$dataPhoneCheck = mysql_fetch_array($tmp);

	if($dataPhoneCheck['total']  == 0) {
		$query = "insert customer
			set sales_id = '$salesId',
			  name = '$name',
			  country_code = '$countryCode',
			  phone_number= '$phoneSplit',
			  city = '',	
			  date_input = now(),
			  is_delete = '0'";		

		mysql_query($query) or die (mysql_error());		

		$query = "select max(id) as id
			from customer";		

		$tmp = mysql_query($query) or die (mysql_error());
		$data = mysql_fetch_array($tmp);
		$customerId = $data['id'];

		$query = "insert customer_group
				  set customer_id = '$customerId',
				    client_id = '$clientId'";		

		mysql_query($query) or die (mysql_error());
	}


	include '../lib/connection-close.php';

	header('Location:edit.php?id='.$salesOrderId);
?>
