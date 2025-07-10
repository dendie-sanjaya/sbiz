<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';	

	$resellerId = general::secureInput($_REQUEST['resellerId']);

	$query = "select r.id, r.name, r.phone_number, r.country_code, r.city, r.date_input, r.last_login, 	username, email,
			   date_format(r.date_input,'%d %M %Y') as date_input_format,
			   date_format(r.last_login,'%d %M %Y') as last_login_format
			  from reseller as r
		  	  where is_delete = '0'
		  	   and id = '$resellerId' 	 
			 ";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataReseller = mysql_fetch_array($tmp);

	$query = "select rs.id as reseller_stuff_id, s.name, s.price_basic as price_basic_store, s.nickname, s.is_hidden,
			(select name from const as c where c.id = const_id) as const_name, point, s.price as price_publish,
			(select name from stuff_category as sc where sc.id = category_id) as category_name,
			rs.link_product_brosur, rs.price_basic as price_basic_reseller, rs.fee_reseller_nominal, rs.fee_reseller_percent,
			rs.is_delete								
		from stuff as s	
		inner join reseller_stuff as rs
		  on rs.stuff_id = s.id
		where s.is_delete = '0'
		  and rs.reseller_id = '$resellerId'
		  and rs.is_delete = '0'
		order by s.category_id, s.name";
	$data = mysql_query($query) or die (mysql_error());
?>
