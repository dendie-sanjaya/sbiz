<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];	

	$query = "update sales_order
			set is_delete = '1'
		where id = '$id'";	
	mysql_query($query) or die (mysql_error());	
	
	$query = "select id, stuff_id, amount, name, nickname
		from sales_order_detail
		where sales_order_id = '$id'";
	$dataSalesOrderDetail = mysql_query($query) or die (mysql_error());			

	while($valSalesOrderDetail	= mysql_fetch_array($dataSalesOrderDetail)) {
	
		$salesOrderDetilId = $valSalesOrderDetail['id'];	
		$qty = $valSalesOrderDetail['amount'];	
		$stuffId = $valSalesOrderDetail['stuff_id'];
		$stuffName = $valSalesOrderDetail['name'];		
		$stuffNickname = $valSalesOrderDetail['nickname'];		
	
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
		
	include '../lib/connection-close.php';

	//include 'deleteStuffSaveSuccess.php';		
	header('Location:index.php?msg=deleteSuccess');
?>
