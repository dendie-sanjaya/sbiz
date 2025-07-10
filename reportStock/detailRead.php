<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';


	$stuffId = $_REQUEST['stuffId'];
	
	$query = "select id, name, stock, stock_min_alert, const_id, nickname,
		  (select name from stuff_category as sc where sc.id = category_id) as category_name
		from stuff
		where id = '$stuffId'";

	$tmp = mysql_query($query);
	$dataStuff = mysql_fetch_array($tmp);

	$query = "select sh.id, sh.stuff_id, sh.tipe, sh.amount, sh.description, date_format(sh.date,'%d %M %Y') as date, s.name,
		   (select c.name from const as c where c.id = s.const_id) as const_name,
		   (select s.name from suplier as s where s.id = sh.suplier_id) as suplier_name,
		   (select k.name from client as k where k.id = sh.client_id) as client_name		   
		from stuff_history as sh
		inner join stuff as s
		  on s.id = sh.stuff_id	
		where sh.is_delete = '0'
		and sh.stuff_id = '$stuffId'
		order by sh.date desc, id desc
		limit 0,50";

	$data = mysql_query($query) or die(mysql_error());


	include '../lib/connection-close.php';
?>
