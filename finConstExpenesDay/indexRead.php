<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,name,nominal,type, is_fix, is_show_report_convertion_adds 
		from fin_expenses_revenue
		where is_delete = '0'
		and type = '0'
		and periode = '0'
		order by name";

	$data = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';
?>
