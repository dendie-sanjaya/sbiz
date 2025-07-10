<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

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
