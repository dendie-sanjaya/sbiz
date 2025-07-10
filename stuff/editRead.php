<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];

	$query = "select id,name 
		from const
		where is_delete = '0'
		and type ='1'
		order by name";

	$dataConst = mysql_query($query) or die (mysql_error());

	$query = "select id,name 
		from location
		where is_delete = '0'
		order by name";

	$dataLocation = mysql_query($query) or die (mysql_error());

	$query = "select id, name, nickname, sku, stock, stock_min_alert, const_id, location_id, price, category_id,
		  price_basic, nickname, fee_sales, is_hidden, cost_cs, cost_ops, cost_riset, cost_adv
		from stuff
		where id = '$id'";

	$tmp = mysql_query($query);
	$data = mysql_fetch_array($tmp);

	$categoryIdDefault = $data['category_id'];
	$stuffIdDefault = $data['id'];
	$typeSubCategory = 0;

	if(isset($_REQUEST['categoryId'])) {
		$categoryIdDefault = $_REQUEST['categoryId'];
	}	

	$query = "select sub.name as name, row.name as row_name, row.id as row_id
		from stuff_category_sub_row as row 	
		right join stuff_category_sub as sub
		  on sub.id = row.stuff_category_sub_id 		
		where row.stuff_id = '$stuffIdDefault'
		  and sub.stuff_category_id = '$categoryIdDefault'";
	$dataSubCategory = mysql_query($query) or die (mysql_error());
	$dataSubCategoryAmountRow = mysql_num_rows($dataSubCategory);

	if($dataSubCategoryAmountRow < 1) {
		$typeSubCategory = 1;
		$query = "select id as row_id, name, concat('') as row_name
			from stuff_category_sub
			where stuff_category_id ='$categoryIdDefault'";
		$dataSubCategory = mysql_query($query) or die (mysql_error());		
	}

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";

	$dataCategory = mysql_query($query) or die (mysql_error());	

	include '../lib/connection-close.php';
?>
