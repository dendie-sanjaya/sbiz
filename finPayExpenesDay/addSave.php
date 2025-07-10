<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$componentArr = explode('~',$_POST['componentId']);
	$componentId = general::secureInput($componentArr[0]);
	$tmp = explode('/',$_POST['dateTransaction']); 
	$dateTransaction  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$description = general::secureInput($_POST['description']);
	$nominal = general::secureInput($_POST['nominal']);
	$sourceFoundId = general::secureInput($_POST['sourceFoundId']);

	$query = "select name from fin_expenses_revenue
		  where id = '$componentId'";

	$tmp = mysql_query($query) or die (mysql_error());
	$rst = mysql_fetch_array($tmp);
	$componentName = $rst['name'];

	$query = "insert fin_pay_expenses
		set fin_expenses_revenue_id = '$componentId',
		  fin_source_fund_id = '$sourceFoundId',
		  name  = '$componentName',
		  nominal = '$nominal',
		  periode = '0',
		  date_transaction = '$dateTransaction',
		  date_system = now(),
		  description = '$description',
		  is_delete = '0'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&dateFrom='.$_POST['dateTransaction'].'&dateTo='.$_POST['dateTransaction'].'&componentId='.$componentId);
?>
