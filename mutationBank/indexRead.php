<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';	

	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('d/m/Y');
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$keyword = str_replace('.','',trim($_REQUEST['keyword']));

	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	$orderBy = isset($_REQUEST['orderBy']) ? general::secureInput($_REQUEST['orderBy']) : 'date';
	$paymentId = isset($_REQUEST['paymentId']) ? $_REQUEST['paymentId'] : array();
	$where = '';
	if(count($paymentId) > 0) {
		$implode = implode(',',$paymentId);
		$where .= " and account_number in ($implode) ";
	}

	$query = "select *, 
		 (select b.name from fin_source_fund as b where b.account_number = mutation_bank.account_number) as bank_name 
		from mutation_bank
		where (replace(account_number, ' ', '' ) like '%$keyword%' or replace(amount, ' ', '' ) like '%$keyword%')
		  $where
		  and (date_format(date,'%Y-%m-%d') >= '$dateFrom' and date_format(date,'%Y-%m-%d') <= '$dateTo')			  
		order by $orderBy desc
		limit $record,10000";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from mutation_bank
		where (replace(account_number, ' ', '' ) like '%$keyword%' or replace(amount, ' ', '' ) like '%$keyword%')
    	and (date_format(date,'%Y-%m-%d') >= '$dateFrom' and date_format(date,'%Y-%m-%d') <= '$dateTo')			  	
		$where";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],100,25);

	$query = "select id, name, account_number
	from fin_source_fund		
	where is_delete = '0'
	and length(account_number) > 0
	order by name";
	$cmbFoundSource = mysql_query($query) or die (mysql_error());
?>
