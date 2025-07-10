<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$month = isset($_REQUEST['month']) ? $_REQUEST['month'] : 'x';
	$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : 'x';
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : explode(',',$_REQUEST['categoryIdChoose']) ;	

	$where = '';

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

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	$yearMonth = $year.'-'.str_pad($month,2,"0",STR_PAD_LEFT);	
	$query = "select s.id as stuff_id, s.name as stuff_name, s.nickname, sum(sod.amount) as amount_total, sod.stuff_id,
			(select c.name from const as c where c.id = s.const_id) as satuan,
			sum(sod.price * sod.amount) as price_total,
			sum(sod.price_basic * sod.amount) as price_total_basic,
			sod.price, sod.price_basic
		from sales_order_detail as sod	
		inner join sales_order as so
		  on so.id = sod.sales_order_id 
		inner join stuff as s
		  on s.id = sod.stuff_id
		where so.is_delete = '0'
		  and so.status_order in  ('0','1','2','3')
		  and DATE_FORMAT(so.date_order,'%Y-%m') = '$yearMonth'
		  $where
		group by s.id
		order by amount_total desc, s.category_id, s.name";

	$data = mysql_query($query) or die(mysql_error());	

	$whereCategoryPrint .= strlen($categoryIdChoose) > 0 ? " and id in ($categoryIdChoose)" : " ";

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  $whereCategoryPrint
		order by name";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataCategoryPrint = mysql_fetch_array($tmp);


	include '../lib/connection-close.php';
?>
