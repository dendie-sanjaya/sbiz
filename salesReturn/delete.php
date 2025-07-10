<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']);	

	$query = "select pr.id, pr.no_so, pr.no_retur
		from sales_retur as pr
		where id = '$id'";
	$rst  = mysql_query($query) or die (mysql_error());	
	$data = mysql_fetch_array($rst);

	$salesOrder = $data['no_so'];
	$noOrder = $data['no_retur'];	

	$query = "select *
		from sales_order		
		where no_order = '$salesOrder'";
	$tmp = mysql_query($query) or die (mysql_error());
	$datasalesOrder = mysql_fetch_array($tmp);

	$query = "update sales_order
			set is_delete = '0',
			 is_return = '0'
		where id = '{$datasalesOrder['id']}'";	
	mysql_query($query) or die (mysql_error());	
	
	$query = "update sales_retur
			set is_delete = '1'
		where id = '$id'";	
	mysql_query($query) or die (mysql_error());	

	$query = "select id, stuff_id, price_basic, price, amount, 
		discount_persen, discount_money, name, nickname
	from sales_order_detail
	where sales_order_id = '{$datasalesOrder['id']}'
	order by id asc";
	$dataStuffRestult = mysql_query($query) or die (mysql_error());


	while($dataStuff= mysql_fetch_array($dataStuffRestult)) {
		$stuffId = $dataStuff['stuff_id'];	
		$stuffAmount = $dataStuff['amount'];
		$stuffPrice = $dataStuff['price'];
		$suplierId = $datasalesOrder['client_id']; 
		
		$description = "Pembatalan Retur Penjualan No SO : $salesOrder, No Retur : $noOrder";
		$query = "insert stuff_history
			set stuff_id = '$stuffId',
			  tipe = '0',
			  amount = '$stuffAmount',
			  date = now(),
			  description = '$description',
			  price = '$stuffPrice',
			  client_id = '$suplierId'";

		mysql_query($query) or die (mysql_error());

		$query = "update stuff
			set stock = stock - '$stuffAmount'
			where id = '$stuffId'";

		mysql_query($query) or die (mysql_error());
	}
	
	include '../lib/connection-close.php';

	
	header('Location:index.php?msg=deleteSuccess');
?>
