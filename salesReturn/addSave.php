<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include 'addValidate.php';
	include '../lib/connection.php';

	$purchaseOrderName = $_POST['purchaseOrderName'];
	$tmp = explode('/',$_REQUEST['dateReturn']);
	$dateReturn  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$idStufftRetur = $_REQUEST['idStufftRetur'];
	
	$purchaseOrder = trim($_REQUEST['purchaseOrderName']);
	$query = "select *
		from sales_order		
		where no_order = '$purchaseOrder'";

	$tmp = mysql_query($query) or die (mysql_error());
	$dataPurchaseOrder = mysql_fetch_array($tmp);

	$query = "update sales_order
		set is_delete = '1',
		  is_return = '1'
		where id = '{$dataPurchaseOrder['id']}'";
	mysql_query($query) or die (mysql_error());


	$year = date('y'); 
	$query = "select MAX(SUBSTRING(no_retur,4,8)) + 1 as no_return
			  from sales_retur
			  where SUBSTRING(no_retur, 2, 2) = '{$year}'";
	$tmp = mysql_query($query) or die (mysql_error());			  
	$rst =  mysql_fetch_array($tmp); 
	$noReturn = strlen($rst['no_return']) > 0 ? ('R'.$year.str_pad(($rst['no_return']),5,"0",STR_PAD_LEFT)) : ('R'.$year.'00001');
	
	$query = "insert sales_retur
		set no_retur = '$noReturn',
		  no_so = '$purchaseOrder',
		  date_retur = '$dateReturn',
		  amount_basic_sale = '{$dataPurchaseOrder['amount_basic_sale']}',
		  amount_sale = '{$dataPurchaseOrder['amount_sale']}'";
	mysql_query($query) or die (mysql_error());
	
	$query = "select id, stuff_id, price_basic, price, amount, 
		discount_persen, discount_money, name, nickname
	from sales_order_detail
	where sales_order_id = '{$dataPurchaseOrder['id']}'
	order by id asc";
	$dataStuffRestult = mysql_query($query) or die (mysql_error());

	while($dataStuff = mysql_fetch_array($dataStuffRestult)) {
		

		if($dataStuff['stuff_id'] > 0) {
			$stuffId = $dataStuff['stuff_id'];	
			$stuffName = $dataStuff['name'];
			$stuffAmount = $dataStuff['amount'];
			$stuffPrice = $dataStuff['price'];
			$stuffPriceBasic = $dataStuff['price_basic'];
			$stuffNickname = $dataStuff['barcode'];
			
			/*	
			$query = "insert sales_retur_detail
				set sales_retur_id = '$purchaseReturId',
				  stuff_id = '$stuffId',
				  amount = '$returnAmount',
				  price = '$stuffPrice',
				  price_basic = '$stuffPriceBasic',
				  name = '$stuffName',
				  code = '$stuffKode',
				  nickname = '$stuffNickname'"; 
			mysql_query($query) or die (mysql_error());
			*/

			$suplierId = $dataPurchaseOrder['suplier_id']; 
			$description = "Retur Penjualan No SO : $purchaseOrder, No Retur Pembelian : $noReturn";
			$query = "insert stuff_history
				set stuff_id = '$stuffId',
				  tipe = '1',
				  amount = '$stuffAmount',
				  date = '$dateReturn',
				  description = '$description',
				  price = '$stuffPrice',
				  suplier_id = '$suplierId'";

			mysql_query($query) or die (mysql_error());

			$query = "update stuff
				set stock = stock + '$stuffAmount'
				where id = '$stuffId'";

			mysql_query($query) or die (mysql_error());
		}	
	}
	
	/*
	$query = "select sum(amount * price) as total,
	  sum(amount * price_basic) as total_basic 
	from  sales_retur_detail
	where sales_retur_id = '$purchaseReturId'";
		  
	$qry = mysql_query($query) or die (mysql_error());
	$tmp = mysql_fetch_array($qry);
		
	$total = $tmp['total'];	
	$totalBasic = $tmp['total_basic'];	

	$query = "update sales_retur
		set amount_basic_sale = '$totalBasic'
		where id = '$purchaseReturId'";
	mysql_query($query) or die (mysql_error());
	*/


	include '../lib/connection-close.php';

	header('Location:index.php');
?>
