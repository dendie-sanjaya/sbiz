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
	$isCod	 = general::secureInput($_POST['isCod']);

	$year = date('y');	
	$query = "select max(no_order) + 1 as no_new
			  from sales_order 
			  where substr(no_order,1,2) = '$year'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataNoOrder =  mysql_fetch_array($tmp); 
	$noOrder = $dataNoOrder['no_new']; 

	if($_SESSION['loginPosition'] != '1') {		
	  $statusOrder = $statusMarketplace == '1' ? '2' : $statusOrder;	
	  $statusPayment = $statusMarketplace == '1' ? '1' : '0';	
	}

	/*
	$query = "update sales_order
		  set client_id = '$clientId',
		  expedition_id = '$expeditionId',
		  period_order_id = '$periodeOrderId',
		  name = '$name',
		  phone = '$phone',
		  address_shipping = '$address',
		  description_payment = '$descriptionPayment',
		  description_shipping = '$descriptionShipping',
		  discount_persen = '$discount',
		  shipping_cost = '$costShipping',
		  tipe_order = '0',
		  date_shipping = '$dateShipping',
		  date_packing = '$datePacking',
		  date_payment = '$datePayment',
		  date_order = '$dateOrder',
		  status_order = '$statusOrder',
		  status_payment = '$statusPayment',
		  status_close = '0',
		  status_marketplace = '$statusMarketplace',
		  marketplace = '$marketplace',
		  no_resi = '$noResi'
			where id = '$id'";
	*/

	$query = "update sales_order
		  set expedition_id = '$expeditionId',
		  discount_persen = '$discount',
		  shipping_cost = '$costShipping',
		  date_shipping = '$dateShipping',
		  date_packing = '$datePacking',
		  date_payment = '$datePayment',
		  date_order = '$dateOrder',
		  status_order = '$statusOrder',
		  status_payment = '$statusPayment',
		  no_resi = '$noResi',
		  is_cod = '$isCod'
		  where id = '$id'";

	mysql_query($query) or die (mysql_error());

	/*
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
	*/
	
	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
