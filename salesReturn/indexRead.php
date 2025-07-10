<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$statusPayment = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : 'x';
	
	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('d/m/Y');
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');	
					
	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	$positionId = $_SESSION['loginPosition'];
	if(!in_array($positionId,array('1','4','5'))) {	
		$where .= $salesId != '1'? " and po.sales_id = '$salesId' " : "";	
	}	
	
	$query = "select ps.id, ps.no_so, ps.no_retur,    
			date_format(ps.date_retur ,'%d %M %Y') as date_retur_frm,
			po.id as so_id, ps.amount_basic_sale, ps.amount_sale,
			(select m.name from member as m where m.id = sales_id) as sales_name					
		from sales_retur as ps
		left join sales_order as po
		  on  po.no_order = ps.no_so
		where ps.is_delete = '0'
		  and (replace(no_retur, ' ', '' ) like '%$keyword%' or replace(no_so , ' ', '' ) like '%$keyword%')
		  and (date_retur >= '$dateFrom' and date_retur <= '$dateTo')		  
		  $where
		order by date_retur desc , no_retur desc
		limit $record,200";

	$data = mysql_query($query) or die(mysql_error());

	$query = "select count(ps.id) as total				
		from sales_retur as ps
		left join sales_order as po
		  on  po.no_order = ps.no_so
		where ps.is_delete = '0'
		  and (replace(no_retur, ' ', '' ) like '%$keyword%' or replace(no_so , ' ', '' ) like '%$keyword%')
		  and (date_retur >= '$dateFrom' and date_retur <= '$dateTo')		  
		  $where";		
	$dataTotal = mysql_query($query) or die(mysql_error());
	$total = mysql_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],25,25);

	include '../lib/connection-close.php';
?>
