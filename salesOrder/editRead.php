<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';


	$id = general::secureInput($_REQUEST['id']); 

	$query = "select id, no_order, client_id, period_order_id, warehouse_external_id, name, address_shipping, tipe_order,
		description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, fin_source_fund_id,
		date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, discount_amount, status_payment, expedition_id, packing_option,
		date_format(date_order,'%d/%m/%Y') as date_order_frm, no_resi, status_close, is_warehouse_external, 
		country, province, city, districts, districts_sub, service_option,
		date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
		date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
		date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, 
		status_marketplace, marketplace, country, province, city, districts, districts_sub, postal_code,
		(select dc.code from district as dc where dc.id = sales_order.disctrict_id) as districts_code,
		platform_market_id, is_dropshipper, dropshipper_name, dropshipper_address, dropshipper_phone,
		shipping_cost_before_discount,  shipping_cost_discount,  platform_market_fee_percent 
	from sales_order
	where id = '$id'";

	$tmp = mysql_query($query) or die (mysql_error());
	$dataHeader = mysql_fetch_array($tmp);

	
	$_REQUEST['tipeOrder'] = isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : $dataHeader['tipe_order']; 
	$_REQUEST['clientId'] = isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : $dataHeader['client_id'];
	$clientId = $_REQUEST['clientId'];
	$tipeOrder = $_REQUEST['tipeOrder'];
	$is_dropshipper = isset($_REQUEST['is_dropshipper']) ? $_REQUEST['is_dropshipper'] : $dataHeader['is_dropshipper']; 


	$query = "select id, stuff_id, price_basic, price, amount, 
		discount_persen, discount_money, name, nickname, is_bundling,
		(select st.sku from stuff as st where st.id = sales_order_detail.stuff_id) as sku
	from sales_order_detail
	where sales_order_id = '$id'
	order by id asc";

	$dataDetail = mysql_query($query) or die (mysql_error());
	
	$query = "select id, name
	from period_order		
	where is_delete = '0' 
	 and is_status = '0'
	order by name";

	$dataPeriodeOrder = mysql_query($query) or die (mysql_error());

	$query = "select id, name, phone
	from client		
	where is_delete = '0' 
	order by name, phone";

	$cmbClient = mysql_query($query) or die (mysql_error());

	$query = "select id, name
	from expedition		
	where is_delete = '0' 
	order by name";

	$cmbExpedition = mysql_query($query) or die (mysql_error());


	$query = "select id, name
	from warehouse_external		
	where is_delete = '0' 
	order by name";

	$cmbWarehouseExternal = mysql_query($query) or die (mysql_error());
	

	$query = "select id, name, phone,address
	from client		
	where id = '$clientId'";

	$tmp = mysql_query($query) or die (mysql_error());
	$dataClient = mysql_fetch_array($tmp);

	$query = "select id, name
	from fin_source_fund		
	where is_delete = '0'
	order by name";

	$dataFoundSource = mysql_query($query) or die (mysql_error());


	$query = "select id,name,fee_admin_percent
		from platform_market
		where is_delete = '0'
		  and is_marketplace = '1'
		order by name";
	$cmbPlatformMarket = mysql_query($query) or die (mysql_error());


	/*	
	if($clientId != '0') {	
		if($_REQUEST['hiddenClientId'] != $clientId ) {
			$_POST['name'] = $dataClient[1];
			$_POST['phone'] = $dataClient[2]; 
			$_POST['address'] = $dataClient[3];		
		} else {
			$_POST['name'] = strlen($_POST['name']) > 0 ? $_POST['name'] : $dataClient[1];
			$_POST['phone'] = strlen($_POST['phone']) > 0 ? $_POST['phone'] : $dataClient[2]; 
			$_POST['address'] = strlen($_POST['address']) > 0 ? $_POST['address'] :$dataClient[3];
		}
	} else { 
			$_POST['name'] = strlen($_POST['name']) > 0 ? $_POST['name'] : $dataHeader['name'];
			$_POST['phone'] = strlen($_POST['phone']) > 0 ? $_POST['phone'] : $dataHeader['phone']; 
			$_POST['address'] = strlen($_POST['address']) > 0 ? $_POST['address'] : $dataHeader['addressShipping'];
	}
	*/
		
	include '../lib/connection-close.php';
?>
