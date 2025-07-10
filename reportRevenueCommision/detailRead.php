<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';
	include '../lib/general.class.php';


	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$statusOrder = isset($_REQUEST['statusOrder']) ? general::secureInput($_REQUEST['statusOrder']) : 'x';
	$statusPayment = isset($_REQUEST['statusPayment']) ? general::secureInput($_REQUEST['statusPayment']) : 'x';
	$statusCommission  = isset($_REQUEST['statusCommission']) ? general::secureInput($_REQUEST['statusCommission']) : 'x';	
	$resellerId = $_REQUEST['resellerId'];

	$where = '';
	$where .= $statusOrder != 'x' ? " and status_order = '$statusOrder' " : "";	
	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment' " : "";	
	$where .= $statusCommission != 'x' ? " and status_payment_commision_reseller = '$statusCommission' " : "";	

					
	$query = "select so.id, no_order, so.name,
	            ((amount_sale - ((amount_sale / 100) * so.discount_persen)) + shipping_cost) as total_nilai,
	            date_format(date_order,'%d %M %Y') as date_order_frm,
	            amount_fee_reseller,
	            (sod.amount * sod.reseller_point) as total_poin
			  from sales_order as so
			  left join sales_order_detail as sod
		  	  on sod.sales_order_id = so.id			  
			  where so.reseller_id = '$resellerId'
	  			and so.is_delete = '0'		
	  			and so.is_reseller = '1'
				$where
				and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
			  order by so.date_order,so.no_order  ";	

	$data = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
