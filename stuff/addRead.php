<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include '../lib/message.class.php';
	

	$id = general::secureInput($_GET['id']);
	$query = "select id, sku, nickname, name, stock, stock_min_alert, const_id, location_id, price, category_id,
		  price_basic, nickname, fee_sales, is_hidden, cost_cs, cost_ops, cost_riset, cost_adv
		from stuff
		where id = '$id'";
	$tmp = mysql_query($query);
	$dataCopy = mysql_fetch_array($tmp);

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


	$categoryIdDefault = '';
	if(isset($_REQUEST['categoryId'])) {
		$categoryIdDefault = $_REQUEST['categoryId'];

		$query = "select id, name, concat('') as row_name
			from stuff_category_sub
			where stuff_category_id ='$categoryIdDefault'";
		$dataSubCategory = mysql_query($query) or die (mysql_error());

	} else {
		if(strlen($_GET['id']) > 0) {
			$categoryIdDefault = $dataCopy['category_id'];
			$stuffIdDefault = $dataCopy['id'];

			$query = "select row.name as row_name, sub.id as id, sub.name as name
				from stuff_category_sub_row as row 	
				inner join stuff_category_sub as sub
				  on sub.id = row.stuff_category_sub_id 		
				where row.stuff_id = '$stuffIdDefault'
				  and sub.stuff_category_id = '$categoryIdDefault'";
			$dataSubCategory = mysql_query($query) or die (mysql_error());
		} else {
			$query = "select id,name 
				from stuff_category
				where is_delete = '0'
				  and id in ($loginAccessCategory)
				order by name";
			$dataCategoryDefault = mysql_query($query) or die (mysql_error());
			$rstDataCategoryDefault = mysql_fetch_array($dataCategoryDefault);
			$categoryIdDefault = $rstDataCategoryDefault['id'];

			$query = "select id, name, concat('') as row_name
				from stuff_category_sub
				where stuff_category_id ='$categoryIdDefault'";
			$dataSubCategory = mysql_query($query) or die (mysql_error());
		}	
	}


	
	include '../lib/connection-close.php';
?>
