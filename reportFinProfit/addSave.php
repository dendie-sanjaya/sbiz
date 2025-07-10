<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include 'addValidate.php';

	$name = general::secureInput($_POST['name']);
	$month = general::secureInput($_POST['month']);
	$year = general::secureInput($_POST['year']);
	
	$query = "insert fin_profit_loss
		set name = '$name',
		  year = '$year',
		  month = '$month'";

	mysql_query($query) or die (mysql_error());

	$query = "select max(id) as id from fin_profit_loss";
	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);
	$id  = $data['id'];
	
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
	
	$query = "select id, name, nominal, type, periode 
		from fin_expenses_revenue
		where is_delete = '0'
		 and is_fix = '1'
		 and id in (13,10,28)
		order by type desc, name";

	$tmp = mysql_query($query) or die (mysql_error());
	
	while($row = mysql_fetch_array($tmp)) {	
		//id  -> Pendapatan Penjualan Barang = 13
		//id  -> Biaya Harga Dasar Barang = 10;
		
		$nominal = $row['nominal'];
		$description = '';
		
		if($row['id'] == '13') {
			$nominal = $hargaJual;
			$description = 'Rumus Pendapatan Penjualan (Total Harga Jual Barang - Total Diskon) Dari Tgl '.$dateFrom .' s/d '.$dateTo;
		}
		
		if($row['id'] == '10') {
			$nominal = $hargaDasar;
			$description = 'Total Harga Dasar Dari Tgl '.$dateFrom .' s/d '.$dateTo;
		}		

		if($row['id'] == '28') {
			$nominal = $totalBiayaKirim;
			$description = 'Total Biaya Kirim Penjualan Dari Tgl '.$dateFrom .' s/d '.$dateTo;
		}		
	
		$query = "insert fin_profit_loss_detail
			set name = '{$row['name']}',
			  type = '{$row['type']}',
			  nominal = '$nominal',
			  periode = '{$row['periode']}',
			  fin_expenses_revenue_id = '{$row['id']}',
			  fin_profit_loss_id = '$id',
			  description = '$description'";

		mysql_query($query) or die (mysql_error());
	}

	$query = "select id, fin_expenses_revenue_id, name, sum(nominal) as total_nominal, 
		  periode, description
		from fin_pay_expenses
		where is_delete = '0'
	      and (date_transaction >= '$dateFrom' and date_transaction <= '$dateTo')
		group by fin_expenses_revenue_id
		order by name";

	$tmp = mysql_query($query) or die (mysql_error());
	
	while($row = mysql_fetch_array($tmp)) {	
		 $query = "insert fin_profit_loss_detail
			set name = '{$row['name']}',
			  type = '0',
			  nominal = '{$row['total_nominal']}',
			  periode = '{$row['periode']}',
			  fin_expenses_revenue_id = '{$row['fin_expenses_revenue_id']}',
			  fin_profit_loss_id = '$id',
			  description = '{$row['description']}'";

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

	header('Location:edit.php?id='.$id);
?>
