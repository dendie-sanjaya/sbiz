<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];

	$query = "delete from member
		where id='$id'";

	mysql_query($query);

	$query = "delete from user
		where member_id='$id'";

	mysql_query($query);

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&type=4');
?>
