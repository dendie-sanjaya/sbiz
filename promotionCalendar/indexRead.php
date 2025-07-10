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
	$where = '';
	
	if($componentId != 'x') {
	   $whereDataPlatformId = $componentId;	
	   $where = $componentId == 'x' ? " " : " and pcp.platform_market_id  in ('$componentId') ";
	}   	

	$query = "select pc.id, pc.name, pc.description, pc.date_transaction,
		  date_format(pc.date_transaction,'%d %M %Y') as date_transaction_frm
		from promotion_calendar	as pc	
		left join promotion_calendar_platform_market as pcp
		 on pcp.promotion_calender_id = pc.id
		where pc.is_delete = '0'
		 and (pc.date_transaction >= '$dateFrom' and pc.date_transaction <= '$dateTo')
		 $where
		group by pc.id 
		order by pc.date_transaction 
		limit $record,50";
	$data = mysql_query($query) or die(mysql_error());
	
	$query = "select count(pc.id) as total
		from promotion_calendar	as pc	
		left join promotion_calendar_platform_market as pcp
		 on pcp.promotion_calender_id = pc.id
		where pc.is_delete = '0'
		 and (pc.date_transaction >= '$dateFrom' and pc.date_transaction <= '$dateTo')
		 $where";
	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);

	$query = "select id,name,is_fix 
		from platform_market
		where is_delete = '0'
		order by name";
	$dataComponent = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
