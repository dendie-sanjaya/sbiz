<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']);

	$query = "select r.id, r.name, r.phone_number, r.country_code, r.city, r.date_input, r.last_login, username, email,
			    date_format(r.date_input,'%d %M %Y') as date_input_format,
			    date_format(r.last_login,'%d %M %Y') as last_login_format, is_active, is_dropshipper
			  from reseller as r
		  	  where is_delete = '0' 	 
		  	   and id = '$id'
			 ";
	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	
	include '../lib/connection-close.php';
?>
