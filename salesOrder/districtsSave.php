<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	
	$districtsId = general::secureInput($_REQUEST['districtsId']);
	$id = general::secureInput($_REQUEST['id']);

	$query = "select * from district
	  where id = '$districtsId'";

	$tmp = mysql_query($query) or die (mysql_error());
	$dataDistricts = mysql_fetch_array($tmp);
	$city = $dataDistricts['city'];
	$province = $dataDistricts['province'];
	$districts = $dataDistricts['name'];
	$districtCode = $dataDistricts['code'];

	$query = "update sales_order
		set disctrict_id = '$districtsId',
		  country = 'indonesia',
		  province = '$province',
		  city = '$city',
		  districts = '$districts'
		where id = '$id'";
	mysql_query($query) or die (mysql_error());	

	include '../lib/connection-close.php';
	
	include 'districtsSaveSuccess.php';	
?>
