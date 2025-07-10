<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$isReseller = isset($_REQUEST['isReseller']) ? $_REQUEST['isReseller'] : 'x';
	$tipeOrder = isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : 'x';
	$stuffId = $_REQUEST['stuffId'];	
	$statusOrder = isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : '0';
	$statusPayment = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : 'x';

	$where = '';

	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment '" : "";	
	if($statusOrder == 'x') {
		$where .= " ";
	} else if ($statusOrder == '4') {
		$where .= " and status_order in ('4')";	
	} else {
		$where .= " and status_order in ('0','1','2','3')";	
	}
	/*
	$where .= $tipeOrder != 'x' ? " and tipe_order = '$tipeOrder '" : "";
	
	if($isReseller == 'x') {
		$where .= " ";
	} else if ($isReseller == '0') {
		$where .= " and client_id > 0 ";	
	} else {
		$where .= " and client_id = 0 ";		
	}
	*/
					
	$query = "select so.id, sod.amount, sod.stuff_id, so.name as nama_pembeli,
				so.no_order, date_format(so.date_order,'%d-%m-%Y') as date_order, sod.name,
				sod.name, sod.nickname
			  from sales_order_detail as sod 
			  inner join sales_order as so
				on so.id = sod.sales_order_id
				  and so.is_delete = '0'
				  and so.status_complate_stuff = '1'
			  where sod.stuff_id = '$stuffId'
				$where
				and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
			  order by sod.amount desc";	

	$data = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
