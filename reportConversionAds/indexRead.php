<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
  
	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$statusPayment = isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : 'x';
	
	/*
		$statusOrder = isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : 'x';
		$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : explode(',',$_REQUEST['categoryIdChoose']) ;	
		$orderBy = isset($_REQUEST['orderBy']) ? $_REQUEST['orderBy'] : '0';

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
			$categoryIdChoose = $_REQUEST['categoryIdChoose'] ;
		}

		$where .= strlen($categoryIdChoose) > 0 ? " and category_id in ($categoryIdChoose)" : "  ";	

		$query = "select id,name 
			from stuff_category
			where is_delete = '0'
			order by name";
		$dataCategory = mysql_query($query) or die (mysql_error());	
	*/

	if( (strlen($dateFrom) > 8) && strlen($dateTo) > 8) { 	
		$where = '';
		$where .= $statusPayment != 'x' ? " and so.status_payment = '$statusPayment '" : "";	

		/* start: get data date */
		    $listDateDay = [];

			$date1=date_create($dateFrom);
			$date2=date_create($dateTo);
			$diff=date_diff($date1,$date2);
			$dateDiff =  $diff->format("%a");

			$no=1;
			for($i = 0; $i <= $dateDiff; $i++) {
			   $dateTrx = date('Y-m-d', strtotime($dateFrom. " + $i day"));
			   $timestamp = strtotime($dateTrx);
			   $day = date('D', $timestamp);
			   $dayIndonesia = ['Sun'=>'Minggu','Mon'=>'Senin','Tue'=>'Selasa','Wed'=>'Rabu','Thu'=>'Kamis','Fri'=>'Jumat','Sat'=>'Sabtu'];
			   
			   $rowData = [$no,$dayIndonesia[$day],$dateTrx];		   	
			   //for($l = 3; $l < count($dataHead; $l++) {
			   //   array_push($rowData,$dataSetMarketPlace[$valHead][$dateTrx]['total_revenue']);	   	
			   //}

			   array_push($listDateDay,$rowData);
			   $no++;
			}
		/* end: get data end */

		/* start: get data promo */
			$query = "select id,name,description,date_transaction
				from promotion_calendar
				where is_delete = '0'
				and is_delete = '0'
				order by date_transaction";
			$dataPromo = mysql_query($query) or die (mysql_error());	

			$dataSetPromo = array();
			while ($rowPromo = mysql_fetch_array($dataPromo)) {
				$dataSetPromoName = strtoupper(trim($rowPromo['name']));

				if(empty($dataSetPromo[$rowPromo['date_transaction']])) {
				  $dataSetPromo[$rowPromo['date_transaction']]  = $dataSetPromoName;   				
				} else {
				  $dataSetPromo[$rowPromo['date_transaction']]  = ($dataSetPromo[$rowPromo['date_transaction']].', '.$dataSetPromoName);   				
				}
			} 
		/* end: get data promo */

		/* start: get data marketpace */
			$query = "select id,name 
				from platform_market
				where is_delete = '0'
				  and is_marketplace = '1'
				order by name";
			$dataMarketPlace = mysql_query($query) or die (mysql_error());

			$dataSetMarketPlace = array();
			while ($rowMarketPlace = mysql_fetch_array($dataMarketPlace)) {
				$dataSetMarketPlaceId = $rowMarketPlace['id'];
				$dataSetMarketPlaceName = strtoupper(trim($rowMarketPlace['name']));

				$query = "select date_order,platform_market_id,sum(so.amount_sale  - (discount_amount  +  (amount_sale / 100) * discount_persen) ) as total_revenue, count(so.id) as total_trx,
				      sum((select sum(sod.amount) from sales_order_detail as sod where sod.sales_order_id = so.id )) as qty_total
					from sales_order as so	
					where so.is_delete = '0'
					  and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
					  and platform_market_id ='$dataSetMarketPlaceId'
					  $where
					group by so.date_order
					order by date_order asc";

				$tmp = mysql_query($query) or die (mysql_error());
				if(mysql_num_rows($tmp) > 0) {
					while ($row = mysql_fetch_array($tmp)) {    
					  $platform_market_id = !empty($row['platform_market_id']) ? $row['platform_market_id'] : 0;
				   	  $dataSetMarketPlace[$dataSetMarketPlaceId.'~'.$dataSetMarketPlaceName][$row['date_order']] = ['total_revenue' => $row['total_revenue'], 'total_qyt' => $row['qty_total'], 'total_trx' => $row['total_trx']];
				    }
				} else {
					  $platform_market_id = !empty($row['platform_market_id']) ? $row['platform_market_id'] : 0;
				   	  $dataSetMarketPlace[$dataSetMarketPlaceId.'~'.$dataSetMarketPlaceName][$row['date_order']] = ['total_revenue' => 0, 'total_qyt' => 0, 'total_trx' => 0];			
				}    
			}    

			$query = "select date_order,platform_market_id,sum(so.amount_sale  - (discount_amount  +  (amount_sale / 100) * discount_persen) ) as total_revenue,count(so.id) as total_trx,
				      sum((select sum(sod.amount) from sales_order_detail as sod where sod.sales_order_id = so.id )) as qty_total			
				from sales_order as so	
				where so.is_delete = '0'
				  and (so.date_order >= '$dateFrom' and so.date_order <= '$dateTo')
				  and ((platform_market_id is null) or (platform_market_id  = 0))
				  $where				  
				group by so.date_order
				order by date_order asc";

			$tmp = mysql_query($query) or die (mysql_error());
			while ($row = mysql_fetch_array($tmp)) {
			  $platform_market_id = !empty($row['platform_market_id']) ? $row['platform_market_id'] : 0;
		   	  $dataSetMarketPlace['0~LAIN-LAIN'][$row['date_order']] = ['total_revenue' => $row['total_revenue'], 'total_qyt' => $row['qty_total'], 'total_trx' => $row['total_trx']];
		    }

		/* end: get data marketpace */

		/* start: get data ads */
			$query = "select id,name,nominal,type, is_fix, is_show_report_convertion_adds 
				from fin_expenses_revenue
				where is_delete = '0'
				and type = '0'
				and periode = '0'
				and is_show_report_convertion_adds  = '1'
				order by name";
			$dataAds = mysql_query($query) or die (mysql_error());	

			$dataSetAds = array();
			while ($rowAds = mysql_fetch_array($dataAds)) {
				$dataSetAdsId = $rowAds['id'];
				$dataSetAdsName = strtoupper(trim($rowAds['name']));

				$query = "select date_transaction, sum(nominal) as total_ads
					from fin_pay_expenses		
					where is_delete = '0'
					 and (date_transaction >= '$dateFrom' and date_transaction <= '$dateTo')		   		  
					 and periode = '0'
					 and fin_expenses_revenue_id = '$dataSetAdsId'
					group by date_transaction
					order by date_transaction";

				$tmp = mysql_query($query) or die (mysql_error());
				if(mysql_num_rows($tmp) > 0) {
					while ($row = mysql_fetch_array($tmp)) {    
				   	  $dataSetAds[$dataSetAdsId.'~'.$dataSetAdsName][$row['date_transaction']] = ['total_ads' => $row['total_ads']];
				    }
				} else {
				   	  $dataSetAds[$dataSetAdsId.'~'.$dataSetAdsName][$row['date_transaction']] = ['total_ads' => 0];				
				}    
			}    
		/* end: get data ads */
	}	
			
	include '../lib/connection-close.php';
?>
