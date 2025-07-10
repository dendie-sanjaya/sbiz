<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$categoryId = $_POST['categoriId'];
	$salesId = general::secureInput($_POST['salesId']);
	$name = general::secureInput($_POST['name']);
	$countryCode = general::secureInput($_POST['countryCode']);
	$phone = general::secureInput($_POST['phone']);
	$city = general::secureInput($_POST['city']);
	$tmp = explode('/',$_REQUEST['dateInput']);
	$dateInput  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];	
		
	$query = "insert customer
		set sales_id = '$salesId',
		  name = '$name',
		  country_code = '$countryCode',
		  phone_number= '$phone',
		  city = '$city',	
		  date_input = '$dateInput',
		  is_delete = '0'";		

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as id
		from customer";		

	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	$customerId = $data['id'];


	foreach($categoryId as $val) { 
		$valTmp = general::secureInput($val);
		$query = "insert customer_group
				  set customer_id = '$customerId',
				    client_id = '$valTmp'";		

		mysql_query($query) or die (mysql_error());
	}	

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
