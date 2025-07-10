<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];	

	$query_update_list = array();
	$mgs_stock_not_available = array();
	
	$query = "select id, stuff_id, amount, name, nickname,is_bundling
		from sales_order_detail
		where sales_order_id = '$id'";
	$dataSalesOrderDetail = mysql_query($query) or die (mysql_error());			

	while($valSalesOrderDetail	= mysql_fetch_array($dataSalesOrderDetail)) {
	
		$salesOrderDetilId = $valSalesOrderDetail['id'];	
		$qty = $valSalesOrderDetail['amount'];	
		$stuffId = $valSalesOrderDetail['stuff_id'];
		$stuffName = $valSalesOrderDetail['name'];		
		$stuffNickname = $valSalesOrderDetail['nickname'];	
		$isBundling = $valSalesOrderDetail['is_bundling'];		
	
		if($isBundling == '1') {
			$query = "select stuff_id, qty
					  from sales_order_detail_bundling
					  where sales_order_detail_id = '$salesOrderDetilId'";
			$rstSalesOrderDetailBundling = mysql_query($query) or die (mysql_error());

			while($dataSalesOrderDetailBundling = mysql_fetch_array($rstSalesOrderDetailBundling)) {
				$salesOrderDetailBundlingStuffId = $dataSalesOrderDetailBundling['stuff_id'];
				$salesOrderDetailBundlingQty = $dataSalesOrderDetailBundling['qty'];

				$query_stock = "select stock,name from stuff
					where id = '$salesOrderDetailBundlingStuffId'";
				$tmp_stock = mysql_query($query_stock) or die (mysql_error());
				$tmp_stock = mysql_fetch_array($tmp_stock);	
				$available_stock = $tmp_stock['stock'];
				$available_stock_name = $tmp_stock['name'];
				//$available_stock = 0;

				if($available_stock > $qty) {
					$qtyBundling = ($qty * $salesOrderDetailBundlingQty);
					$query = "update stuff
						set stock = stock - '$qtyBundling'
						where id = '$salesOrderDetailBundlingStuffId'";
					//mysql_query($query) or die (mysql_error());	
					$query_update_list[] = $query; 	  

					$query = "select no_order,client_id 
						from sales_order
						where id = '$id'";
					$tmp = mysql_query($query) or die (mysql_error());			
					$dataNoOrder = mysql_fetch_array($tmp);
					$noOrder = $dataNoOrder['no_order'];	
					$clientId = $dataNoOrder['client_id'];
					
					$descriptionHistory = "Restore Penjualan dgn No Sales Order : $noOrder, Produk Bundling $stuffName";
					
					$query = "insert stuff_history
						set stuff_id = '$salesOrderDetailBundlingStuffId',
						  tipe = '0',
						  amount = '$qtyBundling',
						  date = now(),
						  description = '$descriptionHistory',
						  price = '$price',	
						  client_id = '$clientId',
						  sales_order_id = '$id'";		
					$query_update_list[] = $query; 	  
					//mysql_query($query) or die (mysql_error());	
				} else {
			  	  $mgs_stock_not_available[] = "Bundling $stuffName untu produk $available_stock_name tidak mencukupi, dibutuhkan: $salesOrderDetailBundlingQty pcs (Available Stock : $available_stock pcs)";
				}		
			}	

		} else {	
			$query_stock = "select stock from stuff
				where id = '$stuffId'";
			$tmp_stock = mysql_query($query_stock) or die (mysql_error());
			$tmp_stock = mysql_fetch_array($tmp_stock);	
			$available_stock = $tmp_stock['stock'];
			//$available_stock = 0;

			if($available_stock > $qty) {
				$query = "update stuff
					set stock = stock - '$qty'
					where id = '$stuffId'";
				//mysql_query($query) or die (mysql_error());	
				$query_update_list[] = $query; 	  

				
				$query = "select no_order,client_id 
					from sales_order
					where id = '$id'";
				$tmp = mysql_query($query) or die (mysql_error());			
				$dataNoOrder = mysql_fetch_array($tmp);
				$noOrder = $dataNoOrder['no_order'];	
				$clientId = $dataNoOrder['client_id'];
				
				$descriptionHistory = "Restore Penjualan Barang ($stuffName : $stuffNickname) dgn No Sales Order : $noOrder";
				
				$query = "insert stuff_history
					set stuff_id = '$stuffId',
					  tipe = '0',
					  amount = '$qty',
					  date = now(),
					  description = '$descriptionHistory',
					  price = '$price',	
					  client_id = '$clientId',
					  sales_order_id = '$id'";		
				//mysql_query($query) or die (mysql_error());	
				$query_update_list[] = $query; 	 
			} else {
			  $mgs_stock_not_available[] = "Stock $stuffName tidak mencukupi, dibutuhkan: $qty pcs (Available Stock : $available_stock pcs)";
			}	 				
		}	
	}


	if(count($query_update_list) > 0) {
		$query = "update sales_order
				set is_delete = '0',
				  is_delete_permanent = '0'
			where id = '$id'";	
		mysql_query($query) or die (mysql_error());	
	    foreach($query_update_list as $val) {
	    	mysql_query($val) or die (mysql_error());	
	    	//echo $val,'<br />';
	    }

		include '../lib/connection-close.php';
		header('Location:index.php?msg=restoreSuccess');
	} else {
		$_SESSION['mgs_stock_not_available'] = $mgs_stock_not_available;
		include '../lib/connection-close.php';
		header('Location:index.php?msg=restoreFailed');
	}	

	/*
	$userLogin = $_SESSION['login'];	

	$query = "update sales_order_history
	      set is_delete = '1'
		where sales_order_id = '$id'";	
	mysql_query($query) or die (mysql_error());	

	$query = "select id, username
	          from user
			  where username = '$userLogin' ";
	$tmpSale = mysql_query($query) or die (mysql_error());	
	$dataUser = mysql_fetch_array($tmpSale);
	$historyUserId = $dataUser['id'];

	$query = "insert sales_order_history
	set sales_order_id = '$id',
	  no_sales_order = '$noOrder',
	  activity = '5',
	  datetime_track = now(),
	  user_id  = '$historyUserId'
	on duplicate key update 
	  datetime_track = now(),
	  user_id  = '$historyUserId'
	";

	mysql_query($query) or die (mysql_error());									
	*/
		
?>
