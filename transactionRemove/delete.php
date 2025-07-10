<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];


	$query = "select stuff_id, amount, tipe
		from stuff_history
		where id='$id'";

	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);

	$stuffId = $data['stuff_id'];
	$amount = $data['amount'];
	$tipe = $data['tipe'];	

	$query = "update stuff_history
		set is_delete = '1'
		where id='$id'";

	mysql_query($query) or die (mysql_error());

	if($tipe != 2) {
		$query = "update stuff
			set stock = stock - $amount
			where id='$stuffId'";
	}

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess'.'&keyword='.$_REQUEST['keyword'].'&dateFrom='.urlencode($_REQUEST['dateFrom']).'&dateTo='.urlencode($_REQUEST['dateTo']));
?>
