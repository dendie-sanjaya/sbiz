<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$userLogin = $_SESSION['login'];

	$id	 = general::secureInput($_POST['id']);
	$salesOrderDetailId = $_POST['salesOrderDetailId'];
	$customerRespon = $_POST['customerRespon']; 
	$customerRatting = $_POST['customerRatting'];
	$statusAfterSale = general::secureInput($_POST['statusAfterSale']);


	$statusAfterSaleBreakDown = '';
	if($statusAfterSale == '1') {
		if(isset($_REQUEST['checkboxSedangProses'])) {
		  $statusAfterSaleBreakDown .= general::secureInput($_REQUEST['checkboxSedangProses']).'~';
		}

		if(isset($_REQUEST['checkboxSudahAdaTesti'])) {
		  $statusAfterSaleBreakDown .= general::secureInput($_REQUEST['checkboxSudahAdaTesti']).'~';
		}

		if(isset($_REQUEST['checkboxBlmAdaRespon'])) {
		  $statusAfterSaleBreakDown .= general::secureInput($_REQUEST['checkboxBlmAdaRespon']).'~';
		}
	}

	$query = "update sales_order
		  set status_respon_customer = '$statusAfterSale',
		  	 status_respon_customer_breakdown = '$statusAfterSaleBreakDown'
			where id = '$id'";
	mysql_query($query) or die (mysql_error());
		

	$i = 0;
	foreach($salesOrderDetailId as $val) {
		$detailId = general::secureInput($val);
		$tmpCustomerRespon =  general::secureInput($customerRespon[$i]); 	
		$tmpCustomerRatting =  general::secureInput($customerRatting[$i]);

		$query = "update sales_order_detail
			set customer_respon = '$tmpCustomerRespon',
			  customer_rate = '$tmpCustomerRatting'
			where id = '$detailId'";
		mysql_query($query) or die (mysql_error());		


	    if(isset($_POST['customerResponUploadDelete_'.$detailId])) {
		    $target_dir = __DIR__."/screenshoot/";		

		    if(file_exists($target_dir.$_POST['customerResponUploadDelete_'.$detailId])) {
				unlink($target_dir.$_POST['customerResponUploadDelete_'.$detailId]);		
		    }	

			$query = "update sales_order_detail
				set customer_respon_screenshoot_upload = null
				where id = '$detailId'";
			mysql_query($query) or die (mysql_error());		
	    }	

	    if($_FILES["customerResponUpload"]["name"][$i]) {
		   $target_dir = __DIR__."/screenshoot/";		
		   $target_file = $target_dir . basename($_FILES["customerResponUpload"]["name"][$i]);
		   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		   $screenshootName = 'screenshoot_'.$detailId.'.'.$imageFileType;		
		   if (move_uploaded_file($_FILES["customerResponUpload"]["tmp_name"][$i], $target_dir.$screenshootName)) {
				$query = "update sales_order_detail
					set customer_respon_screenshoot_upload = '$screenshootName'
					where id = '$detailId'";
				mysql_query($query) or die (mysql_error());		
		   }   
	    }		

		$i++;
	}


	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess&keyword='.$_REQUEST['keyword'].'&status='.$_REQUEST['status'].'&dateFrom='.$_REQUEST['dateFrom'].'&dateTo='.$_REQUEST['dateTo'].'&statusResponCustomerBreakdown='.$_REQUEST['statusResponCustomerBreakdown']);
?>
