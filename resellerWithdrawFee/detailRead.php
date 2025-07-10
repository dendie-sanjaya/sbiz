<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']);
					
	$query = "select w.id,w.sales_order_id,w.sales_order_number,w.amount_fee_reseller,
	       so.name, so.date_order, so.no_order,
	       date_format(so.date_order,'%d %M %Y') as date_order_frm
		from reseller_withdraw_fee_detail as w
		inner join sales_order as so
		on so.id = w.sales_order_id 
		where w.reseller_withdraw_fee_id = '$id'
		order by so.date_order asc, so.no_order asc, so.name";


	$data = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
