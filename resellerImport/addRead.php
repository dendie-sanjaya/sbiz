<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	
	$_REQUEST['dateInput'] = isset($_REQUEST['dateInput']) ? $_REQUEST['dateInput'] : date('d/m/Y');
	$query = "select id,name 
		from  member
		where position_id = '3'
		order by name";

	$dataSales = mysql_query($query) or die (mysql_error());


	$loginMemberId = $_SESSION['loginMemberId'];
	$query = "select id,name 
		from  member
		where id = '$loginMemberId'
		order by name";

	$tmpSalesDefault = mysql_query($query) or die (mysql_error());
	$dataSalesDefault = mysql_fetch_array($tmpSalesDefault);

	$query = "select id,name
		from client
		where is_delete = '0'
		order by name";

	$dataCategory = mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';	
?>
