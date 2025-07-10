<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	
	$id = $_REQUEST['id'];	
	$itemRevenueExpenses = $_REQUEST['itemRevenueExpenses'];	

	
	$query = "select name, nominal, type, periode
		from fin_expenses_revenue
		where id = '$itemRevenueExpenses'";
	$tmp = mysql_query($query) or die (mysql_error());
	$rest = mysql_fetch_array($tmp);
	$itemName = $rest['name'];
	$itemTipe = $rest['type'];
	$itemNominal = $rest['nomial'];
	$description = $rest['periode'];
	$periode = $rest['periode'];;
	
	$query = "select id,month,year 
		from fin_profit_loss
		where id = '$id'";	
	$tmp = mysql_query($query) or die (mysql_error());	 
	$rest = mysql_fetch_array($tmp);
	$year = $rest['year']; 
	$month = $rest['month']; 
	
	//id  -> Pendapatan Penjualan Barang = 13
	//id  -> Biaya Harga Dasar Barang = 10;
	if($itemRevenueExpenses == '13') {
		if(date("$year-$month") == date("Y-$m")){
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-d");	
		} else {
			$kalendar = CAL_GREGORIAN;
			$hari = cal_days_in_month($kalendar,$month,$year);
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-$hari");
		}
		
		$query = "select id, 
			sum(amount_basic_sale) as harga_dasar, 
			sum(amount_sale - ((amount_sale / 100) * discount_persen))  as harga_jual
		from sales_order
		where is_delete = '0'
		  and (date_payment >= '$dateFrom' and date_payment <= '$dateTo')
		  and status_payment = '1'";
		
		$tmp = mysql_query($query) or die (mysql_error());
		$rslt = mysql_fetch_array($tmp);
		$hargaDasar = $rslt['harga_dasar'];
		$hargaJual =  $rslt['harga_jual'];
			
		$itemNominal = $hargaJual;
		$description = 'Rumus (Total Harga Jual Barang - Total Diskon) Dari Tgl '.$dateFrom .' s/d '.$dateTo;
	}
	
	if($itemRevenueExpenses == '10') {
		if(date("$year-$month") == date("Y-$m")){
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-d");	
		} else {
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-31");
		}
		
		$query = "select id, 
			sum(amount_basic_sale) as harga_dasar, 
			sum(amount_sale - ((amount_sale / 100) * discount_persen))  as harga_jual
		from sales_order
		where is_delete = '0'
		  and (date_payment >= '$dateFrom' and date_payment <= '$dateTo')
		  and status_payment = '1'";

		$tmp = mysql_query($query) or die (mysql_error());
		$rslt = mysql_fetch_array($tmp);
		$hargaDasar = $rslt['harga_dasar'];
		$hargaJual =  $rslt['harga_jual'];
		
		$itemNominal = $hargaDasar;
		$description = 'Total Harga Dasar Dari Tgl '.$dateFrom .' s/d '.$dateTo;
	}		

	if($itemRevenueExpenses == '11') {
		if(date("$year-$month") == date("Y-$m")){
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-d");	
		} else {
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-31");
		}
		
		$query = "select id, 
		sum(amount_basic_sale - ((amount_basic_sale / 100) * discount_persen))  as harga_beli,
			sum(tax_amount) as pajak_pembelian
		from purchase_order
		where is_delete = '0'
		  and (date_payment >= '$dateFrom' and date_payment <= '$dateTo')
		  and status_payment = '1'";

		$tmp = mysql_query($query) or die (mysql_error());
		$rslt = mysql_fetch_array($tmp);
		$hargaBeli =  $rslt['harga_beli'];
		$pajakPembelian =  $rslt['pajak_pembelian'];
		
		$itemNominal = $pajakPembelian;
		$description = 'Total Pajak Pembelian dari Tgl '.$dateFrom .' s/d '.$dateTo;
	}	

	if($itemRevenueExpenses == '14') {
		if(date("$year-$month") == date("Y-$m")){
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-d");	
		} else {
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-31");
		}
		
		$query = "select id, 
		sum(amount_basic_sale - ((amount_basic_sale / 100) * discount_persen))  as harga_beli,
			sum(tax_amount) as pajak_pembelian
		from purchase_order
		where is_delete = '0'
		  and (date_payment >= '$dateFrom' and date_payment <= '$dateTo')
		  and status_payment = '1'";

		$tmp = mysql_query($query) or die (mysql_error());
		$rslt = mysql_fetch_array($tmp);
		$hargaBeli =  $rslt['harga_beli'];
		$pajakPembelian =  $rslt['pajak_pembelian'];
		
		$itemNominal = $hargaBeli;
		$description = 'Total Pembelian dari Tgl '.$dateFrom .' s/d '.$dateTo;
	}	
	
	/*
	if($itemRevenueExpenses == '12') {
		if(date("$year-$month") == date("Y-$m")){
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-d");	
		} else {
			$dateFrom = date("$year-$month-01");
			$dateTo = date("$year-$month-31");
		}
		
		$query = "select id, 
			sum(amount_basic_sale) as harga_dasar, 
			sum(amount_sale - ((amount_sale / 100) * discount_persen))  as harga_jual,
			sum(tax_amount) as pajak_penjualan
		from sales_order
		where is_delete = '0'
		  and (date_payment >= '$dateFrom' and date_payment <= '$dateTo')
		  and status_payment = '1'";

		$tmp = mysql_query($query) or die (mysql_error());
		$rslt = mysql_fetch_array($tmp);
		$hargaDasar = $rslt['harga_dasar'];
		$hargaJual =  $rslt['harga_jual'];
		$pajakPenjualan =  $rslt['pajak_penjualan'];
		
		$itemNominal = $pajakPenjualan;
		$description = 'Total Pajak Penjualan dari Tgl '.$dateFrom .' s/d '.$dateTo;
	}	
	*/
	
	$query = "insert fin_profit_loss_detail
		set name = '$itemName',
		  type = '$itemTipe',
		  periode = '$periode',
		  nominal = '$itemNominal',
		  fin_expenses_revenue_id = '$itemRevenueExpenses',
		  fin_profit_loss_id = '$id',
		  description = '$description'";

	mysql_query($query) or die (mysql_error());

	$query = "select sum(nominal) as total_revenue 
		from fin_profit_loss_detail
		where fin_profit_loss_id = '$id'
		and type = '1'";

	$tmp = mysql_query($query) or die (mysql_error());
	$rest = mysql_fetch_array($tmp);
	$totalRevenue = $rest['total_revenue'];
	
	$query = "select sum(nominal) as total_expenses 
		from fin_profit_loss_detail
		where fin_profit_loss_id = '$id'
		and type = '0'";

	$tmp = mysql_query($query) or die (mysql_error());
	$rest = mysql_fetch_array($tmp);
	$totalExpenses = $rest['total_expenses'];	
	
	$profit = ($totalRevenue - $totalExpenses); 

	$query = "update fin_profit_loss
		set total_expenses = '$totalExpenses',
		  total_revenue = '$totalRevenue',
		  profit = '$profit'
		 where id = '$id'";	
	mysql_query($query) or die (mysql_error());	 
	
	include '../lib/connection-close.php';
	
	include 'addSaveStuffSuccess.php';	
?>
