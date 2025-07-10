<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include 'editValidate.php';
	include '../lib/connection.php';

	$id	 = $_POST['id'];
	$tipeOrder = $_POST['tipeOrder'];
	$clientId = $_POST['clientId'];
	$periodeOrderId = ($tipeOrder == '0') ? 0 : $_POST['periodeOrderId']; 
	//$periodeOrderId = 1;
	
	$name = $_POST['name'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	
	$statusOrder = $_POST['statusOrder'];	
	$statusPayment = $_POST['statusPayment'];	
	$tmp = explode('/',$_REQUEST['dateOrder']);
	$dateOrder  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['datePacking']);
	$datePacking  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['datePayment']);
	$datePayment = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateShipping']);
	$dateShipping = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$descriptionPayment = $_POST['descriptionPayment'];
	$descriptionShipping = $_POST['descriptionShipping'];
	$statusClose = $_POST['statusClose'];
	$noResi = $_POST['noResi'];
	$complateStuff = $_POST['complateStuff'];

	$discount	 = abs($_POST['discount']);
	$costShipping	 = $_POST['costShipping'];

	$year = date('y');	
	$query = "select max(no_order) + 1 as no_new
			  from sales_order 
			  where substr(no_order,1,2) = '$year'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataNoOrder =  mysql_fetch_array($tmp); 
	$noOrder = $dataNoOrder['no_new']; 
	
	$query = "update sales_order
		  set client_id = '$clientId',
		  period_order_id = '$periodeOrderId',
		  name = '$name',
		  phone = '$phone',
		  address_shipping = '$address',
		  description_payment = '$descriptionPayment',
		  description_shipping = '$descriptionShipping',
		  discount_persen = '$discount',
		  shipping_cost = '$costShipping',
		  tipe_order = '$tipeOrder',
		  date_shipping = '$dateShipping',
		  date_packing = '$datePacking',
		  date_payment = '$datePayment',
		  date_order = '$dateOrder',
		  status_order = '$statusOrder',
		  status_payment = '$statusPayment',
		  status_close = '$statusClose',
		  status_complate_stuff = '$complateStuff',
		  no_resi = '$noResi'
			where id = '$id'";
	
	mysql_query($query) or die (mysql_error());

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

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
