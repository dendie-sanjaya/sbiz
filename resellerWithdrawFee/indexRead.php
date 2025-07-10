<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';
	include '../lib/split.class.php';	

	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('d/m/Y');
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	$resellerId = isset($_REQUEST['resellerId']) ? $_REQUEST['resellerId'] : array(); 
	$strResellerId = implode(',',$resellerId); 		

	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where = '';
	$where .= count($resellerId) > 0 ? " and reseller_id in ($strResellerId)" : "";	

	$query = "select rf.id, rf.reseller_id, rf.reseller_bank_id, rf.from_bank, rf.total_withdraw, rf.date_transfer, rf.no_payment,
		  date_format(rf.date_transfer,'%d %M %Y') as date_transfer_frm, no_payment,
		  (select r.name from reseller as r where r.id = rf.reseller_id) as reseller_name,
		  (select concat(b.bank_name,' ',b.account_name,'<br />',b.account_number) as bank_name from reseller_bank as b where b.id = rf.reseller_bank_id) as reseller_bank
		from reseller_withdraw_fee as rf
		where rf.is_delete = '0'
		  and (date_transfer >= '$dateFrom' and date_transfer <= '$dateTo')
		  and rf.no_payment like '%$keyword%'
		  $where
		order by date_transfer desc,reseller_name asc
		limit $record,50";
	$data = mysql_query($query) or die(mysql_error());	


	$query = "select count(id) as total
		from reseller_withdraw_fee as rf
		where rf.is_delete = '0'
		  and (date_transfer >= '$dateFrom' and date_transfer <= '$dateTo')
		  $where";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],50,25);
		
	$query = "select id,name from reseller
	 		  where is_delete = '0'";
	$cmbReseller = mysql_query($query) or die(mysql_error());	

	include '../lib/connection-close.php';
?>
