<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	
	$id = $_REQUEST['id'];	
	$finProfitLossDetailId = $_REQUEST['finProfitLossDetailId'];	
	$finExpensesRevenueId = $_REQUEST['finExpensesRevenueId'];

	$query = "select id,month,year 
		from fin_profit_loss
		where id = '$id'";	
	$tmp = mysql_query($query) or die (mysql_error());	 
	$rest = mysql_fetch_array($tmp);
	$year = $rest['year']; 
	$month = $rest['month']; 

	if(date("$year-$month") == date("Y-$m")){
		$dateFrom = date("$year-$month-01");
		$dateTo = date("$year-$month-d");	
	} else {
		$kalendar = CAL_GREGORIAN;
		$hari = cal_days_in_month($kalendar,$month,$year);
		$dateFrom = date("$year-$month-01");
		$dateTo = date("$year-$month-$hari");
	}
	

	if(in_array($finExpensesRevenueId,array(10,13,28))) {
		$query = "select id, 
			sum(amount_basic_sale) as harga_dasar, 
			sum((amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost)  as harga_jual,
			sum(shipping_cost) as total_biaya_kirim 		
		from sales_order
		where is_delete = '0'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')
		  and status_payment = '1'";
		
		$tmp = mysql_query($query) or die (mysql_error());
		$rslt = mysql_fetch_array($tmp);
		$hargaDasar = $rslt['harga_dasar'];
		$hargaJual =  $rslt['harga_jual'];
		$totalBiayaKirim = $rslt['total_biaya_kirim'];	
		$description = '';
		
		if($finExpensesRevenueId == '13') {
			$nominal = $hargaJual;
			$description = 'Rumus (Total Harga Jual Barang - Total Diskon) + Biaya Kirim Dari Tgl '.$dateFrom .' s/d '.$dateTo;
		}
		
		if($finExpensesRevenueId == '10') {
			$nominal = $hargaDasar;
			$description = 'Total Harga Dasar Dari Tgl '.$dateFrom .' s/d '.$dateTo;
		}			
		
		if($finExpensesRevenueId == '28') {
			$nominal = $totalBiayaKirim;
			$description = 'Total Biaya Kirim Penjualan Dari Tgl '.$dateFrom .' s/d '.$dateTo;
		}		
		
		$query = "update fin_profit_loss_detail
				  set nominal = '$nominal',
				    description = '$description'
				  where id = '$finProfitLossDetailId'";

		mysql_query($query) or die (mysql_error());
	} else {
		echo $query = "select id, fin_expenses_revenue_id, name, sum(nominal) as total_nominal, 
			  periode, description
			from fin_pay_expenses
			where is_delete = '0'
		      and (date_transaction >= '$dateFrom' and date_transaction <= '$dateTo')
		      and fin_expenses_revenue_id = '$finExpensesRevenueId'
			group by fin_expenses_revenue_id
			order by name";

		$tmp = mysql_query($query) or die (mysql_error());
		$rstExpensesUpdate = mysql_fetch_array($tmp);
	
		$query = "update fin_profit_loss_detail
				  set nominal = '{$rstExpensesUpdate['total_nominal']}'
				  where id = '$finProfitLossDetailId'";

		mysql_query($query) or die (mysql_error());
	}	
	
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
	
	header('Location:edit.php?msg=editSuccess&year='.$year.'&id='.$id.'&jumpTo='.$_REQUEST['jumpTo']);
?>
