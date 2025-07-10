<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']);
	
	$query = "select c.id, c.name, c.phone_number, c.country_code, c.city, c.sales_id, c.date_input,
		date_format(date_input,'%d/%m/%Y') as date_input_frm
		from customer as c
		where id = '$id'";
	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);

	$query = "select cg.id, cg.client_id
		from customer_group as cg
		where customer_id = '$id'";
	$tmp = mysql_query($query) or die (mysql_error());

	$dataCategoryChoose = array();
	while($row = mysql_fetch_array($tmp)) {
		$dataCategoryChoose[] = $row['client_id'];
	}

	$query = "select id,name 
		from  member
		where position_id = '3'
		order by name";

	$dataSales = mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from client
		where is_delete = '0'
		order by name";

	$dataCategory = mysql_query($query) or die (mysql_error());

	$loginMemberId = $_SESSION['loginMemberId'];
	$query = "select id,name 
		from  member
		where id = '$loginMemberId'
		order by name";

	$tmpSalesDefault = mysql_query($query) or die (mysql_error());
	$dataSalesDefault = mysql_fetch_array($tmpSalesDefault);
	
	include '../lib/connection-close.php';
?>
