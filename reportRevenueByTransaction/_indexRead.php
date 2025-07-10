<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';


	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$statusOrder = isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : '0';
	$statusPayment = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : 'x';
	$costAdds = isset($_REQUEST['costAdds']) ? $_REQUEST['costAdds'] : 0;
	//$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : isset($_REQUEST['categoryIdChoose']) ? explode(',',$_REQUEST['categoryIdChoose']) : array() ;	
	//$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : isset($_REQUEST['categoryIdChoose']) ? explode(',',$_REQUEST['categoryIdChoose']) : array() ;		

	$categoryId = array();
	if(isset($_REQUEST['categoryId'])) {
	  $categoryId = $_REQUEST['categoryId'];
	} else {
	  if(isset($_REQUEST['categoryIdChoose'])) {
	  	$categoryId = explode(',',$_REQUEST['categoryIdChoose']); 
	  }
	}

	$where = '';
	
	$where .= $statusPayment != 'x' ? " and status_payment = '$statusPayment '" : "";	
	if($statusOrder == 'x') {
		$where .= " ";
	} else if ($statusOrder == '4') {
		$where .= " and status_order in ('4')";	
	} else {
		$where .= " and status_order in ('0','1','2','3')";	
	}


	if(count($categoryId) > 0) {
		$categoryIdChoose = '';
		foreach($categoryId as $val) {
			$categoryIdChoose = $categoryIdChoose.$val.',';
		}
		$categoryIdChoose = substr($categoryIdChoose,0,strlen($categoryIdChoose)-1);
	} else {
		if(strlen($_REQUEST['categoryIdChoose']) > 0) {
			$categoryIdChoose = $_REQUEST['categoryIdChoose'] ;
		} else {
			$query = "select id,name 
				from stuff_category
				where is_delete = '0'
				order by name";
			$tmpCategory = mysql_query($query) or die (mysql_error());
			while($rowCategory = mysql_fetch_array($tmpCategory)) {
				$categoryIdChoose = $categoryIdChoose.$rowCategory['id'].',';		
			}
			$categoryIdChoose = substr($categoryIdChoose,0,strlen($categoryIdChoose)-1);
		}	
	}

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		order by name";
	$dataCategory = mysql_query($query) or die (mysql_error());
	$jmlDataCategory = mysql_num_rows($dataCategory);


	$where .= in_array(count($categoryId), array(0,$jmlDataCategory)) ? " " : " and s.category_id in ($categoryIdChoose)  ";

	if(isset($_REQUEST['buyer'])) {
		/*
		$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
				description_payment, description_shipping, discount_amount, amount_sale,  amount_basic_sale, shipping_cost, 
				date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
				date_format(date_order,'%d/%m/%Y') as date_order_frm,
				date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
				date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
				date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
				(select m.name from member as m where m.id = sales_id) as sales_name,			
				( (amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as total
			from sales_order
			where is_delete = '0'
			  and (date_order >= '$dateFrom' and date_order <= '$dateTo')
			  $where
			group by REPLACE(REPLACE(REPLACE(phone,'-',''),' ',''),'+','')  
			order by date_order, total desc";
			*/			

		$query = "select so.id, so.no_order, so.client_id, so.period_order_id, so.name, so.address_shipping, so.tipe_order,
				so.description_payment, so.description_shipping, so.discount_amount, so.amount_sale,  so.amount_basic_sale, so.shipping_cost, 
				so.date_order, so.date_packing, so.date_payment, so.date_shipping, so.status_order, so.phone, so.discount_persen, so.status_payment,
				date_format(so.date_order,'%d/%m/%Y') as date_order_frm,
				date_format(so.date_payment,'%d/%m/%Y') as date_payment_frm,
				date_format(so.date_packing,'%d/%m/%Y') as date_packing_frm,
				date_format(so.date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
				( (so.amount_sale - ((so.amount_sale / 100) * so.discount_persen)) + so.shipping_cost) as jml,
				( (so.amount_sale / 100) * so.discount_persen) as jml_diskon,
				( (so.amount_sale - ((so.amount_sale / 100) * so.discount_persen)) - so.amount_basic_sale) as jml_laba,
				(select m.name from member as m where m.id = sales_id) as sales_name,
				(select c.name from stuff_category as c where c.id = s.category_id) as category_name,
				sod.price, sod.price_basic, sod.amount as sod_amount,
				(((sod.price * sod.amount) / 100) * (so.discount_persen )) as jml_diskon_per_category,
				(so.shipping_cost / (select count(sod_item.id) as jml_item 
				                   from sales_order_detail as sod_item where sod_item.sales_order_id = so.id)) 
				                   as shipping_cost_per_category,
				( ((sod.price * sod.amount) - (((sod.price * sod.amount) / 100) * so.discount_persen)) - (sod.price_basic * sod.amount)) as jml_laba_per_category,				
				( (so.amount_sale - ((so.amount_sale / 100) * so.discount_persen)) + shipping_cost) as total,
				so.phone
			from sales_order as so
			inner join sales_order_detail as sod 
			  on sod.sales_order_id = so.id
			inner join stuff as s
			  on s.id = sod.stuff_id			  			  
			where so.is_delete = '0'
			  and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
			  $where
			order by so.date_order, total desc";

	} else {
		if(in_array(count($categoryId), array(0,$jmlDataCategory))) {
			$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
					description_payment, description_shipping, discount_amount, amount_sale,  amount_basic_sale, shipping_cost, 
					date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, discount_amount, status_payment,
					date_format(date_order,'%d/%m/%Y') as date_order_frm,
					date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
					date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
					date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
					( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml,
					( (amount_sale / 100) * discount_persen) as jml_diskon,
					( ((amount_sale - (((amount_sale / 100) * discount_persen))) - discount_amount) - amount_basic_sale) as jml_laba,
					(select m.name from member as m where m.id = sales_id) as sales_name			
				from sales_order
				where is_delete = '0'
				  and (date_order >= '$dateFrom' and date_order <= '$dateTo')
				  $where
				order by date_order, no_order";
		} else {		
		/*	
		$query = "select so.id, so.no_order, so.client_id, so.period_order_id, so.name, so.address_shipping, so.tipe_order,
				so.description_payment, so.description_shipping, so.discount_amount, so.amount_sale,  so.amount_basic_sale, so.shipping_cost, 
				so.date_order, so.date_packing, so.date_payment, so.date_shipping, so.status_order, so.phone, so.discount_persen, so.discount_amount, so.status_payment,
				date_format(so.date_order,'%d/%m/%Y') as date_order_frm,
				date_format(so.date_payment,'%d/%m/%Y') as date_payment_frm,
				date_format(so.date_packing,'%d/%m/%Y') as date_packing_frm,
				date_format(so.date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
				( ((so.amount_sale - ((so.amount_sale / 100) * so.discount_persen))  - discount_amount) + so.shipping_cost) as jml,
				( (so.amount_sale / 100) * so.discount_persen) as jml_diskon,
				( ((so.amount_sale - ((so.amount_sale / 100) * so.discount_persen)) - discount_amount) - so.amount_basic_sale) as jml_laba,
				(select m.name from member as m where m.id = sales_id) as sales_name,
				(select c.name from stuff_category as c where c.id = s.category_id) as category_name,
				sod.price, sod.price_basic, sod.amount as sod_amount,
				(((sod.price * sod.amount) / 100) * (so.discount_persen )) as jml_diskon_per_category,
				(so.shipping_cost / (select count(sod_item.id) as jml_item 
				                   from sales_order_detail as sod_item where sod_item.sales_order_id = so.id)) 
				                   as shipping_cost_per_category,
				( (((sod.price * sod.amount) - (((sod.price * sod.amount) / 100) * so.discount_persen)) - so.discount_amount ) - (sod.price_basic * sod.amount)) as jml_laba_per_category
			from sales_order as so
			inner join sales_order_detail as sod 
			  on sod.sales_order_id = so.id
			inner join stuff as s
			  on s.id = sod.stuff_id			  			  
			where so.is_delete = '0'
			  and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
			  $where
			group by so.id  
			order by date_order, no_order";
		*/

		$query = "select so.id, so.no_order, so.client_id, so.period_order_id, so.name, so.address_shipping, so.tipe_order,
				so.description_payment, so.description_shipping, so.discount_amount, so.amount_sale,  so.amount_basic_sale, so.shipping_cost, 
				so.date_order, so.date_packing, so.date_payment, so.date_shipping, so.status_order, so.phone, so.discount_persen, so.discount_amount, so.status_payment,
				date_format(so.date_order,'%d/%m/%Y') as date_order_frm,
				date_format(so.date_payment,'%d/%m/%Y') as date_payment_frm,
				date_format(so.date_packing,'%d/%m/%Y') as date_packing_frm,
				date_format(so.date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
				(( ((so.amount_sale - ((so.amount_sale / 100) * so.discount_persen))  - discount_amount) + so.shipping_cost)) as jml,
				(( (so.amount_sale / 100) * so.discount_persen)) as jml_diskon,
				( ((so.amount_sale - ((so.amount_sale / 100) * so.discount_persen)) - discount_amount) - so.amount_basic_sale) as jml_laba,
				(select m.name from member as m where m.id = sales_id) as sales_name,
				(select c.name from stuff_category as c where c.id = s.category_id) as category_name,
				sod.price, sod.price_basic, sod.amount as sod_amount,
				(((sod.price * sod.amount)) - (so. discount_amount )) as jml_diskon_amount_per_category,
				(((sod.price * sod.amount) / 100) * (so.discount_persen )) as jml_diskon_per_category,
				(so.shipping_cost / (select count(sod_item.id) as jml_item 
				                   from sales_order_detail as sod_item where sod_item.sales_order_id = so.id)) 
				                   as shipping_cost_per_category,
				( (((sod.price * sod.amount) - (((sod.price * sod.amount) / 100) * so.discount_persen)) - so.discount_amount ) - (sod.price_basic * sod.amount)) as jml_laba_per_category
			from sales_order as so
			inner join sales_order_detail as sod 
			  on sod.sales_order_id = so.id
			inner join stuff as s
			  on s.id = sod.stuff_id			  			  
			where so.is_delete = '0'
			  $where
			  and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
			group by so.id, s.category_id 			  
			order by date_order, no_order";
		}	
	}
			
	$data = mysql_query($query) or die(mysql_error());

	$whereCategoryPrint .= strlen($categoryIdChoose) > 0 ? " and id in ($categoryIdChoose)" : " ";

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  $whereCategoryPrint
		order by name";
	$dataCategoryPrint = mysql_query($query) or die (mysql_error());
		
	include '../lib/connection-close.php';
?>
