<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include_once "../lib/PHPExcel/Classes/PHPExcel.php";

	$salesOrderId = $_REQUEST['salesOrderId'];
	$salesOrderIdStr = implode(',',$salesOrderId);

	$query = "select s.id, s.no_order, s.client_id, s.period_order_id, s.name, s.address_shipping, s.tipe_order, packing_option,
			s.description_payment, s.description_shipping, s.discount_amount, s.amount_sale, s.shipping_cost, s.city, s.province,
			s.date_order, s.date_packing, s.date_payment, s.date_shipping, s.status_order, s.phone, s.discount_persen, s.status_payment,
			(select w.code from warehouse_external as w where w.id = s.warehouse_external_id) as warehouse_external_code,			
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name, service_option,
			(select m.name from member as m where m.id = sales_id) as sales_name,						
			(select m.phone from member as m where m.id = sales_id) as sales_phone,	
			(select st.sku from stuff as st where st.id = sd.stuff_id) as stuff_sku,
			(select dc.code from district as dc where dc.id = s.disctrict_id) as district_code,					
			date_format(s.date_order,'%d-%m-%Y') as date_order_frm,
			date_format(s.date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(s.date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(s.date_shipping,'%d/%m/%Y') as date_shipping_frm,
			s.no_resi,
			( (s.amount_sale - ((s.amount_sale / 100) * s.discount_persen)) + shipping_cost) as jml,
			s.districts, s.districts_sub, s.postal_code, sd.amount as stuff_amount
		from sales_order as s
		inner join sales_order_detail as sd
		  on sd.sales_order_id = s.id
		where s.is_delete = '0'
		  and s.id in ($salesOrderIdStr)		
		order by s.date_order, s.no_order, s.name";
	$data = mysql_query($query) or die(mysql_error());

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getSheet(0)->setTitle('Pengiriman');		

	$objPHPExcel->getSheet(0)
        ->setCellValue('A1', 'No. Order')
        ->setCellValue('B1', 'Nama Pengirim')
        ->setCellValue('C1', 'No. Telp Pengirim')
        ->setCellValue('D1', 'Nama Penerima')
        ->setCellValue('E1', 'Email Penerima')
        ->setCellValue('F1', 'No. Telp Penerima')
        ->setCellValue('G1', 'Alamat Penerima')
        ->setCellValue('H1', 'Kode Kecamatan Penerima')
        ->setCellValue('I1', 'Kode Pos Penerima')
        ->setCellValue('J1', 'Kode Gudang')
        ->setCellValue('K1', 'Kode SKU')
        ->setCellValue('L1', 'Jumlah')
        ->setCellValue('M1', 'Layanan JNE')
        ->setCellValue('N1', 'Catatan');

	$objPHPExcel->getSheet(0)->getStyle('A1:N1')->getFont()->setBold(true);
	$objPHPExcel->getSheet(0)->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getSheet(0)->getColumnDimension('A')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('B')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('C')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('D')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('E')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('F')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('G')->setWidth(35);
	$objPHPExcel->getSheet(0)->getColumnDimension('H')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('I')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('J')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('K')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('L')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('M')->setWidth(23);
	$objPHPExcel->getSheet(0)->getColumnDimension('N')->setWidth(23);
	
	$row = 2;
	while($val = mysql_fetch_array($data)) {
		if(substr($val['phone'],0,2) == '62') {
		  $phoneNew = '0'.substr($val['phone'],2);
		} else {
		  $phoneNew = $val['phone'];
		}

		if(substr($val['sales_phone'],0,2) == '62') {
		  $salesPhoneNew = '0'.substr($val['sales_phone'],2);
		} else {
		  $salesPhoneNew = $val['sales_phone'];
		}
		
		$packingOptionLabel = '';
		if($val['packing_option'] == '1') {
		  $packingOptionLabel = 'Bubble Wrap'; 	
		}

		if($val['packing_option'] == '2') {
		  $packingOptionLabel = 'Packing Kayu'; 	
		}

		if($val['packing_option'] == '3') {
		  $packingOptionLabel = 'Packing Kardus'; 	
		}
		
		$serviceOptionLabel = '';
		if($val['service_option'] == '0') {
		  $serviceOptionLabel = 'Reg'; 	
		}

		if($val['service_option'] == '1') {
		  $serviceOptionLabel = 'Yes'; 	
		}


		$objPHPExcel->getSheet(0)
	        ->setCellValue('A'.$row, $val['no_order'])
	        ->setCellValue('B'.$row, strtolower($val['sales_name']))
	        ->setCellValue('C'.$row, strtolower($salesPhoneNew))
	        ->setCellValue('D'.$row, strtolower($val['name']))
	        ->setCellValue('E'.$row, 'mahiraworkshop@gmail.com')
	        ->setCellValue('F'.$row, strtolower($phoneNew))
	        ->setCellValue('G'.$row, strtolower(preg_replace("#[^A-Za-z0-9\:,. ]+#", "", preg_replace('/\s+/',' ',$val['address_shipping'])).'. Kec.'.$val['districts'].', '.$val['city'].', Prov '.$val['province']))
	        ->setCellValue('H'.$row, strtolower($val['district_code']))
	        ->setCellValue('I'.$row, strtolower($val['postal_code']))
	        ->setCellValue('J'.$row, strtoupper($val['warehouse_external_code']))	        
	        ->setCellValue('K'.$row, strtoupper($val['stuff_sku']))
	        ->setCellValue('L'.$row, strtolower($val['stuff_amount']))
	        ->setCellValue('M'.$row, strtoupper($serviceOptionLabel))
	        ->setCellValue('N'.$row, strtoupper($packingOptionLabel));

	        $objPHPExcel->getSheet(0)->getStyle('A'.$row.':N'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$row++;        
	}

	$query = "select * from warehouse_external where is_delete = '0' order by code";
	$data = mysql_query($query) or die(mysql_error());
	
	//$objWorkSheet = $objPHPExcel->createSheet();
	//$objPHPExcel->addSheet($objWorkSheet);	
	$objPHPExcel->createSheet();
	$objPHPExcel->getSheet(1)->setTitle('Kode Gudang');		
	$objPHPExcel->getSheet(1)->setCellValue('A1', 'Kode');
	$objPHPExcel->getSheet(1)->getStyle('A1')->getFont()->setBold(true);

	$row = 2;
	while($val = mysql_fetch_array($data)) {	
	  $objPHPExcel->getSheet(1)->setCellValue('A'.$row, strtoupper($val['code']));
	  $row++;
	}
	
	/* output file */
	/*
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="gudang-eksternal-yukbisnis"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');	 
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	*/

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename=gudang-eksternal-yukbisnis.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	unset($objPHPExcel);

	exit;
?>
