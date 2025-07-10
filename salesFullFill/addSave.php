<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	

	$salesOrderId = $_REQUEST['salesOrderId'];
	$actionType = $_REQUEST['actionType'];
	
	if(count($salesOrderId) > 0) { 
		foreach($salesOrderId  as $val) {
			if($actionType == '1') {
				$query = "update sales_order
					set status_complate_stuff = '1'		
					where id = '$val'";
				mysql_query($query) or die (mysql_error());	
			} 
			if($actionType == '0') {			
				$query = "update sales_order
					set sstatus_complate_stuff = '0'
					where id = '$val'";
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
