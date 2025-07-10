<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';
	include '../lib/general.class.php';


	$date = general::secureInput($_REQUEST['date']);
	$type = general::secureInput($_REQUEST['type']);


	$where = '';
	if($type == 1) {
		$query = "select id, no_order, name,
	            ((amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as total_nilai,
	            date_format(date_order,'%d %M %Y') as date_order_frm,
	            (select m.name from member as m where m.id = so.sales_id) as sales_name	            
			  from sales_order as so
			  where so.is_delete = '0'		
				and date_format(date_order,'%Y-%m-%d') = '$date' 
			  order by so.no_order, so.date_order ";	
	} else {
		if($type == 2) {
			$where .= " and date_format(datetime_track,'%Y-%m-%d') = '$date' ";	
			$where .= " and activity = '1' ";	
		}

		if($type == 3) {
			$where .= " and date_format(datetime_track,'%Y-%m-%d') = '$date' ";	
			$where .= " and activity = '2' ";	
		}

		if($type == 4) {
			$where .= " and date_format(datetime_track,'%Y-%m-%d') = '$date' ";	
			$where .= " and activity = '3' ";	
		}

		if($type == 5) {
			$where .= " and date_format(datetime_track,'%Y-%m-%d') = '$date' ";	
			$where .= " and activity = '5' ";	
		}

		$query = "select so.id, so.sales_order_id, no_sales_order, 		 		
	            date_format(datetime_track,'%d %M %Y, %H:%i:%s') as date_track,
	            (select m.name from member as m where m.id = u.member_id) as member_name,
	            u.username
			  from sales_order_history as so
			  left join user as u
			    on u.id = so.user_id	
			  where 1=1
				$where
				 and so.is_delete = '0'
			  order by so.datetime_track,so.no_sales_order ";	
	}
		
					
	$data = mysql_query($query) or die (mysql_error());
	
	include '../lib/connection-close.php';
?>
