<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';
 
 	$dateThisMonth = general::getDateStartEnd();
 
 	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : $dateThisMonth[0];
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : $dateThisMonth[1];

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$componentId = isset($_REQUEST['componentId']) ? general::secureInput($_REQUEST['componentId']) : 'x';

	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	$where = $componentId == 'x' ? " " : " and fin_expenses_revenue_id  = '$componentId' ";	

	$query = "select id, name, nominal, periode, description, date_transaction,
		  date_format(date_transaction,'%d %M %Y') as date_transaction_frm,
		  (select sf.name from fin_source_fund as sf where sf.id = fin_source_fund_id) as fin_source_fund_name 
		from fin_pay_expenses		
		where is_delete = '0'
		 and (date_transaction >= '$dateFrom' and date_transaction <= '$dateTo')		   		  
		 and periode = '0'
		 $where
		order by date_transaction 
		limit $record,50";
	$data = mysql_query($query) or die(mysql_error());
	
	$query = "select count(id) as total
		from fin_pay_expenses		
		where is_delete = '0'
		 and (date_transaction >= '$dateFrom' and date_transaction <= '$dateTo')		   		  
		 $where";
	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);

	$query = "select id,name,nominal,type, is_fix 
		from fin_expenses_revenue
		where is_delete = '0'
		and periode = '0'
		and type = '0'
		and periode = '0'
		order by name";
	$dataComponent = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
