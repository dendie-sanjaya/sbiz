<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	


	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$isReseller = isset($_REQUEST['isReseller']) ? $_REQUEST['isReseller'] : 'x';
	$tipeOrder = isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : 'x';
	$statusOrder = isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : 'x';
	$statusPayment = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : 'x';
	$statusClose = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusClose'] : '0';
	
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where .= $tipeOrder != 'x' ? " and tipe_order = '$tipeOrder '" : "";
	$where .= $statusOrder != 'x' ? " and status_order = '$statusOrder' " : "";
	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment' " : "";
	$where .= $statusClose != 'x' ? " and status_close = '$statusClose' " : "";

	if($isReseller == 'x') {
		$where .= " ";
	} else if ($isReseller == '0') {
		$where .= " and client_id > 0 ";	
	} else {
		$where .= " and client_id = 0 ";		
	}
	
	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			date_format(date_order,'%d %M %Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
			( (amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as jml
		from sales_order
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%'
		   or replace(no_resi, ' ', '' ) like '%$keyword%' )
		  and tipe_order = '1' 
		  $where
		order by date_order desc, name
		limit $record,25";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from sales_order		
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%'
		  or replace(no_resi, ' ', '' ) like '%$keyword%')
		  and tipe_order = '1'
		  $where
		order by date_order desc, name";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);

	include '../lib/connection-close.php';
?>
