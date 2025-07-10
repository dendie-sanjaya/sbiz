<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';

	$tipe = $_REQUEST['tipe'];
	$id = $_REQUEST['id'];
	$periode = $_REQUEST['periode'];
	
	$query = "select fev.id,fev.name 
		from fin_expenses_revenue as fev		
		where fev.is_delete = '0'
		and type = '$tipe'
		and periode = '$periode'		
		and fev.id not in (
			select fpls.fin_expenses_revenue_id 
			from fin_profit_loss_detail as fpls
			inner join fin_profit_loss as fpl
			on fpl.id = fpls.fin_profit_loss_id
			where fpl.id = '$id'
		)			
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
