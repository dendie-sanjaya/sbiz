<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/general.class.php';

	$resellerId = general::secureInput($_POST['resellerId']);
	$resellerBankTo	 = general::secureInput($_POST['resellerBankTo']);
	$fromBank = general::secureInput($_POST['fromBank']);
	$resellerTotalTransfer  = general::secureInput($_POST['resellerTotalTransfer']);
	$resellerDateTransfer = general::secureInput($_POST['resellerDateTransfer']); 
	$tmp = explode('/',$_REQUEST['resellerDateTransfer']);
	$resellerDateTransfer  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$salesOrderId  = $_POST['salesOrderId'];

	$year = date('y');	
	$query = "select concat('CM',max(substr(no_payment,3,8)) + 1) as no_new
			  from reseller_withdraw_fee 
			  where substr(no_payment,3,2) = '$year'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataNoOrder =  mysql_fetch_array($tmp); 
	$noOrder = $dataNoOrder['no_new']; 
	
	if(strlen($noOrder) < 1) {
		$noOrder = 'CM'.$year.'000001';
	}

	$query = "insert reseller_withdraw_fee 
		set reseller_id = '$resellerId',
		  reseller_bank_id = '$resellerBankTo',
		  no_payment = '$noOrder',
		  from_bank = '$fromBank',
		  total_withdraw = '$resellerTotalTransfer',
		  date_transfer = '$resellerDateTransfer',
		  date_input = now(),
		  is_delete = '0'";

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as id from reseller_withdraw_fee ";
	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	$resellerWithdrawFeeId  = $data['id'];


	foreach($salesOrderId as $val) {
		$tmp = explode('-',$val);
		$noSalesOrderId = $tmp[0];
		$noSalesOrderNumber = $tmp[1];
		$commision = $tmp[2];

	    $query = "insert reseller_withdraw_fee_detail 
			set reseller_withdraw_fee_id = '$resellerWithdrawFeeId',
			  sales_order_id = '$noSalesOrderId',
			  sales_order_number = '$noSalesOrderNumber',
			  amount_fee_reseller = '$commision'";

		mysql_query($query) or die (mysql_error());

	    $query = "update sales_order 
			set status_payment_commision_reseller = '1'
			where id = '$noSalesOrderId'";

		mysql_query($query) or die (mysql_error());

	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&dateFrom='.$_REQUEST['dateFrom'].'&dateTo='.$_REQUEST['dateTo'].'&resellerId='.$resellerId);
?>
