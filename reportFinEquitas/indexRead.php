<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$query = "select id,name,tipe,nominal,date_transaction,
		  date_format(date_transaction,'%d %M %Y') as date_transaction_frm	
		from fin_equitas
		where(date_transaction >= '$dateFrom' and date_transaction <= '$dateTo')
		and is_delete = '0'	
		order by date_transaction";
		  
	$data = mysql_query($query) or die(mysql_error());
	
	include '../lib/connection-close.php';
?>
