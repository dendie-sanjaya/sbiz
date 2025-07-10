<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$userLogin = $_SESSION['login'];



	$id	 = general::secureInput($_POST['id']);
	$tipeOrder = general::secureInput($_POST['tipeOrder']);
	$clientId = general::secureInput($_POST['clientId']);
	$expeditionId = general::secureInput($_POST['expeditionId']);
	$periodeOrderId = ($tipeOrder == 0) ? 0 : general::secureInput($_POST['periodeOrderId']);
	
	$name = general::secureInput($_POST['name']);
	$address = general::secureInput($_POST['address']);
	$phone = general::secureInput($_POST['phone']);

	$isWarehouseExternal = general::secureInput($_POST['isWarehouseExternal']);
	$warehouseExternalId = general::secureInput($_POST['warehouseExternalId']);
	$province = general::secureInput($_POST['province']);
	$city = general::secureInput($_POST['city']);
	$districts = general::secureInput($_POST['districts']);
	$districtsSub = general::secureInput($_POST['districtsSub']);
	$postalCode = general::secureInput($_POST['postalCode']);


	$statusMarketplace = general::secureInput($_POST['statusMarketplace']);	
	$marketplace = isset($_POST['marketplace']) ? general::secureInput($_POST['marketplace']) : '';	
	
	$statusOrder = general::secureInput($_POST['statusOrder']);	
	$statusPayment = general::secureInput($_POST['statusPayment']);	
	$tmp = explode('/',$_REQUEST['dateOrder']);
	$dateOrder  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['datePacking']);
	$datePacking  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['datePayment']);
	$datePayment = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateShipping']);
	$dateShipping = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$descriptionPayment = general::secureInput($_POST['descriptionPayment']);
	$descriptionShipping = general::secureInput($_POST['descriptionShipping']);
	$statusClose = general::secureInput($_POST['statusClose']);
	$noResi = general::secureInput($_POST['noResi']);

	$discount	 = general::secureInput(abs($_POST['discount']));
	$costShipping	 = general::secureInput($_POST['costShipping']);
	$discountAmount = general::secureInput(abs($_POST['discountAmount']));
	$packingOption  = general::secureInput(abs($_POST['packingOption']));
	$serviceOption = general::secureInput(abs($_POST['serviceOption']));
	$arrfinSourceFund = explode('~',$_POST['finSourceFundId']);
	$finSourceFundId = $arrfinSourceFund[0];
	$descriptionPayment = $arrfinSourceFund[1];

	$arrMarketplace = explode('~',$_POST['marketplaceId']);
	$marketplaceId = $arrMarketplace[0]; 
	$marketplace = $arrMarketplace[1];
	$marketplaceAdminFeePercent = $arrMarketplace[2];

	$is_dropshipper	 = isset($_POST['is_dropshipper']) ? '1' : '0';
	$dropshipper_name	 = general::secureInput($_POST['dropshipper_name']);
	$dropshipper_phone	 = general::secureInput($_POST['dropshipper_phone']);
	$dropshipper_address	 = general::secureInput($_POST['dropshipper_address']);

	$costShipping_discount = general::secureInput($_POST['costShipping_discount']);
	$costShipping_before_discount = general::secureInput($_POST['costShipping_before_discount']);

	$year = date('y');	
	$query = "select max(no_order) + 1 as no_new
			  from sales_order 
			  where substr(no_order,1,2) = '$year'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataNoOrder =  mysql_fetch_array($tmp); 
	$noOrder = $dataNoOrder['no_new']; 

	$status_payment_update = '';
	if($_SESSION['loginPosition'] == '1') {		
	  $status_payment_update  = " status_payment = '$statusPayment', " ;
	}

	if($_SESSION['loginPosition'] != '1') {		
	  $statusOrder = $statusMarketplace == '1' ? '2' : $statusOrder;	
	  $statusPayment = $statusMarketplace == '1' ? '1' : '0';	
	  $status_payment_update  = " status_payment = '$statusPayment', " ;	  	
	}

	$query = "update sales_order
		  set client_id = '$clientId',
		  expedition_id = '$expeditionId',
		  period_order_id = '$periodeOrderId',
		  fin_source_fund_id = '$finSourceFundId',
		  platform_market_id = '$marketplaceId',
		  name = '$name',
		  phone = '$phone',
		  address_shipping = '$address',
		  description_payment = '$descriptionPayment',
		  description_shipping = '$descriptionShipping',
		  discount_persen = '$discount',
		  discount_amount = '$discountAmount',
		  shipping_cost = '$costShipping',
		  tipe_order = '0',
		  date_shipping = '$dateShipping',
		  date_packing = '$datePacking',
		  date_payment = '$datePayment',
		  date_order = '$dateOrder',
		  status_order = '$statusOrder',
		  $status_payment_update
		  status_close = '0',
		  status_marketplace = '$statusMarketplace',
		  marketplace = '$marketplace',
		  no_resi = '$noResi',
		  is_dropshipper = '$is_dropshipper',
		  dropshipper_name = '$dropshipper_name',
		  dropshipper_address = '$dropshipper_address',
		  dropshipper_phone = '$dropshipper_phone',
		  shipping_cost_before_discount = '$costShipping_before_discount',
		  shipping_cost_discount = '$costShipping_discount',
		  platform_market_fee_percent = '$marketplaceAdminFeePercent'
		where id = '$id'";

	mysql_query($query) or die (mysql_error());

	if($isWarehouseExternal == 1) {
		$query = "update sales_order
			  set expedition_id = null,
			  warehouse_external_id = '$warehouseExternalId',
			  districts_sub = '', 
			  postal_code = '$postalCode',
			  is_warehouse_external = '1',
			  service_option = '$serviceOption',
			  packing_option = '$packingOption'
			  where id = '$id'";
		mysql_query($query) or die (mysql_error());		
	} else {
		$query = "update sales_order
			  set warehouse_external_id = null,
			  is_warehouse_external = '0',
			  service_option = '',			  
			  packing_option = ''
			  where id = '$id'";
		mysql_query($query) or die (mysql_error());				
	}	 

	$query = "select sum(amount * price) as total,
		  sum(amount * price_basic) as total_basic 
		from  sales_order_detail
		where sales_order_id = '$id'";
		  
	$qry = mysql_query($query) or die (mysql_error());
	$tmp = mysql_fetch_array($qry);

	$total = $tmp['total'];	
	$totalBasic = $tmp['total_basic'];	


	$query = "update sales_order
		set amount_sale = '$total',
		  amount_basic_sale = '$totalBasic'
		where id = '$id'";
	mysql_query($query) or die (mysql_error());		



	$query = "select id, no_order 
	          from sales_order 
			  where id = '$id' ";
	$tmpSale = mysql_query($query) or die (mysql_error());	
	$dataSale = mysql_fetch_array($tmpSale);
	$historySalesOrderId = $dataSale['id'];
	$historySalesOrderNoOrder = $dataSale['no_order'];


	if($statusMarketplace == '1') {	
		$query = "select id, username
		          from user
				  where username = '$userLogin' ";
		$tmpSale = mysql_query($query) or die (mysql_error());	
		$dataUser = mysql_fetch_array($tmpSale);
		$historyUserId = $dataUser['id'];

		$query = "select id, username
		          from user
				  where username = '$userLogin' ";
		$tmpSale = mysql_query($query) or die (mysql_error());	
		$dataUser = mysql_fetch_array($tmpSale);
		$historyUserId = $dataUser['id'];

		$query = "insert ignore sales_order_history
			set sales_order_id = '$historySalesOrderId',
			  no_sales_order = '$historySalesOrderNoOrder',
			  activity = '1',
			  datetime_track = now(),
			  user_id  = '$historyUserId'
			";

		mysql_query($query) or die (mysql_error());				


		$query = "insert ignore sales_order_history
			set sales_order_id = '$historySalesOrderId',
			  no_sales_order = '$historySalesOrderNoOrder',
			  activity = '2',
			  datetime_track = now(),
			  user_id  = '$historyUserId'
			";

		mysql_query($query) or die (mysql_error());				
	} else {
		$query = "delete from sales_order_history
				  where sales_order_id = '$historySalesOrderId'
			      and activity = '1' ";
		mysql_query($query) or die (mysql_error());					


		$query = "delete from sales_order_history
				  where sales_order_id = '$historySalesOrderId'
			      and activity = '2' ";
		mysql_query($query) or die (mysql_error());							
	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
