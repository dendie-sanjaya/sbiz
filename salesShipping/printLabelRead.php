<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	

	$salesOrderId = $_REQUEST['salesOrderId'];
	$id = implode(",",$salesOrderId);		

	$query = "select so.id, so.name, so.address_shipping, so.phone, so.no_order,is_reseller, 
		  (select e.name from expedition as e where e.id = so.expedition_id) as expedition_name,
		  (select m.name from member as m where m.id = so.sales_id) as sales_name,
		  (select m.phone from member as m where m.id = so.sales_id) as sales_phone,
		  (select r.name from reseller as r where r.id = so.reseller_id) as reseller_name,
		  (select r.phone_number from reseller as r where r.id = so.reseller_id) as reseller_phone,
		  is_cod,amount_reseller_to_customer, date_format(date_order,'%d-%m-%Y') as date_order_format,
		  postal_code, province, city, districts, districts_sub,
		  platform_market_id, is_dropshipper, dropshipper_name, dropshipper_address, dropshipper_phone	  		  		  
		from sales_order as so
		where so.is_delete = '0'
		and so.id in ($id)	
		order by date_order, no_order, name";
	$data = mysql_query($query) or die(mysql_error());
	
	//include '../lib/connection-close.php';		
?>
