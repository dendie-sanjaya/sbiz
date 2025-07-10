<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$stuffBundlingId = general::secureInput($_POST['stuffBundlingId']);
	$stuffIdChoose  = $_POST['stuffIdChoose'];
	
	foreach($stuffIdChoose as $val) {
	    $qty = general::secureInput($_POST['qty_'.$val]);		    

	    $query = "insert stuff_bundling_detail
			set stuff_bundling_id = '$stuffBundlingId',
			  stuff_id = '$val',
			  qty = '$qty'";
		mysql_query($query) or die (mysql_error());
	}	

	include '../lib/connection-close.php';

	header('Location:addStuffSaveSuccess.php?msg=addSuccess&stuffBundlingId='.$stuffBundlingId);
?>
