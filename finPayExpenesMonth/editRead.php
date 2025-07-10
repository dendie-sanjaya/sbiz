<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';		

	$id = general::secureInput($_REQUEST['id']);

	$query = "select id, name, nominal, periode, description, date_transaction, fin_expenses_revenue_id,
		  date_format(date_transaction,'%d %M %Y') as date_transaction_frm,
		  date_format(date_transaction,'%d/%m/%Y') as date_transaction_frm_2,
		  fin_source_fund_id
		from fin_pay_expenses		
		where is_delete = '0'
		 and id = '$id'";
	$tmp = mysql_query($query) or die(mysql_error());
	$data = mysql_fetch_array($tmp);

	$query = "select id,name,nominal,type, is_fix 
		from fin_expenses_revenue
		where is_delete = '0'
		and type = '0'
		and periode = '1'
		and id not in ('10','27','28')
		order by name";
	$cmbComponent = mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from fin_source_fund
		where is_delete = '0'
		order by name";
	$cmbSourceFund = mysql_query($query) or die (mysql_error());


	include '../lib/connection-close.php';
?>