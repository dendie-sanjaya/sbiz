<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';


	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('d/m/Y', strtotime(' - 30 days')); ;
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$keyword = general::secureInput(str_replace(' ','',trim($_REQUEST['keyword'])));
	$statusFollowup = isset($_REQUEST['statusFollowup']) ? general::secureInput($_REQUEST['statusFollowup']) : 'x';
	
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	$where .= $statusFollowup != 'x' ? " and is_followup = '$statusFollowup '" : "";

	$salesId = $_SESSION['loginMemberId'];
	$positionId = $_SESSION['loginPosition'];

	if($positionId != '1') {
		$where .= $salesId != '1'? " and sales_id = '$salesId' " : "";	
	}		
	
	$query = "select d.id as id_detail, sales_order_followup.id, sales_id, name, phone, country_code, from_ip, date_input, client_id, 
			(select m.name from member as m where m.id = sales_id) as sales_name, is_followup,
			date_format(date_input,'%d/%m/%Y') as date_input_frm,
			date_format(date_input,'%d %M %Y %H:%i:%s') as date_input_frm_2,d.qty,
			(select b.name from stuff as b where b.id = d.stuff_id) as stuff_name,	
			(select b.stock from stuff as b where b.id = d.stuff_id) as sisa_stock
		from sales_order_followup
		inner join sales_order_followup_detail as d
		  on d.sales_order_followup_id = sales_order_followup.id
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(phone, ' ', '' ) like '%$keyword%')
		  and (date_format(date_input,'%Y-%m-%d') >= '$dateFrom' and date_format(date_input,'%Y-%m-%d') <= '$dateTo')		   
		  $where
		order by date_input asc, name asc
		limit $record,50";

	$data = mysql_query($query) or die(mysql_error());
		
	$query = "select count(id) as total
		from sales_order_followup
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(phone, ' ', '' ) like '%$keyword%')
		  and (date_format(date_input,'%Y-%m-%d') >= '$dateFrom' and date_format(date_input,'%Y-%m-%d') <= '$dateTo')		   
		  $where";

	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],50,25);

	include '../lib/connection-close.php';
?>
