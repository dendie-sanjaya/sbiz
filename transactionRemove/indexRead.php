<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';


	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$keyword = str_replace(' ','',$_REQUEST['keyword']);
	/*
	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	*/


	$query = "select sh.id, sh.stuff_id, sh.tipe, sh.amount, sh.description, date_format(sh.date,'%d %M %Y') as date, s.name, sh.tipe,
                   (select s.name from suplier as s where s.id = sh.suplier_id) as suplier_name, 
                   (select cl.name from client as cl where cl.id = sh.client_id) as client_name,
		   (select c.name from const as c where c.id = s.const_id)
		from stuff_history as sh
		inner join stuff as s
		  on s.id = sh.stuff_id	
		where sh.is_delete = '0'
		and (sh.date >= '$dateFrom' and sh.date <= '$dateTo')
		and (replace(name, ' ', '' ) like '%$keyword%' or replace(nickname, ' ', '' ) like '%$keyword%') 	
		order by sh.date, sh.id ";

	$data = mysql_query($query) or die(mysql_error());

	include '../lib/connection-close.php';
?>
