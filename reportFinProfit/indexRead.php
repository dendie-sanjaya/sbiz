<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');

	$query = "select id, year, month, name, total_expenses,total_revenue, profit
	  from fin_profit_loss
	  where year = '$year'
	    and is_delete = '0'
	  order by month";	

	$data = mysql_query($query) or die(mysql_error());

	$query = "select id, year, name
	  from fin_profit_loss
	  where is_delete = '0'
	  group by year
	  order by year desc";	
	$cmbYear = mysql_query($query) or die(mysql_error());
	
	include '../lib/connection-close.php';
?>
