<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/general.class.php';

	$salesFollowupId = general::secureInput($_GET['id']);

	$query = "update sales_order_followup
		set is_followup = '1'
		where id = '$salesFollowupId'";
	mysql_query($query) or die (mysql_error());	

	$query = "select sales_order_followup.id, sales_id, client_id, name, phone, country_code, from_ip, date_input, 
			(select m.name from member as m where m.id = sales_id) as sales_name,
			date_format(date_input,'%d/%m/%Y') as date_input_frm,
			date_format(date_input,'%d %M %Y %H:%i:%s') as date_input_frm_2,d.qty, d.stuff_id,
			(select b.name from stuff as b where b.id = d.stuff_id) as stuff_name	
		from sales_order_followup
		inner join sales_order_followup_detail as d
		  on d.sales_order_followup_id = sales_order_followup.id
		where is_delete = '0' 
		 and sales_order_followup.id = '$salesFollowupId'";

	$tmp = mysql_query($query) or die(mysql_error());
	$data = mysql_fetch_array($tmp);

	$salesId = $data['sales_id'];
	$clientId = $data['client_id'];
	$tipeOrder = 0;
	$name = $data['name'];
	$address = '';
	$phone = $data['country_code'].$data['phone'];

	$year = date('y');	
	$query = "select max(no_order) + 1 as no_new
			  from sales_order 
			  where substr(no_order,1,2) = '$year'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataNoOrder =  mysql_fetch_array($tmp); 
	$noOrder = $dataNoOrder['no_new']; 
	
	if(strlen($noOrder) < 1) {
		$noOrder = $year.'000001';
	}

	$query = "insert sales_order
		set client_id = '$clientId',
		  period_order_id = '$periodeOrderId',
		  sales_id = '$salesId',
		  no_order = '$noOrder',
		  name = '$name',
		  phone = '$phone',
		  address_shipping = '$address',
		  tipe_order = '$tipeOrder',
		  date_order = now()";
	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as id from sales_order";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataSalesOrder = mysql_fetch_array($tmp);
	$salesOrderId  = $dataSalesOrder['id'];

	//start input detail barang
	$stuffId = $data['stuff_id'];
	$amount = $data['qty'];
		
	$query = "select id, name, nickname stock, stock_min_alert, price, price_basic, nickname, fee_sales					
		from stuff		
		where id = '$stuffId'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataStuff = mysql_fetch_array($tmp);

	$stuffName = $dataStuff['name'];
	$stuffNickname = $dataStuff['nickname'];
	$stuffFeeSales = $dataStuff['fee_sales'];
	$priceBasic = $dataStuff['price_basic'];
	$price = $dataStuff['price'];
		
	$query = "insert sales_order_detail
		set sales_order_id = '$salesOrderId',
		  stuff_id = '$stuffId',
		  amount = '$amount',
		  price = '$price',
		  price_basic = '$priceBasic',
		  name = '$stuffName ',
		  nickname = '$stuffNickname',
		  fee_sales = '$stuffFeeSales'"; 
	mysql_query($query) or die (mysql_error());
	
	$query = "select sum(amount * price) as total,
		  sum(amount * price_basic) as total_basic 
		from  sales_order_detail
		where sales_order_id = '$salesOrderId'";
		  
	$qry = mysql_query($query) or die (mysql_error());
	$tmp = mysql_fetch_array($qry);

	$total = $tmp['total'];	
	$totalBasic = $tmp['total_basic'];	

	$query = "update sales_order
		set amount_sale = '$total',
		  amount_basic_sale = '$totalBasic'
		where id = '$salesOrderId'";
	mysql_query($query) or die (mysql_error());	

	$query = "update stuff
		set stock = stock - '$amount'
		where id = '$stuffId'";
	mysql_query($query) or die (mysql_error());	
	
	
	$query = "select no_order,client_id 
		from sales_order
		where id = '$salesOrderId'";
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
		  sales_order_id = '$salesOrderId'";		
	mysql_query($query) or die (mysql_error());		  


	include '../lib/connection-close.php';

	header('Location:../salesOrder/edit.php?id='.$salesOrderId);
?>
