<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';	

	$keyword = general::secureInput(str_replace(' ','',trim($_REQUEST['keyword'])));
	$record = isset($_GET['SplitRecord']) ? general::secureInput($_GET['SplitRecord']) : 0;
	$limit = isset($_REQUEST['print']) ? '' : "limit $record,50";	

	$query = "select r.id, r.name, r.phone_number, r.country_code, r.city, r.date_input, r.last_login, username, email,
			   date_format(r.date_input,'%d %M %Y') as date_input_format,
			   date_format(r.last_login,'%d %M %Y') as last_login_format, is_dropshipper
			  from reseller as r
		  	  where is_delete = '0' 	 
		  	  and (  (replace(name, ' ', '' ) like '%$keyword%') 
			  	      or (replace(concat(r.	country_code,r.	phone_number), ' ', '' ) like '%$keyword%')
			  	      or (replace(email, ' ', '' ) like '%$keyword%')
			  	      or (concat(r.	country_code,r.	phone_number) like '%$keyword%')
			  	   )	
		  	  $limit
			 ";
	$data = mysql_query($query) or die (mysql_error());

	$query = "select count(r.id) as total
			  from reseller as r
		  	  where is_delete = '0' 	 
		  	  and ((replace(name, ' ', '' ) like '%$keyword%') 
			  	  or (replace(concat(r.	country_code,r.	phone_number), ' ', '' ) like '%$keyword%')
			  	  or (replace(email, ' ', '' ) like '%$keyword%')
			  	  or (concat(r.	country_code,r.	phone_number) like '%$keyword%'))	
			 ";
	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],50,50);
?>
