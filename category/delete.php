<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];

	$query = "update stuff_category
		set is_delete = '1'
		where id='$id'";

	mysql_query($query);

	$query = "select id,name
		from stuff_category
		where is_delete = '0'
		order by name";

	$data = mysql_query($query) or die (mysql_error());

	while($val = mysql_fetch_array($data)) {
		$category .= $val['id'].'~';
	}

	$query = "update member
		set access_category_id = '$category'
		where id='1'";

	mysql_query($query) or die (mysql_error());

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&type=4');
?>
