<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';


	$stuffId = $_REQUEST['stuffId'];
	
	$query = "select id, name, stock, stock_min_alert, const_id
		from stuff
		where id = '$stuffId'";

	$tmp = mysql_query($query);
	$dataStuff = mysql_fetch_array($tmp);

	$query = "select sh.id, sh.stuff_id, sh.tipe, sh.amount, sh.description, date_format(sh.date,'%d %M %Y') as date, s.name,
		   (select c.name from const as c where c.id = s.const_id)
		from stuff_history as sh
		inner join stuff as s
		  on s.id = sh.stuff_id	
		where sh.is_delete = '0'
		and sh.stuff_id = '$stuffId'
		order by sh.date desc
		limit 0,50";

	$data = mysql_query($query) or die(mysql_error());


	include '../lib/connection-close.php';
?>
