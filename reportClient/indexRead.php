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
	
	$where .= $tipeOrder != 'x' ? " and tipe_order = '$tipeOrder '" : "";
	
	if($isReseller == 'x') {
		$where .= " ";
	} else if ($isReseller == '0') {
		$where .= " and client_id > 0 ";	
	} else {
		$where .= " and client_id = 0 ";		
	}
	
	$query = "select s.id, c.id as client_id, c.name, sum(s.amount_sale) as total_pembelian,
		sum((amount_sale / 100) * discount_persen) as total_diskon,
		sum(shipping_cost) as total_pengiriman
		from client as c
		left join sales_order s
			on c.id = s.client_id 
			and c.is_delete = '0'
		where s.is_delete = '0'	
		  and (s.date_payment >= '$dateFrom' and s.date_payment <= '$dateTo')
		  $where
		group by s.client_id  
		order by total_pembelian desc, c.name";

	$data = mysql_query($query) or die(mysql_error());
	
	include '../lib/connection-close.php';
?>
