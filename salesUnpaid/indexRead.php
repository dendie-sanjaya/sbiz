<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	


	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$salesId = $_SESSION['loginMemberId'];
	$positionId = $_SESSION['loginPosition'];

	//if($positionId != '1') {
	if(!in_array($positionId,array('1','4','5'))) {	
		$where .= $salesId != '1'? " and sales_id = '$salesId' " : "";	
	}	

	if(isset($_REQUEST['strSalesId'])) {
		$salesId = explode(',',$_REQUEST['strSalesId']);
		$strSalesId = $_REQUEST['strSalesId'];
		$query = "select id,name from member 
		 		  where id in ($strSalesId)";
		$salesName = mysql_query($query) or die(mysql_error());	
	} else {
		$salesId = isset($_REQUEST['salesId']) ? $_REQUEST['salesId'] : array(); 
		$strSalesId = implode(',',$salesId); 		
	}

	$where .= count($salesId) > 0 ? " and sales_id in ($strSalesId)" : "";	

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			(select r.name from reseller as r where r.id = reseller_id) as reseller_name, is_reseller, is_warehouse_external,			
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,						
			(select m.name from member as m where m.id = sales_id) as sales_name,	
			(select w.name from warehouse_external as w where w.id = warehouse_external_id) as warehouse_external_name,			
			date_format(date_order,'%d %M %Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml
		from sales_order
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '4'
		  and status_payment = '0'
		  $where
		order by date_order, no_order, name
		limit $record,300";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from sales_order		
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '1'
		  and status_payment = '1'
		  $where
		order by name";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],100,25);

	$query = "select id,name from member 
	 		  where position_id in (1,3) order by name";
	$cmbSales = mysql_query($query) or die(mysql_error());	

	include '../lib/connection-close.php';
?>
