<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/general.class.php';
	
	$salesOrderId = $_REQUEST['salesOrderId'];
	$actionType = general::secureInput($_REQUEST['actionType']);
	$userLogin = $_SESSION['login'];	

	if(count($salesOrderId) > 0) { 
		$i=0;

		$query = "select id, username
		          from user
				  where username = '$userLogin' ";
		$tmpSale = mysql_query($query) or die (mysql_error());	
		$dataUser = mysql_fetch_array($tmpSale);
		$historyUserId = $dataUser['id'];

		foreach($salesOrderId  as $val) {
			if($actionType == '1') {
				$query = "update sales_order
					set status_receipt_cod = '1',
					date_receipt_cod = now()					
					where id = '$val'";
				mysql_query($query) or die (mysql_error());									
			} 
			$i++;	
		} 

		include '../lib/connection-close.php';
		header('Location:index.php?msg=addSuccess');
	} else {
		include '../lib/connection-close.php';
		header('Location:index.php?msg=dataEmptyFailed&msgType=error');
	}	
?>
