<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	


	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			(select m.name from member as m where m.id = sales_id) as sales_name,
			(select r.name from reseller as r where r.id = reseller_id) as reseller_name, is_reseller,	
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,											
			date_format(date_order,'%d %M %Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml
		from sales_order
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '0'
		  and is_cod = '0'
		order by date_order, no_order, name
		limit $record,10000";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from sales_order		
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '0'
		order by name";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],100,25);

	include '../lib/connection-close.php';
?>
