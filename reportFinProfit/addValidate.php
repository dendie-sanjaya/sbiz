<?php 	
	$status = true;
	$msgError = array();
	include '../lib/connection.php';
	
	if(strlen(trim($_POST['year'])) < 1) {
		$status = false;
		$msgError['year'] = 'Silakan mengisikan tahun ';
	}

	$month = $_POST['month'];
	$year = $_POST['year'];
	
	$query = "select count(id) as total 
		from fin_profit_loss
		where year ='$year' 
		  and month = '$month'
		  and is_delete = '0'";		  
	$tmp = mysql_query($query) or die (mysql_error());
	$rest = mysql_fetch_array($tmp);

	if($rest['total'] > 0) {
		$status = false;
		$msgError['global'] = "Laporan Laba Rugi Sudah Ada ";
	}
		
	if($status == false) {
		include 'add.php';
		exit;
	}
?>
