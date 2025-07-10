<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$_REQUEST['tipeOrder'] = isset($_REQUEST['tipeOrder']) ? $_REQUEST['tipeOrder'] : 0; 
	$_REQUEST['clientId'] = isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : 0;
	$clientId = $_REQUEST['clientId'];
	$tipeOrder = $_REQUEST['tipeOrder'];
	
	$query = "select id, name
	from period_order		
	where is_delete = '0' 
	 and is_status = '0'
	order by name";

	$dataPeriodeOrder = mysql_query($query) or die (mysql_error());

	$query = "select id, name, phone
	from client		
	where is_delete = '0' 
	order by name, phone";

	$cmbClient = mysql_query($query) or die (mysql_error());

	
	$query = "select id, name, phone,address
	from client		
	where id = '$clientId'";

	$tmp = mysql_query($query) or die (mysql_error());
	$dataClient = mysql_fetch_array($tmp); print_r($dataClient);  exit;
	if($clientId != '0') {	
		if($_REQUEST['hiddenClientId'] != $clientId ) {
			$_POST['name'] = '';
			$_POST['phone'] = ''; 
			$_POST['address'] = '';		
		} else {
			$_POST['name'] = strlen($_POST['name']) > 0 ? $_POST['name'] : '';
			$_POST['phone'] = strlen($_POST['phone']) > 0 ? $_POST['phone'] : ''; 
			$_POST['address'] = strlen($_POST['address']) > 0 ? $_POST['address'] : '';
		}
	} else { 
		$_POST['name'] = '';
		$_POST['phone'] = '';
		$_POST['address'] = '';
	}	
	include '../lib/connection-close.php';
?>
