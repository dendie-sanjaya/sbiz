<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include '../lib/PHPExcel/Classes/PHPExcel/IOFactory.php';
	$_SESSION['import_reseller_err_msg'] = '';
	$_SESSION['import_reseller_err_success'] = '';


	if(!empty($_FILES['data_reseller']['tmp_name'])) {
		$inputFileName = $_FILES['data_reseller']['tmp_name'];
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
		$i = 0;
		foreach($sheetData as $val) {
			if($i != 0) {
				if(!empty($val['A']) && !empty($val['C']) && !empty($val['D']) && !empty($val['A'])) {
					$name = general::secureInput($val['A']);
					$countryCode = general::secureInput($val['B']);
					$phone = general::secureInput($val['C']);
					$city = general::secureInput($val['D']);
					$email = general::secureInput($val['E']);
					$username = trim(general::secureInput($val['F']));
					$password = general::secureInput(trim(md5($val['G'])));
					$isActive = 1;
					$isDropshipper = ($val['H'] == 'Yes' ? 1 : 0);
					
					$query = "select count(*) as total
							  from reseller as r
						  	  where is_delete = '0' 	 
						  	   and (phone_number = '$phone' or email = '$email' or username = '$username' )";
					$tmp = mysql_query($query) or die (mysql_error());
					$check = mysql_fetch_array($tmp);
					if($check['total'] > 0) {
					   $_SESSION['import_reseller_err_msg'][] = [$name,$countryCode,$phone,$city,$email,$username,$val['G'],$val['H']];
					} else {
						$query = "insert reseller
							set name = '$name',
							  country_code = '$countryCode',
							  phone_number= '$phone',
							  city = '$city',	
							  email = '$email',	
							  username = '$username',	
							  password = '$password',	
							  date_input = now(),
							  is_dropshipper = '$isDropshipper',
							  is_active = '$isActive',		  
							  is_delete = '0'";		
						mysql_query($query) or die (mysql_error());		

					   $_SESSION['import_reseller_err_succes'][] = [$name,$countryCode,$phone,$city,$email,$username,$password,$_POST['isDropshipper']];						
					}		
				}	
			}	
			$i++;
		}	
	}

	include '../lib/connection-close.php';
	
	if(!empty($_SESSION['import_reseller_err_msg']) > 0) {
	    header('Location:add.php?msg=addError');		
	} else {
	  header('Location:../reseller/index.php?msg=addSuccess');		
	}	
?>
