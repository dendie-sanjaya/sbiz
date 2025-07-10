<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

	$query = "select id,name 
		from const
		where is_delete = '0'
		and type ='1'
		order by name";

	$data = mysql_query($query) or die (mysql_error());


	$query = "select id,name 
		from location
		where is_delete = '0'
		order by name";

	$dataLocation = mysql_query($query) or die (mysql_error());

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
