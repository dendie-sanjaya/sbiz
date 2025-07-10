<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$stuffBundlingId = general::secureInput($_POST['stuffBundlingId']);
	$stuffIdChoose  = $_POST['stuffIdChoose'];
	
	foreach($stuffIdChoose as $val) {
	    $discountVal = general::secureInput($_POST['discount_val_'.$val]);
	    $discountType = general::secureInput($_POST['discount_type_'.$val]);	
	    $price = general::secureInput($_POST['price_'.$val]);
	    $feeSales = general::secureInput($_POST['fee_sales_'.$val]);	
	    $qty = general::secureInput($_POST['qty_'.$val]);	

	    if($discountType == 0) {
		    $query = "update stuff_bundling_detail
				set price = '$price',	
				  fee_sales = '$feeSales',	
				  discount_percent = '$discountVal',	
				  discount_type = '0',
				  qty = '$qty'
				where stuff_bundling_id = '$stuffBundlingId'
				  and id = '$val'";
	    } else {
		    $query = "update stuff_bundling_detail
				set price = '$price',	
				  fee_sales = '$feeSales',	
				  discount_nominal = '$discountVal',	
				  discount_type = '1',
				  qty = '$qty'				  
				where stuff_bundling_id = '$stuffBundlingId'
				  and id = '$val'";
	    }

		mysql_query($query) or die (mysql_error());
	}	

	$query = "select sum(stuff_bundling_detail.price * stuff_bundling_detail.qty) as total_price,   
	 		   sum(stuff_bundling_detail.fee_sales) as total_fee_sales,
	 		   sum(price_basic * stuff_bundling_detail.qty) as total_price_basic   	
			 from stuff_bundling_detail
			 left join stuff as s 
			   on s.id = stuff_bundling_detail.stuff_id
			 where stuff_bundling_id = '$stuffBundlingId'";
	$rst = mysql_query($query) or die (mysql_error());		 
	$dataSumStuff = mysql_fetch_array($rst);

    $query = "update stuff_bundling
			set price = '{$dataSumStuff['total_price']}',	
			  price_basic = '{$dataSumStuff['total_price_basic']}',	
			  fee_sales = '{$dataSumStuff['total_fee_sales']}'			  
			where id = '$stuffBundlingId'";

	mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
	header('Location:stuff.php?msg=editSuccess&id='.$stuffBundlingId);?>
