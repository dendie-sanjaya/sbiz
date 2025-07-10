<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	
	$amount = general::secureInput($_REQUEST['amount']);
	$priceBasic = general::secureInput($_REQUEST['priceBasic']);
	$price = general::secureInput($_REQUEST['price']);
	$stuffId = general::secureInput($_REQUEST['stuffId']);
	$id = general::secureInput($_REQUEST['id']);
	$isBundling = general::secureInput($_REQUEST['isBundling']);
	
	if($isBundling == '0') {	
		$query = "select id, name, nickname stock, stock_min_alert, price, price_basic, nickname, fee_sales					
			from stuff		
			where id = '$stuffId'";
		$tmp = mysql_query($query) or die(mysql_error());
		$dataStuff = mysql_fetch_array($tmp);
	}

	if($isBundling == '1') {	
		$query = "select id, name, nickname, price, price_min price_basic, fee_sales					
			from stuff_bundling		
			where id = '$stuffId'";
		$tmp = mysql_query($query) or die(mysql_error());
		$dataStuff = mysql_fetch_array($tmp);
	}
		
	$stuffName = $dataStuff['name'];
	$stuffNickname = $dataStuff['nickname'];
	$stuffFeeSales = $dataStuff['fee_sales'];
		
	$query = "insert sales_order_detail
		set sales_order_id = '$id',
		  stuff_id = '$stuffId',
		  amount = '$amount',
		  price = '$price',
		  price_basic = '$priceBasic',
		  name = '$stuffName ',
		  nickname = '$stuffNickname',
		  fee_sales = '$stuffFeeSales',
		  is_bundling = '$isBundling' "; 
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

	if($isBundling == '0') {	
		$query = "update stuff
			set stock = stock - '$amount'
			where id = '$stuffId'";
		mysql_query($query) or die (mysql_error());	

		$query = "select no_order,client_id 
			from sales_order
			where id = '$id'";
		$tmp = mysql_query($query) or die (mysql_error());			
		$dataNoOrder = mysql_fetch_array($tmp);
		$noOrder = $dataNoOrder['no_order'];	
		$clientId = $dataNoOrder['client_id'];
		
		$descriptionHistory = "Pejualan Barang dgn No Sales Order : $noOrder";
		
		$query = "insert stuff_history
			set stuff_id = '$stuffId',
			  tipe = '0',
			  amount = '-$amount',
			  date = now(),
			  description = '$descriptionHistory',
			  price = '$price',	
			  client_id = '$clientId',
			  sales_order_id = '$id'";		
		mysql_query($query) or die (mysql_error());		  
	} 

	if($isBundling == '1') { 	
		$query = "select max(id) as last_id
			from sales_order_detail
			where sales_order_id = '$id'";
		$rstSalesOrderDetail = mysql_query($query) or die (mysql_error());			
		$dataSalesOrderDetail = mysql_fetch_array($rstSalesOrderDetail);
		$salesOrderDetailId = $dataSalesOrderDetail['last_id'];

		$bundlingStuffIdArr = $_REQUEST['bundling_stuff_id'];

		foreach($bundlingStuffIdArr as $val) {
			$bundlingStuffAmount =  $_REQUEST['amount_'.$val];
			$bundlingStuffId = $val;

			if($bundlingStuffAmount > 0) {
				$query = "select *
					from stuff 
					where id = '$bundlingStuffId'";
				$tmp = mysql_query($query) or die (mysql_error());			
				$rstStuffBuldingDetail =  mysql_fetch_array($tmp);

				$qty = $bundlingStuffAmount;

				$query = "insert sales_order_detail_bundling
					set sales_order_detail_id = '$salesOrderDetailId',
					  stuff_id = '$bundlingStuffId',
					  price_basic = {$rstStuffBuldingDetail['price_basic']},
					  price = '{$rstStuffBuldingDetail['price']}',
					  fee_sales = '0',
					  discount_type = '0',
					  discount_nominal = '0',
					  discount_percent = '0',
					  qty = '$qty'";		
				mysql_query($query) or die (mysql_error());		  

				$query = "update stuff
					set stock = stock - '$qty'
					where id = '$bundlingStuffId'";
				mysql_query($query) or die (mysql_error());	

				$query = "select name
					from stuff_bundling
					where id = '$stuffId'";
				$tmp = mysql_query($query) or die (mysql_error());			
				$dataBundling = mysql_fetch_array($tmp);
				$nameProdukBundling = $dataBundling['name'];

				$query = "select no_order,client_id 
					from sales_order
					where id = '$id'";
				$tmp = mysql_query($query) or die (mysql_error());			
				$dataNoOrder = mysql_fetch_array($tmp);
				$noOrder = $dataNoOrder['no_order'];	
				$clientId = $dataNoOrder['client_id'];
				
				$descriptionHistory = "Pejualan Barang dgn No Sales Order : $noOrder, Produk Bundling : $nameProdukBundling";
				
				$query = "insert stuff_history
					set stuff_id = '$stuffIdProdukBundling',
					  tipe = '0',
					  amount = '-$amountStock',
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
	
	include 'addSaveStuffSuccess.php';	
?>
