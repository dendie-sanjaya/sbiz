<?php 
	@session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	
	if(!$_SESSION['login']) {
		header('Location:../login/index.php');
	} else {
		if($_SESSION['loginApp'] != 'simpleSBiZ') {
			header('Location:../login/index.php');
		}
	}	
?>
