<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];	

	$query = "update sales_order
			set is_delete = '1'
		where id = '$id'";	
	mysql_query($query) or die (mysql_error());	
	
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

				$qtyBundling = ($qty * $salesOrderDetailBundlingQty);
				$query = "update stuff
					set stock = stock + '$qtyBundling'
					where id = '$salesOrderDetailBundlingStuffId'";
				mysql_query($query) or die (mysql_error());	

				$query = "select no_order,client_id 
					from sales_order
					where id = '$id'";
				$tmp = mysql_query($query) or die (mysql_error());			
				$dataNoOrder = mysql_fetch_array($tmp);
				$noOrder = $dataNoOrder['no_order'];	
				$clientId = $dataNoOrder['client_id'];
				
				$descriptionHistory = "Menghapus Penjualan dgn No Sales Order : $noOrder, Produk Bundling $stuffName";
				
				$query = "insert stuff_history
					set stuff_id = '$salesOrderDetailBundlingStuffId',
					  tipe = '1',
					  amount = '$qtyBundling',
					  date = now(),
					  description = '$descriptionHistory',
					  price = '$price',	
					  client_id = '$clientId',
					  sales_order_id = '$id'";		
				mysql_query($query) or die (mysql_error());		

			}	

		} else {	
			$query = "update stuff
				set stock = stock + '$qty'
				where id = '$stuffId'";
			mysql_query($query) or die (mysql_error());	
			
			$query = "select no_order,client_id 
				from sales_order
				where id = '$id'";
			$tmp = mysql_query($query) or die (mysql_error());			
			$dataNoOrder = mysql_fetch_array($tmp);
			$noOrder = $dataNoOrder['no_order'];	
			$clientId = $dataNoOrder['client_id'];
			
			$descriptionHistory = "Menghapus Pejualan Barang ($stuffName : $stuffNickname) dgn No Sales Order : $noOrder";
			
			$query = "insert stuff_history
				set stuff_id = '$stuffId',
				  tipe = '1',
				  amount = '$qty',
				  date = now(),
				  description = '$descriptionHistory',
				  price = '$price',	
				  client_id = '$clientId',
				  sales_order_id = '$id'";		
			mysql_query($query) or die (mysql_error());		
		}	
	}

	/*
	$query = "delete from sales_order_history
		where sales_order_id = '$id'";	
	mysql_query($query) or die (mysql_error());	
	*/
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

		
	include '../lib/connection-close.php';

	//include 'deleteStuffSaveSuccess.php';		
	header('Location:index.php?msg=deleteSuccess');
?>
