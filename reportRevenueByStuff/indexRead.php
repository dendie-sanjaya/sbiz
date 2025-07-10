<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$statusOrder = isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : '0';
	$statusPayment = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : 'x';
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : explode(',',$_REQUEST['categoryIdChoose']) ;	
	$orderBy = isset($_REQUEST['orderBy']) ? $_REQUEST['orderBy'] : '0';
	
	$where = '';
	$group = ' s.id ';

	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment '" : "";	
	if($statusOrder == 'x') {
		$where .= " ";
	} else if ($statusOrder == '4') {
		$where .= " and status_order in ('4')";	
	} else {
		$where .= " and status_order in ('0','1','2','3')";	
	}

	if(count($categoryId) > 0) {
		$categoryIdChoose = '';
		foreach($categoryId as $val) {
			$categoryIdChoose = $categoryIdChoose.$val.',';
		}
		$categoryIdChoose = substr($categoryIdChoose,0,strlen($categoryIdChoose)-1);
	} else {
		$categoryIdChoose = $_REQUEST['categoryIdChoose'] ;
	}

	$where .= strlen($categoryIdChoose) > 0 ? " and category_id in ($categoryIdChoose)" : "  ";	



	if(isset($_REQUEST['strSalesId']) && (strlen($_REQUEST['strSalesId']) > 0) ) {	
		$salesId = explode(',',$_REQUEST['strSalesId']);
		$strSalesId = $_REQUEST['strSalesId'];
		$query = "select id,name from member 
		 		  where id in ($strSalesId)";
		$salesName = mysql_query($query) or die(mysql_error());	
	} else {
		$salesId = isset($_REQUEST['salesId']) ? $_REQUEST['salesId'] : array(); 
		$strSalesId = implode(',',$salesId); 		
	}

	//$where .= count($salesId) > 0 ? " and sales_id in ($strSalesId)" : "";	
	if(count($salesId) > 0) {
		$where .= " and sales_id in ($strSalesId)";	
		$group .= " , so.sales_id ";
	}

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());

	if($orderBy == '0') { $orderByName = ' price_total desc '; }
	if($orderBy == '1') { $orderByName = ' amount_total desc '; }
	if($orderBy == '2') { $orderByName = ' s.name asc '; }

	$query = "select s.id as stuff_id, s.name as stuff_name, s.nickname, sum(sod.amount) as amount_total, sod.stuff_id,
			(select c.name from const as c where c.id = s.const_id) as satuan,
			sum(sod.price * sod.amount) as price_total,
			sum(sod.price_basic * sod.amount) as price_total_basic,
			sod.price, sod.price_basic,
			(select m.name from member as m where m.id = so.sales_id) as sales_name
		from sales_order_detail as sod	
		inner join sales_order as so
		  on so.id = sod.sales_order_id 
		inner join stuff as s
		  on s.id = sod.stuff_id
		where so.is_delete = '0'
		  and so.status_complate_stuff = '1'
		  and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
		  $where
		group by $group
		order by $orderByName";

	$data = mysql_query($query) or die(mysql_error());	

	$whereCategoryPrint .= strlen($categoryIdChoose) > 0 ? " and id in ($categoryIdChoose)" : " ";

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  $whereCategoryPrint
		order by name";
	$dataCategoryPrint = mysql_query($query) or die (mysql_error());

	$query = "select id,name from member 
	 		  where position_id order by name";
	$cmbSales = mysql_query($query) or die(mysql_error());	
		
	include '../lib/connection-close.php';
?>
