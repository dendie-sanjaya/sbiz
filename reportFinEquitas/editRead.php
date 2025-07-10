<?php 
	include '../login/auth.php';
	include '../lib/connection.php';


	$id = $_REQUEST['id'];

	$query = "select id,name,tipe,nominal,date_transaction,	
		date_format(date_transaction,'%d/%m/%Y') as date_transaction_frm
		from fin_equitas
		where id = '$id'
		order by date_transaction";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
