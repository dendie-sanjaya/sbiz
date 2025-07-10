<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';

	$periodeOrderId = isset($_REQUEST['periodeOrderId']) ? $_REQUEST['periodeOrderId'] : 'x';	
	$where .= $periodeOrderId != 'x' ? " and so.period_order_id = '$periodeOrderId'" : "";	
	
	$query = "select s.name as stuff_name, s.nickname, sum(sod.amount) as amount_total, sod.stuff_id,
			(select c.name from const as c where c.id = s.const_id) as satuan,
			 sod.price, sod.price_basic
		from sales_order_detail as sod	
		inner join sales_order as so
		  on so.id = sod.sales_order_id 
		  $where
		inner join stuff as s
		  on s.id = sod.stuff_id
		where so.is_delete = '0'
		  and so.status_payment = '1'
		  and so.status_complate_stuff = '0'
		  and so.tipe_order = '1'
		  and so.status_close = '0'

		group by s.id
		order by amount_total desc, s.category_id, s.name";

	$data = mysql_query($query) or die(mysql_error());

	$query = "select id, name
	from period_order		
	where is_delete = '0' 
	 and is_status = '0'
	order by name";

	$dataPeriodeOrder = mysql_query($query) or die (mysql_error());	
	
	$query = "select id, name, date_format(date_start,'%d/%m/%Y') as date_start,date_format(date_end,'%d/%m/%Y') as date_end	
	from period_order		
	where id= '$periodeOrderId'";

	$tmp = mysql_query($query) or die (mysql_error());	
	$periodeName = mysql_fetch_array($tmp);
	
	include '../lib/connection-close.php';
?>
