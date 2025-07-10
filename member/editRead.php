<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	$id = $_REQUEST['id'];

	$query = "select id,name,position_id,is_enabled,access_category_id, phone
		from member
		where id='$id'";
	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	$dataExecutor = explode('~',$data['access_category_id']);

	$query = "select id,username
		from user
		where member_id = '$id'";
	$tmp = mysql_query($query) or die (mysql_error());
	$dataUser = mysql_fetch_array($tmp);

	$query = "select id,name 
		from position
		where is_delete = '0'
		order by name";
	$dataPosition = mysql_query($query) or die (mysql_error());

	$query = "select id,name
		from stuff_category
		where is_delete = '0'
		order by name";

	$dataCategory = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
