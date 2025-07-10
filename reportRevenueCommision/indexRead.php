<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';
	include '../lib/split.class.php';	

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tipeOrder = isset($_REQUEST['tipeOrder']) ? general::secureInput($_REQUEST['tipeOrder']) : 'x';
	$statusOrder = isset($_REQUEST['statusOrder']) ? general::secureInput($_REQUEST['statusOrder']) : 'x'; 
	$statusPayment = isset($_REQUEST['statusPayment']) ? general::secureInput($_REQUEST['statusPayment']) : 'x';
	$statusCommission  = isset($_REQUEST['statusCommission']) ? general::secureInput($_REQUEST['statusCommission']) : 'x';

	if(isset($_REQUEST['strResellerId'])) {
		$salesId = explode(',',$_REQUEST['strResellerId']);
		$strSalesId = $_REQUEST['strResellerId'];
		$query = "select id,name from reseller 
		 		  where id in ($strSalesId)";
		$resellerName = mysql_query($query) or die(mysql_error());	
	} else {
		$resellerId = isset($_REQUEST['resellerId']) ? $_REQUEST['resellerId'] : array(); 
		$strResellerId = implode(',',$resellerId); 		
	}

	$where = '';
	$where .= $statusOrder != 'x' ? " and status_order = '$statusOrder' " : "";	
	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment' " : "";	
	$where .= $statusCommission != 'x' ? " and status_payment_commision_reseller = '$statusCommission' " : "";	
	$where .= count($resellerId) > 0 ? " and reseller_id in ($strResellerId) " : "";	

	/*
	$query = "select id, count(id) as total_transaction, reseller_id,status_payment_commision_reseller,
	          sum((amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as total_nilai,  
			  (select m.name from reseller as m where m.id = sales_order.reseller_id) as reseller_name,
			  reseller_id,date_format(date_order,'%d %M %Y') as date_order_frm,
	          date_format(date_order,'%d%/%m/%Y') as date_order_frm_2,			   
			  sum(amount_fee_reseller) as total_fee_reseller,
			  (select sum(sod.amount * sod.reseller_point) from sales_order_detail as sod where sod.sales_order_id = sales_order.id) as total_poin
		from sales_order
		where is_delete = '0'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')
		  and is_reseller = '1'
		  $where
		group by reseller_id   
		order by reseller_name asc, total_transaction desc, total_nilai desc ,total_fee_reseller desc";
	$data = mysql_query($query) or die(mysql_error());	
	*/

	$query = "select sales_order.id, count(sales_order.id) as total_transaction, reseller_id,status_payment_commision_reseller,
	          sum((amount_sale - ((amount_sale / 100) * sales_order.discount_persen)) + shipping_cost) as total_nilai,  
			  (select m.name from reseller as m where m.id = sales_order.reseller_id) as reseller_name,
			  reseller_id,date_format(date_order,'%d %M %Y') as date_order_frm,
	          date_format(date_order,'%d%/%m/%Y') as date_order_frm_2,			   
			  sum(amount_fee_reseller) as total_fee_reseller,
			  sum(sod.amount * sod.reseller_point)  as total_poin
		from sales_order
		inner join sales_order_detail as sod
		  on sod.sales_order_id = sales_order.id
		where is_delete = '0'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')
		  and is_reseller = '1'
		  $where
		group by reseller_id   
		order by reseller_name asc, total_transaction desc, total_nilai desc ,total_fee_reseller desc";
	$data = mysql_query($query) or die(mysql_error());	
		
	$query = "select id,name from reseller
	 		  where is_delete = '0'";
	$cmbReseller = mysql_query($query) or die(mysql_error());	

	include '../lib/connection-close.php';
?>
