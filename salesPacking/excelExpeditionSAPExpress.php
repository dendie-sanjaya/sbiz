<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include_once "../lib/PHPExcel/Classes/PHPExcel.php";

	$salesOrderId = $_REQUEST['salesOrderId'];
	$salesOrderIdStr = implode(',',$salesOrderId);

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			province, city, districts, districts_sub, postal_code,
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
			(select m.name from member as m where m.id = sales_id) as sales_name,						
			date_format(date_order,'%d-%m-%Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			no_resi,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml,
			(select sap.tlc from expedition_code_sap_express as sap 
 			   where trim(upper(sap.city_name)) = trim(upper(sales_order.city)) 
			   and trim(upper(sap.disctrict_name)) like trim(upper(concat('%',sales_order.districts,'%')))
			limit 0,1) as sap_tlc
		from sales_order
		where is_delete = '0'
		  and id in ($salesOrderIdStr)		
		order by date_order, no_order, name";
	$data = mysql_query($query) or die(mysql_error());

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getSheet(0)->setTitle('Expedisi SAP Express');		

	$objPHPExcel->getSheet(0)
        ->setCellValue('A1', 'NO AWB')
        ->setCellValue('B1', 'NO REFERENSI')
        ->setCellValue('C1', 'KODE PELANGGAN')
        ->setCellValue('D1', 'PENERIMA')
        ->setCellValue('E1', 'ALAMAT')
        ->setCellValue('F1', 'KECAMATAN')
        ->setCellValue('G1', 'KOTA/KABUPATEN')
        ->setCellValue('H1', 'TLC TUJUAN')
        ->setCellValue('I1', 'NO HP')
        ->setCellValue('J1', 'SERVICE REG/ODS')
        ->setCellValue('K1', 'DESKRIPSI BARANG')
        ->setCellValue('L1', 'NILAI COD');


	$objPHPExcel->getSheet(0)->getStyle('A1:L1')->getFont()->setBold(true);
	$objPHPExcel->getSheet(0)->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('C')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('K')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('L')->setWidth(20);
	
	$row = 2;
	while($val = mysql_fetch_array($data)) {
		$objPHPExcel->getSheet(0)
	        ->setCellValue('A'.$row, $val['no_resi'])
	        ->setCellValue('B'.$row, $val['no_order'])
	        ->setCellValue('C'.$row, '')
	        ->setCellValue('D'.$row, ucfirst($val['name']))
	        ->setCellValue('E'.$row, preg_replace("#[^A-Za-z0-9\:,. ]+#", "", preg_replace('/\s+/',' ',$val['address_shipping'])))
	        ->setCellValue('F'.$row, $val['districts'])
	        ->setCellValue('G'.$row, $val['city'])
	        ->setCellValue('H'.$row, $val['sap_tlc'])
	        ->setCellValue('I'.$row, ' '.$val['phone'].' ')
	        ->setCellValue('J'.$row, 'REGULAR')
	        ->setCellValue('K'.$row, '')
	        ->setCellValue('L'.$row, $val['jml']);
		$row++;
	}

	$objPHPExcel->getSheet(0)->getStyle('A1:A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('B1:B'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('H1:H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('J1:J'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	/* output file */
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="expedisi-sap-express.xls"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>
