<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_POST['id']);
	$name = general::secureInput($_POST['name']);
	$countryCode = general::secureInput($_POST['countryCode']);
	$phone = general::secureInput($_POST['phone']);
	$city = general::secureInput($_POST['city']);
	$email = general::secureInput($_POST['email']);
	$password = general::secureInput(trim($_POST['password']));
	$isActive = general::secureInput($_POST['isActive']);
	$isDropshipper = general::secureInput($_POST['isDropshipper']);	
	
		$query = "update reseller
		set name = '$name',
		  country_code = '$countryCode',
		  phone_number= '$phone',
		  city = '$city',	
		  email = '$email',
		  date_input = now(),
		  is_active = '$isActive',		  
		  is_delete = '0',
		  is_dropshipper = '$isDropshipper'		  
	    where id = '$id'";		

	mysql_query($query) or die (mysql_error());

	if(strlen($password) > 0) {
		$password = md5($password); 
		echo $query = "update reseller
			set password = '$password'
		    where id = '$id'";		

		mysql_query($query) or die (mysql_error());
	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
