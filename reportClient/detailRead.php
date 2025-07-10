<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$clientId = $_REQUEST['clientId'];	
					
	$query = "select s.id, s.no_order, c.id as client_id, c.name, sum(s.amount_sale) as total_pembelian,
		sum((amount_sale / 100) * discount_persen) as total_diskon,
		sum(shipping_cost) as total_pengiriman,
		date_format(date_order,'%d/%m/%Y') as date_order_frm
		from client as c
		left join sales_order s
			on s.client_id = c.id
			and c.is_delete = '0'
		where s.is_delete = '0'	
		  and (s.date_payment >= '$dateFrom' and s.date_payment <= '$dateTo')
		  and s.client_id = '$clientId'
		  group by s.id
		order by date_order, total_pembelian desc, no_order ";
		
	$data = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
