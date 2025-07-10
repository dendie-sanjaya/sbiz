<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];
	$year = $_REQUEST['year'];	

	$monthName = array('Januari', 'Februari', 'Maret', 'April', 'Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	
	$query = "select id, month, year, name, profit
	from fin_profit_loss
	where id = '$id'";
	$tmp = mysql_query($query) or die (mysql_error());
	$rslt = mysql_fetch_array($tmp);	
	$name = 'Laba Bersih Periode '.$monthName[$rslt['month']-1].' '.$rslt['year'];
	$nominal = $rslt['profit'];
		
	$query = "insert fin_equitas
		set name  = '$name',
		  nominal = '$nominal',
		  tipe = '1',
		  fin_profit_loss_id = '$id',
		  date_transaction = date(now())";
	
	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=postingSuccess&id='.$_REQUEST['id'].'&year='.$_REQUEST['year']);
?>
d