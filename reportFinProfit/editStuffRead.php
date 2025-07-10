<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	
	$id = $_REQUEST['id'];
	$nominal = $_REQUEST['nominal']; 
	$finProfitLossDetailId = $_REQUEST['finProfitLossDetailId'];
	
	include '../lib/connection-close.php';
?>
