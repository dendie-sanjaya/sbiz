<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_POST['id']);
	$resellerId = general::secureInput($_POST['resellerId']);
	$resellerStuffIdChoose = $_POST['resellerStuffIdChoose'];
	$resellerStuffId  = $_POST['resellerStuffId'];


	$i = 0;
	foreach($resellerStuffId as $val) {
		if (in_array($val,$resellerStuffIdChoose)) {
		    $linkProductBrosur = general::secureInput($linkStuff[$i]);
		    $priceBasic = general::secureInput($priceBasicReseller[$i]);	
		    $feeResellerNominalGet = general::secureInput($feeResellerNominal[$i]);
		    $feeResellerPercentGet = general::secureInput($feeResellerPercent[$i]);	

		    $query = "update reseller_stuff
				set is_delete = '1'
				 where id = '$val' 
				   and reseller_id = '$resellerId'";		


			mysql_query($query) or die (mysql_error());
		}	
	   $i++;
	}	

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&resellerId='.$resellerId);?>
