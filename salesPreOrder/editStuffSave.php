<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	
	$id = $_REQUEST['id'];	
	$salesOrderDetilId = $_REQUEST['salesOrderDetailId'];	
	$qty = $_REQUEST['total'];	
	$qtyHidden = $_REQUEST['totalHidden'];	

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
		
	/*
	if($qty != $qtyHidden) {
		$query = "select id, stuff_id
			from sales_order_detail
			where id = '$salesOrderDetilId'";
		$tmp = mysql_query($query) or die (mysql_error());			
		$dataStuff = mysql_fetch_array($tmp);
		$stuffId = $dataStuff['stuff_id'];
		
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
	*/
	
	include '../lib/connection-close.php';	
	include 'editSaveStuffSuccess.php';	
?>
