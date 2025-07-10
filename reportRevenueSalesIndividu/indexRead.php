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
	$isReseller = isset($_REQUEST['isReseller']) ? general::secureInput($_REQUEST['isReseller']) : 'x';
	$tipeOrder = isset($_REQUEST['tipeOrder']) ? general::secureInput($_REQUEST['tipeOrder']) : 'x';
	$statusOrder = isset($_REQUEST['statusOrder']) ? general::secureInput($_REQUEST['statusOrder']) : 'x'; 
	$statusPayment = isset($_REQUEST['statusPayment']) ? general::secureInput($_REQUEST['statusPayment']) : 'x'; 
	$salesId = $_SESSION['loginMemberId'];


	$where = '';
	$where .= $statusOrder != 'x' ? " and status_order = '$statusOrder '" : "";	
	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment '" : "";	
	$where .= count($salesId) > 0 ? " and sales_id in ($salesId)" : "";	

	$query = "select id, sales_id, count(id) as total_transaction,
	          sum(((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as total_nilai,  
			  (select m.name from member as m where m.id = sales_order.sales_id) as sales_name,
			  date_order, date_format(date_order,'%d %M %Y') as date_order_format, 
	          date_format(date_order,'%d/%m/%Y') as date_order_frm_2,			  
			  sum((select sum(sd.fee_sales * sd.amount) as total from sales_order_detail as sd where sales_order_id = sales_order.id)) total_fee_sales
		from sales_order
		where is_delete = '0'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')
		  $where
		group by date_order  
		order by date_order, total_transaction desc, total_nilai desc";
	$data = mysql_query($query) or die(mysql_error());	

	include '../lib/connection-close.php';
?>
