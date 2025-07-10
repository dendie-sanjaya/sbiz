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
	$where .= $clientId != 'x'? " and client_id = '$clientId' " : "";

	$salesId = $_SESSION['loginMemberId'];
	$positionId = $_SESSION['loginPosition'];

	//if($positionId != '1') {
	if(!in_array($positionId,array('1','4','5'))) {	
		$where .= $salesId != '1'? " and sales_id = '$salesId' " : "";	
	}	

	$query = "select id, name, phone,address
	          from client		
	          where is_delete = '0'";
	$cmbClient = mysql_query($query) or die(mysql_error());

	
	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order, expedition_id, is_delete,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost,sales_id,
			(select m.name from member as m where m.id = sales_id) as sales_name,is_warehouse_external,
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
			(select w.name from warehouse_external as w where w.id = warehouse_external_id) as warehouse_external_name,
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			date_format(date_order,'%d %M %Y') as date_order_frm, 
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml
		from sales_order
		where is_delete = '1'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%'
		  or replace(no_resi, ' ', '' ) like '%$keyword%' )
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')	
		  and is_reseller = '0'
		  and is_delete_permanent= '0'
		  $where
		order by date_order asc, no_order asc, name
		limit $record,200";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from sales_order		
		where is_delete = '1'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%'
		  or replace(no_resi, ' ', '' ) like '%$keyword%')
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')		   
		  and is_reseller = '0'
		  and is_delete_permanent = '0'
		  $where";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],200,25);

	include '../lib/connection-close.php';
?>
