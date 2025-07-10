<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('d/m/Y');
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$clientId = isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : 'x';
	$tipeOrder = isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : 'x';
	$statusOrder = isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : 'x';
	$statusPayment = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : 'x';
	$statusClose = isset($_REQUEST['statusClose']) ? $_REQUEST['statusClose'] : '0';
	
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where .= $tipeOrder != 'x' ? " and tipe_order = '$tipeOrder '" : "";
	$where .= $statusOrder != 'x' ? " and status_order = '$statusOrder' " : "";
	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment' " : "";
	$where .= $statusClose != 'x' ? " and status_close = '$statusClose' " : "";
	$where .= $clientId != 'x'? " and reseller_id = '$clientId' " : "";

	$positionId = $_SESSION['loginPosition'];

	$query = "select id, name
	          from reseller		
	          where is_delete = '0'";
	$cmbClient = mysql_query($query) or die(mysql_error());

	
	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order, expedition_id,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost,sales_id,
			(select m.name from reseller as m where m.id = reseller_id) as reseller_name,
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			date_format(date_order,'%d %M %Y') as date_order_frm, 
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi, is_cod,
			( (amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as jml
		from sales_order
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%'
		  or replace(no_resi, ' ', '' ) like '%$keyword%' )
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')
		  and is_reseller = '1'		   
		  $where
		order by date_order asc, no_order asc, name
		limit $record,50";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from sales_order		
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%'
		  or replace(no_resi, ' ', '' ) like '%$keyword%')
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')		   
		  and is_reseller = '1'		   		  
		  $where";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],50,25);

	include '../lib/connection-close.php';
?>
