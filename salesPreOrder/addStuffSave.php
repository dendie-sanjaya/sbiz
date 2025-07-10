<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	
	$amount = $_REQUEST['amount'];
	$priceBasic = $_REQUEST['priceBasic'];
	$price = $_REQUEST['price'];
	$stuffId = $_REQUEST['stuffId'];
	$id = $_REQUEST['id'];
		
	$query = "select id, name, nickname stock, stock_min_alert, price, price_basic, nickname					
		from stuff		
		where id = '$stuffId'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataStuff = mysql_fetch_array($tmp);

	$stuffName = $dataStuff['name'];
	$stuffNickname = $dataStuff['nickname'];
		
	$query = "insert sales_order_detail
		set sales_order_id = '$id',
		  stuff_id = '$stuffId',
		  amount = '$amount',
		  price = '$price',
		  price_basic = '$priceBasic',
		  name = '$stuffName ',
		  nickname = '$stuffNickname'"; 
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
	*/
	
	include '../lib/connection-close.php';
	
	include 'addSaveStuffSuccess.php';	
?>
