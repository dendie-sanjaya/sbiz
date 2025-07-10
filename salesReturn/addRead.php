<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';	

	$_REQUEST['purchaseOrderName'] = isset($_REQUEST['purchaseOrderName']) ? general::secureInput($_REQUEST['purchaseOrderName']) : '';	
	$_REQUEST['dateOrder'] = isset($_REQUEST['dateOrder']) ? general::secureInput($_REQUEST['dateOrder']) : date('d/m/Y');	
	$_REQUEST['tipeOrder'] = isset($_REQUEST['tipeOrder']) ? general::secureInput($_REQUEST['tipeOrder']) : 0; 
	$_REQUEST['clientId'] = isset($_REQUEST['clientId']) ? general::secureInput($_REQUEST['clientId']) : 0;
	$tipeOrder = $_REQUEST['tipeOrder'];
	$msgError = array();
	$statusdiTemukan = 0;

	if(isset($_REQUEST['cari'])) {		
		$salesOrder = trim($_REQUEST['purchaseOrderName']);
		
		$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
		description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
		date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment, expedition_id,
		date_format(date_order,'%d/%m/%Y') as date_order_frm, no_resi, status_close,is_warehouse_external, 
		date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
		date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
		date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
		status_marketplace, marketplace,country, province, districts, districts_sub, postal_code,
		status_respon_customer,status_respon_customer_breakdown 
		from sales_order		
		where no_order = '$salesOrder'
		and is_return = '0'";

		$tmp = mysql_query($query) or die (mysql_error());
		$dataHeader = mysql_fetch_array($tmp);	

		$query = "select id, stuff_id, price_basic, price, amount, 
			discount_persen, discount_money, name, nickname, is_bundling,
			customer_respon, customer_rate, customer_respon_screenshoot_upload	
		from sales_order_detail
		where sales_order_id = '{$dataHeader['id']}'
		order by id asc";

		$dataDetail = mysql_query($query) or die (mysql_error());
		
		$query = "select id, name, phone
		from client		
		where is_delete = '0' 
		 and id = '{$dataHeader['client_id']}'
		order by name, phone";

		$cmbClient = mysql_query($query) or die (mysql_error());

		$query = "select id, name
		from expedition		
		where is_delete = '0' 
		order by name";

		$cmbExpedition = mysql_query($query) or die (mysql_error());
		
		$query = "select id, name, phone,address
		from client		
		where id = '$clientId'";

		$tmp = mysql_query($query) or die (mysql_error());
		$dataClient = mysql_fetch_array($tmp);

		$query = "select id, name
		from warehouse_external		
		where is_delete = '0' 
		order by name";

		$cmbWarehouseExternal = mysql_query($query) or die (mysql_error());

		
		if(strlen($dataHeader['no_order']) > 0) {	
			$_POST['name'] = strlen($_POST['name']) > 0 ? $_POST['name'] : $datasalesOrder['name'];
			$_POST['phone'] = strlen($_POST['phone']) > 0 ? $_POST['phone'] : $datasalesOrder['phone']; 
			$_POST['address'] = strlen($_POST['address']) > 0 ? $_POST['address'] : $datasalesOrder['address_shipping'];				
			$statusdiTemukan = 1;
		} else {
			$msgError['cari'] = 'No sales Order tidak ditemukan';
			$statusdiTemukan = 0;
		}
	}	
	
	include '../lib/connection-close.php';
?>
