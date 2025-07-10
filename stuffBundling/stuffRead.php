<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	


	$id = general::secureInput($_REQUEST['id']);

	$query = "select id, name, price, category_id, price_min,
		  price_basic, nickname, fee_sales, is_hidden,
		  (select name from stuff_category as sc where sc.id = stuff_bundling.category_id) as category_name		  
		from stuff_bundling
		where id = '$id'";
	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	$query = "select sb.id,sb.price, sb.fee_sales, sb.discount_percent, sb.discount_nominal, sb.discount_type, sb.qty, 
			 s.name, s.price_basic as price_basic, s.nickname, s.price_basic, s.price as price_normal, s.fee_sales as fee_sales_basic,
			(select name from stuff_category as sc where sc.id = category_id) as category_name,
			(select name from const as c where c.id = const_id) as const_name
		from stuff as s	
		inner join stuff_bundling_detail as sb
		  on sb.stuff_id = s.id
		where sb.stuff_bundling_id = '$id'
		order by s.category_id, s.name";
	$dataStuff = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';
?>
