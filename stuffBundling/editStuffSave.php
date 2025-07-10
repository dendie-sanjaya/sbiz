<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$stuffBundlingId = general::secureInput($_POST['stuffBundlingId']);
	$stuffIdChoose  = $_POST['stuffIdChoose'];
	
	foreach($stuffIdChoose as $val) {
	    $qty = general::secureInput($_POST['qty_'.$val]);	

	    $query = "update stuff_bundling_detail
			set qty = '$qty'
			where stuff_bundling_id = '$stuffBundlingId' 
			  and id = '$val'";

		mysql_query($query) or die (mysql_error());
	}	
	
	include '../lib/connection-close.php';
	header('Location:stuff.php?msg=editSuccess&id='.$stuffBundlingId);?>
