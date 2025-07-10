<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';	

 
	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('01/m/Y');
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  =  general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  =  general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$keyword =  general::secureInput(str_replace(' ','',trim($_REQUEST['keyword'])));
	$status = isset($_REQUEST['status']) ?  general::secureInput($_REQUEST['status']) : '0';
	$record = isset($_GET['SplitRecord']) ?  general::secureInput($_GET['SplitRecord']) : 0;
	$clientId = isset($_REQUEST['clientId']) ? (is_array($_REQUEST['clientId']) ? $_REQUEST['clientId'] : explode(',',$_REQUEST['clientId'])) : array();

	$salesId = $_SESSION['loginMemberId'];
	$positionId = $_SESSION['loginPosition'];

	$where = '';
	$whereAfterSaleBreakDown = '';
	$statusAfterSaleBreakDown = isset($_GET['statusResponCustomerBreakdown']) ? $_GET['statusResponCustomerBreakdown'] : '';
	if(strlen($statusAfterSaleBreakDown) == '0') {
		if($status == '1') {
			if(isset($_REQUEST['checkboxBlmAdaRespon'])) {
			  $statusAfterSaleBreakDown .= general::secureInput($_REQUEST['checkboxBlmAdaRespon']).'~';
			  $tmpStatusAdtrSalesBreakDown = general::secureInput($_REQUEST['checkboxBlmAdaRespon']);
			  $whereAfterSaleBreakDown .= " and status_respon_customer_breakdown like '%$tmpStatusAdtrSalesBreakDown%'";		  
			}

			if(isset($_REQUEST['checkboxSudahAdaTesti'])) {
			  $statusAfterSaleBreakDown .= general::secureInput($_REQUEST['checkboxSudahAdaTesti']).'~';
			  $tmpStatusAdtrSalesBreakDown = general::secureInput($_REQUEST['checkboxSudahAdaTesti']);
			  $whereAfterSaleBreakDown .= " and status_respon_customer_breakdown like '%$tmpStatusAdtrSalesBreakDown%'";
			}

			if(isset($_REQUEST['checkboxSedangProses'])) {
			  $statusAfterSaleBreakDown .= general::secureInput($_REQUEST['checkboxSedangProses']).'~';
			  $tmpStatusAdtrSalesBreakDown = general::secureInput($_REQUEST['checkboxSedangProses']);
			  $whereAfterSaleBreakDown .= " and status_respon_customer_breakdown like '%$tmpStatusAdtrSalesBreakDown%'";
			}
		}
	} else {
		$arrStatusAdtrSalesBreakDown = explode('~',$_REQUEST['statusResponCustomerBreakdown']);
		foreach($arrStatusAdtrSalesBreakDown as $tmpStatusAdtrSalesBreakDown) {
		   $whereAfterSaleBreakDown .= " and status_respon_customer_breakdown like '%$tmpStatusAdtrSalesBreakDown%'";			
		}
	}	
	$_REQUEST['statusResponCustomerBreakdown'] = $statusAfterSaleBreakDown;


	if(!in_array($positionId,array('1','5'))) {
		$where .= $salesId != '1'? " and sales_id = '$salesId' " : "";	
	}	

	$query = "select id, name, phone,address
	          from client		
	          where is_delete = '0'";
	$tmpClient = mysql_query($query) or die(mysql_error());
	$clientIdStr = implode($clientId,',');	

	if(count($clientId) > 0) {
		$where .= $clientId != 'x'? " and c.id in ($clientIdStr) " : ""; 
	}	

	$clientIdDefault = array();
	while($valClient = mysql_fetch_array($tmpClient)) {
	  $clientIdDefault[] = $valClient['id'];	  		
	}			
	$clientId = count($clientId) == 0 ? $clientIdDefault : $clientId;


	$query = "select so.id, no_order, client_id, period_order_id, so.name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, is_warehouse_external,
			date_order, date_packing, date_payment, date_shipping, status_order, so.phone, discount_persen, status_payment, discount_amount,
			(select r.name from reseller as r where r.id = reseller_id) as reseller_name, is_reseller,			
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
			(select m.name from member as m where m.id = sales_id) as sales_name,
			(select w.name from warehouse_external as w where w.id = warehouse_external_id) as warehouse_external_name,									
			date_format(date_order,'%d-%m-%Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			no_resi, c.name as client_name,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml
		from sales_order as so
		left join client as c
		  on c.id = so.client_id
		  and c.is_delete = '0'
		where so.is_delete = '0'
		  and (replace(so.name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '3'
		  and status_payment = '1'
		  and status_close = '0'
		  and status_complate_stuff = '1'
		  and status_respon_customer  = '$status'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')			  		  		  
		  $where
		  and (1=1 $whereAfterSaleBreakDown)
		order by date_order asc, date_shipping asc, no_order asc, name asc
		limit $record,200";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(so.id) as total
		from sales_order as so
		left join client as c
		  on c.id = so.client_id
		  and c.is_delete = '0'
		where so.is_delete = '0'
		  and (replace(so.name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '3'
		  and status_payment = '1'
		  and status_close = '0'
		  and status_complate_stuff = '1'
		  and status_respon_customer  = '$status'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')			  		  		  
		  and (1=1 $whereAfterSaleBreakDown)
		  $where";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],200,25);

	$query = "select id, name, phone,address
	          from client		
	          where is_delete = '0'";
	$cmbClient = mysql_query($query) or die(mysql_error());

?>
