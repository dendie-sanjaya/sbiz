<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	

	$salesOrderId = $_REQUEST['salesOrderId'];
	$actionType = $_REQUEST['actionType'];
	$userLogin = $_SESSION['login'];	
		
	if(count($salesOrderId) > 0) { 
		$query = "select id, username
		          from user
				  where username = '$userLogin' ";
		$tmpSale = mysql_query($query) or die (mysql_error());	
		$dataUser = mysql_fetch_array($tmpSale);
		$historyUserId = $dataUser['id'];

		foreach($salesOrderId  as $val) {
			if($actionType == '1') {
				$query = "update sales_order
					set status_order = '2',
					date_packing = now()					
					where id = '$val'";
				mysql_query($query) or die (mysql_error());	

				$query = "select id, no_order 
				          from sales_order 
						  where id = '$val' ";
				$tmpSale = mysql_query($query) or die (mysql_error());	
				$dataSale = mysql_fetch_array($tmpSale);
				$historySalesOrderId = $dataSale['id'];
				$historySalesOrderNoOrder = $dataSale['no_order'];

				$query = "select id, username
				          from user
						  where username = '$userLogin' ";
				$tmpSale = mysql_query($query) or die (mysql_error());	
				$dataUser = mysql_fetch_array($tmpSale);
				$historyUserId = $dataUser['id'];

				$query = "insert sales_order_history
					set sales_order_id = '$historySalesOrderId',
					  no_sales_order = '$historySalesOrderNoOrder',
					  activity = '2',
					  datetime_track = now(),
					  user_id  = '$historyUserId'
					on duplicate key update 
					  datetime_track = now(),
					  user_id  = '$historyUserId'
					";
				mysql_query($query) or die (mysql_error());					
			} 

			if($actionType == '3') {			
				$query = "update sales_order
					set status_order = '0',
					 status_payment = '0'					
					where id = '$val'";
				mysql_query($query) or die (mysql_error());				

				$query = "delete from sales_order_history
						  where sales_order_id = '$val'
					      and activity = '1' ";
				mysql_query($query) or die (mysql_error());					
			}
		} 

		include '../lib/connection-close.php';
		header('Location:index.php?msg=addSuccess');
	} else {
		include '../lib/connection-close.php';
		header('Location:index.php?msg=dataEmptyFailed&msgType=error');
	}	
?>
