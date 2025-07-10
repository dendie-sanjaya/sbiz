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
	$phone = general::secureInput($_REQUEST['phone']);	

	$where = '';
	//$where .= $statusOrder != 'x' ? " and status_order = '$statusOrder '" : "";	
	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment '" : "";	

	//(((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as total_nilai
	$query = "select id, no_order, name, phone,
				(amount_sale + shipping_cost) as total_nilai,	            
	            date_format(date_order,'%d %M %Y') as date_order_frm,
	            (select m.name from member as m where m.id = so.sales_id) as sales_name
			  from sales_order as so
			  where so.phone = '$phone'
	  			and so.is_delete = '0'		
				$where
				and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
			  order by so.date_order,so.no_order  ";	

	$data = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
