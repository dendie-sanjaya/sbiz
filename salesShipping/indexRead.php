<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';	

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	$orderBy = isset($_REQUEST['orderBy']) ? general::secureInput($_REQUEST['orderBy']) : 'expedition_name';
	$paymentId = isset($_REQUEST['paymentId']) ? $_REQUEST['paymentId'] : array();
	$expeditionId = isset($_REQUEST['expeditionId']) ? $_REQUEST['expeditionId'] : array();

	//print_r($paymentId); exit;	
	$where = '';
	if(count($paymentId) > 0) {
		$implode = implode(',',$paymentId);
		$where .= " and fin_source_fund_id in ($implode) ";
	}

	if(count($expeditionId) > 0) {
		$implode = implode(',',$expeditionId); 
		$where .= " and expedition_id in ($implode) ";
	}


	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			(select r.name from reseller as r where r.id = reseller_id) as reseller_name, is_reseller,			
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
			(select m.name from member as m where m.id = sales_id) as sales_name,						
			date_format(date_order,'%d-%m-%Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			no_resi,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml
		from sales_order
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '2'
		  and status_payment = '1'
		  and status_close = '0'
		  and status_complate_stuff = '1'
		  and is_warehouse_external = '0'
		  $where
		order by $orderBy asc, date_order_frm asc, name asc
		limit $record,10000";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from sales_order		
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '2'
		  and status_payment = '1'
		  and status_close = '0'
		  and status_complate_stuff = '1'
		order by name";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],100,25);

	$query = "select id, name
	from expedition		
	where is_delete = '0' 
	order by name";
	$cmbExpedition = mysql_query($query) or die (mysql_error());

	$query = "select id, name
	from fin_source_fund		
	where is_delete = '0'
	order by name";
	$cmbFoundSource = mysql_query($query) or die (mysql_error());

?>
