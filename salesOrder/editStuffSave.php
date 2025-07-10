<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	
	$id = general::secureInput($_REQUEST['id']);	
	$salesOrderDetilId = general::secureInput($_REQUEST['salesOrderDetailId']);	
	$qty = general::secureInput($_REQUEST['total']);	
	$qtyHidden = general::secureInput($_REQUEST['totalHidden']);	

	if($qty != $qtyHidden) {
		$query = "select id, stuff_id, is_bundling, name
			from sales_order_detail
			where id = '$salesOrderDetilId'";
		$tmp = mysql_query($query) or die (mysql_error());			
		$dataStuff = mysql_fetch_array($tmp);
		$stuffId = $dataStuff['stuff_id'];
		$isBundling = $dataStuff['is_bundling'];
		$nameProduk = $dataStuff['name'];
		
		if($isBundling == '1') {
			$query = "update sales_order_detail
				set amount = '$qty'
				where id = '$salesOrderDetilId'";

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

			$query = "select stuff_id, qty
					  from sales_order_detail_bundling
					  where sales_order_detail_id = '$salesOrderDetilId'";
			$rstSalesOrderDetailBundling = mysql_query($query) or die (mysql_error());

			while($dataSalesOrderDetailBundling = mysql_fetch_array($rstSalesOrderDetailBundling)) {
				$salesOrderDetailBundlingStuffId = $dataSalesOrderDetailBundling['stuff_id'];
				$salesOrderDetailBundlingQty = $dataSalesOrderDetailBundling['qty'];

				$query = "select no_order,client_id 
					from sales_order
					where id = '$id'";
				$tmp = mysql_query($query) or die (mysql_error());			
				$dataNoOrder = mysql_fetch_array($tmp);
				$noOrder = $dataNoOrder['no_order'];	
				$clientId = $dataNoOrder['client_id'];
				$descriptionHistory = "Update Jml Penjualan Barang dgn No Sales Order : $noOrder, Produk Bundling $nameProduk";

				$selisiTotal = (($qty* $salesOrderDetailBundlingQty) - ($qtyHidden * $salesOrderDetailBundlingQty));
				$qtyHistory = ($qty * $salesOrderDetailBundlingQty);
				if($selisiTotal > 0) {	
					$query = "update stuff
						set stock = stock - $selisiTotal
						where id = '$salesOrderDetailBundlingStuffId'";
					mysql_query($query) or die (mysql_error());	

					$query = "insert stuff_history
						set stuff_id = '$salesOrderDetailBundlingStuffId',
						  tipe = '0',
						  amount = '-$qtyHistory',
						  date = now(),
						  description = '$descriptionHistory',
						  price = '$price',	
						  client_id = '$clientId',
						  sales_order_id = '$id'";		
					mysql_query($query) or die (mysql_error());				
				} else {
					$selisiTotal = abs($selisiTotal); 
					$query = "update stuff
						set stock = stock + '$selisiTotal'
						where id = '$salesOrderDetailBundlingStuffId'";
					mysql_query($query) or die (mysql_error());	

					$query = "insert stuff_history
						set stuff_id = '$salesOrderDetailBundlingStuffId',
						  tipe = '1',
						  amount = '$qtyHistory',
						  date = now(),
						  description = '$descriptionHistory',
						  price = '$price',	
						  client_id = '$clientId',
						  sales_order_id = '$id'";		
					mysql_query($query) or die (mysql_error());				
				}				
			}	
		} else {
			$query = "update sales_order_detail
				set amount = '$qty'
				where id = '$salesOrderDetilId'";

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
			
			$query = "select no_order,client_id 
				from sales_order
				where id = '$id'";
			$tmp = mysql_query($query) or die (mysql_error());			
			$dataNoOrder = mysql_fetch_array($tmp);
			$noOrder = $dataNoOrder['no_order'];	
			$clientId = $dataNoOrder['client_id'];
			$descriptionHistory = "Update Jml Penjualan Barang dgn No Sales Order : $noOrder";
			
			$selisiTotal = $qty - $qtyHidden;

			if($selisiTotal > 0) {	
				$query = "update stuff
					set stock = stock - $selisiTotal
					where id = '$stuffId'";
				mysql_query($query) or die (mysql_error());	

				$query = "insert stuff_history
					set stuff_id = '$stuffId',
					  tipe = '0',
					  amount = '-$qty',
					  date = now(),
					  description = '$descriptionHistory',
					  price = '$price',	
					  client_id = '$clientId',
					  sales_order_id = '$id'";		
				mysql_query($query) or die (mysql_error());				
			} else {
				$selisiTotal = abs($selisiTotal); 
				$query = "update stuff
					set stock = stock + '$selisiTotal'
					where id = '$stuffId'";
				mysql_query($query) or die (mysql_error());	

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
	}
	
	include '../lib/connection-close.php';	
	include 'editSaveStuffSuccess.php';	
?>
