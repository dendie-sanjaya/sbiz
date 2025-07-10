<?php 	
	include '../lib/connection.php';

	$status = true;
	$msgError = array();


	if(empty($_FILES['data_reseller'])) {
		$status = false;
		$msgError['data_reseller'] = 'Silakan mengisikan file';
	} else {
		if(!in_array(strtolower($_FILES['data_reseller']['type']),array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))) {
			$status = false;
			$msgError['data_reseller'] = 'Silakan upload file bertipe xls atau xlsx';
		}
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>