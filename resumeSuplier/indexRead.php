<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';	

	$where = $categoryId != 'x' ? " and st.category_id = '$categoryId'" : " and st.category_id in ($loginAccessCategory) ";


	$query = "select s.name as suplier_name, sum(sh.price * sh.amount) as total
		from suplier as s
		left join stuff_history as sh
		  on sh.suplier_id = s.id 
		  and sh.tipe = '1'
		  and sh.is_delete = '0'
		inner join stuff as st
		  on st.id = sh.stuff_id
		  and sh.tipe = '1'
		  and sh.is_delete = '0'		
		where (sh.date >= '$dateFrom' and sh.date <= '$dateTo')
		  $where
		group by s.id		 	
		order by s.name ";
		
	$data = mysql_query($query) or die(mysql_error());

	include '../lib/connection-close.php';
?>
