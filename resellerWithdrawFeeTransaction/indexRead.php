<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';
	include '../lib/split.class.php';	

	$_REQUEST['resellerDateTransfer'] = isset($_REQUEST['resellerDateTransfer']) ? $_REQUEST['resellerDateTransfer'] : date('d/m/Y');

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	$resellerId = isset($_REQUEST['resellerId']) ? $_REQUEST['resellerId'] :''; 

	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where = '';
	$where .= strlen($resellerId) > 0 ? " and reseller_id in ($resellerId)" : "";	

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order, expedition_id,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost,sales_id, amount_fee_reseller,
			(select m.name from member as m where m.id = sales_id) as sales_name,
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
		  	status_payment_commision_reseller, status_payback_cod_reseller,			
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			date_format(date_order,'%d %M %Y') as date_order_frm, 
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
	        ((amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as total_nilai,
	        amount_fee_reseller			
		from sales_order
		where is_delete = '0'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')		   
		  and is_reseller = '1'
		  and status_payment_commision_reseller = '0'
		  and status_payment = '1'
		  $where
		order by date_order asc, no_order asc, name";

	$data = mysql_query($query) or die(mysql_error());	

	$query = "select id,name from reseller
	 		  where is_delete = '0'";
	$cmbReseller = mysql_query($query) or die(mysql_error());	

	$query = "select id,name from reseller
	 		  where id = '$resellerId'";
	$tmpReseller = mysql_query($query) or die(mysql_error());	
	$dataReseller = mysql_fetch_array($tmpReseller);

	$query = "select id,concat(bank_name,' - ',account_name,' - ',account_number) as bank_to from reseller_bank
	 		  where reseller_id = '$resellerId'
	 		    and is_delete = '0'";
	$cmbResellerBank = mysql_query($query) or die(mysql_error());	

	include '../lib/connection-close.php';
?>
