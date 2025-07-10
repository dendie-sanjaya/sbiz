<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$resellerId = general::secureInput($_POST['resellerId']);
	$stuffIdChoose  = $_POST['stuffIdChoose'];
	$stuffId  = $_POST['stuffId'];
	$linkStuff  = $_POST['linkStuff'];
	$priceBasicReseller = $_POST['priceBasicReseller'];
	$feeResellerPercent = $_POST['feeResellerPercent'];
	$feeResellerNominal = $_POST['feeResellerNominal'];
	$point = $_POST['point'];
	
	$i = 0;
	foreach($stuffId as $val) {
		if (in_array($val,$stuffIdChoose)) {
		    $linkProductBrosur = general::secureInput($linkStuff[$i]);
		    $priceBasic = general::secureInput($priceBasicReseller[$i]);	
		    $feeResellerNominalGet = general::secureInput($feeResellerNominal[$i]);
		    $feeResellerPercentGet = general::secureInput($feeResellerPercent[$i]);	
		    $pointGet = general::secureInput($point[$i]);	

		    $query = "insert reseller_stuff
				set reseller_id = '$resellerId',
				  stuff_id = '$val',
				  link_product_brosur = '$linkProductBrosur',
				  price = '0',	
				  price_basic = '$priceBasic',	
				  fee_reseller_nominal = '$feeResellerNominalGet',	
				  fee_reseller_percent = '$feeResellerPercentGet',	
				  point = '$pointGet',	
				  is_delete = '0'";		

			mysql_query($query) or die (mysql_error());
		}	
	   $i++;
	}	


	include '../lib/connection-close.php';

	header('Location:addSaveSuccess.php?msg=addSuccess&resellerId='.$resellerId);
?>
