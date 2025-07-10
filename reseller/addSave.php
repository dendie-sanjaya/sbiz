<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$name = general::secureInput($_POST['name']);
	$countryCode = general::secureInput($_POST['countryCode']);
	$phone = general::secureInput($_POST['phone']);
	$city = general::secureInput($_POST['city']);
	$email = general::secureInput($_POST['email']);
	$username = trim(general::secureInput($_POST['username']));
	$password = general::secureInput(trim(md5($_POST['password'])));
	$isActive = general::secureInput($_POST['isActive']);
	$isDropshipper = general::secureInput($_POST['isDropshipper']);
		
	$query = "insert reseller
		set name = '$name',
		  country_code = '$countryCode',
		  phone_number= '$phone',
		  city = '$city',	
		  email = '$email',	
		  username = '$username',	
		  password = '$password',	
		  date_input = now(),
		  is_dropshipper = '$isDropshipper',
		  is_active = '$isActive',		  
		  is_delete = '0'";		

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
