<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];
	$year = $_REQUEST['year'];
	$finProfitLossDetailId = $_REQUEST['finProfitLossDetailId'];
	
	$query = "delete from fin_profit_loss_detail
		where id = '$finProfitLossDetailId'";	
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

	//include 'deleteStuffSaveSuccess.php';		
	header('Location:edit.php?msg=deleteSuccess&year='.$year.'&id='.$id.'&jumpTo='.$_REQUEST['jumpTo']);
?>
