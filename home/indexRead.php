<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$salesId = $_SESSION['loginMemberId'];
	if($_SESSION['loginPosition'] == '1' or $_SESSION['loginPosition'] == '4') {
		$whereSalesId = "";	
	} else {
		$whereSalesId = $salesId != '1'? " and sales_id = '$salesId' " : "";	
	}	
	
	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and is_reseller = '0'		
		  and status_order != '4'
		  $whereSalesId
		  and date_order = date(now())";

	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPenjualanLangsungHariIni = mysql_fetch_array($tmp);

	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and is_reseller = '0'		
		  and status_order = '4'
		  $whereSalesId";

	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPenjualanBelumBayar = mysql_fetch_array($tmp);

	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and is_reseller = '1'		
		  and date_order = date(now())";

	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPenjualanLangsungHariIniReseller = mysql_fetch_array($tmp);

	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and is_cod = '0'
		  and status_order = '0'
		  and status_payment = '0'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPembayaranBelumValidasi = mysql_fetch_array($tmp);

	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and is_reseller = '1'
		  and is_cod = '1'
		  and status_order = '0'
		  and status_payment = '0'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPembayaranBelumValidasiResellerCod = mysql_fetch_array($tmp);

	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and status_order = '1'
		  and status_payment = '1'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPembayaranBelumPacking = mysql_fetch_array($tmp);

	
	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and status_order = '2'
		  and status_payment = '1'
		  and is_warehouse_external = '0'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPembayaranBelumShipping = mysql_fetch_array($tmp);


	$query = "select count(id) as total 
		from sales_order
		where is_delete = '0'
		  and status_order = '2'
		  and status_payment = '1'
		  and is_warehouse_external = '1'";
	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlPembayaranBelumShippingWarehouseExternal = mysql_fetch_array($tmp);

	$query = "select count(id) as total
		from stuff		
		where is_delete = '0'"; 
	$tmp = mysql_query($query) or die(mysql_error());
	$dataJmlBrg = mysql_fetch_array($tmp);
			  
	$query = "select count(sh.id) as total
		from stuff_history as sh		
		inner join stuff as s
		  on s.id = sh.stuff_id	
		where s.is_delete = '0'
		  and sh.tipe = '1'
		  and sh.date = date(now())
		  and s.category_id in ($loginAccessCategory) 
		  and sh.is_delete = '0'";

	$tmp = mysql_query($query) or die(mysql_error());
	$dataStuffIn = mysql_fetch_array($tmp);

	$query = "select count(sh.id) as total
		from stuff_history as sh		
		inner join stuff as s
		  on s.id = sh.stuff_id	
		where s.is_delete = '0'
		  and sh.tipe = '0'
		  and sh.date = date(now())
		  and sh.is_delete = '0'
		  and s.category_id in ($loginAccessCategory)"; 

	$tmp = mysql_query($query) or die(mysql_error());
	$dataStuffOut = mysql_fetch_array($tmp);

	$query = "select count(sh.id) as total
		from stuff_history as sh		
		inner join stuff as s
		  on s.id = sh.stuff_id	
		where s.is_delete = '0'
		  and sh.tipe = '2'
		  and sh.date = date(now())
		  and sh.is_delete = '0'
		  and s.category_id in ($loginAccessCategory)"; 

	$tmp = mysql_query($query) or die(mysql_error());
	$dataStuffCorrection = mysql_fetch_array($tmp);


	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';
	$where .= $categoryId != 'x' ? " and category_id = '$categoryId' " : " and category_id in ($loginAccessCategory) ";	
		
	$query = "select id, name, stock, stock_min_alert, nickname,
		  (select name from const as c where c.id = const_id) as const_name,
		  (select name from stuff_category as sc where sc.id = category_id) as category_name					       
		from stuff		
		where is_delete = '0' 
		  $where 
		  and stock_min_alert >= stock
		  and stock_min_alert <> 0 
		order by category_id, name";

	$data = mysql_query($query) or die(mysql_error());

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());


	$query = "select date_order, date_format(date_order,'%b %d') as date_order_frm, count(id) as total 
		from sales_order
		where is_delete = '0'
		  and status_order != '4'
		  and status_payment = '1'
		$whereSalesId		
	    group by date_order	    
		order by date_order desc  
	    limit 0,15";
	$tmp = mysql_query($query) or die(mysql_error());

	$grafikLabelTemp = array();
	$grafikValTemp = array();

	while($val = mysql_fetch_array($tmp)) {
	   $grafikLabelTemp[] = "'".$val['date_order_frm']."'";
	   $grafikValTemp[] = "'".$val['total']."'";
	}

	$grafikLabelTemp = array_reverse($grafikLabelTemp,true);
	$grafikValTemp = array_reverse($grafikValTemp, true);

	$grafikLabelTransaksi = '['.implode(',', $grafikLabelTemp).']';
	$grafikValTransaksi = '['.implode(',', $grafikValTemp).']';


	$query = "select date_order, date_format(date_order,'%b %d') as date_order_frm, 
		  sum((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) as total	
		from sales_order
		where is_delete = '0'
		  and status_order != '4'
		  and status_payment = '1'
		$whereSalesId
	    group by date_order	    
		order by date_order desc  
	    limit 0,15";
	$tmp = mysql_query($query) or die(mysql_error());

	$grafikLabelTemp = array();
	$grafikValTemp = array();

	while($val = mysql_fetch_array($tmp)) {
	   $grafikLabelTemp[] = "'".$val['date_order_frm']."'";
	   $grafikValTemp[] = "'".$val['total']."'";
	}

	$grafikLabelTemp = array_reverse($grafikLabelTemp,true);
	$grafikValTemp = array_reverse($grafikValTemp, true);
	
	$grafikLabelRupiah = '['.implode(',', $grafikLabelTemp).']';
	$grafikValRupiah = '['.implode(',', $grafikValTemp).']';

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
					description_payment, description_shipping, discount_amount, amount_sale,  amount_basic_sale, shipping_cost, 
					date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, discount_amount, status_payment,
					date_format(date_order,'%d/%m/%Y') as date_order_frm,
					date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
					date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
					date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
					( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml,
					( (amount_sale / 100) * discount_persen) as jml_diskon,
					( ((amount_sale - (((amount_sale / 100) * discount_persen))) - discount_amount) - amount_basic_sale) as jml_laba,
					(select m.name from member as m where m.id = sales_id) as sales_name			
				from sales_order
				where is_delete = '0'
		  		  and date_order = date(now())
				order by date_order, no_order";

	$tmp = mysql_query($query) or die (mysql_error());

	$dataRevenue['total_price_basic'] = 0;
	$dataRevenue['total_price'] = 0;
	$dataRevenue['total_price_after_discount'] = 0;
	$dataRevenue['total_profit_after_discount'] = 0;
	$dataRevenue['total_discount_percent'] = 0;
	$dataRevenue['total_discount_nominal'] = 0;
	$dataRevenue['total_shipping'] = 0;

	while($val = mysql_fetch_array($tmp)) {
	
		$dataRevenue['total_price_basic'] += $val['amount_basic_sale'];
		$dataRevenue['total_price'] += $val['amount_sale'];
		$dataRevenue['total_discount_percent'] += $val['jml_diskon'];
		$dataRevenue['total_discount_nominal'] += $val['discount_amount']; 
		$dataRevenue['total_shipping'] += $val['shipping_cost'];

		$dataRevenue['total_price_after_discount'] += ($val['amount_sale'] - $val['jml_diskon']) - $val['discount_amount'] ;
		$dataRevenue['total_profit_after_discount'] += $val['jml_laba'];
	} 

	include '../lib/connection-close.php';
?>
