<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include_once "../lib/PHPExcel/Classes/PHPExcel.php";

	$salesOrderId = $_REQUEST['salesOrderId'];
	$salesOrderIdStr = implode(',',$salesOrderId);

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
			(select m.name from member as m where m.id = sales_id) as sales_name,						
			date_format(date_order,'%d-%m-%Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			no_resi,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml
		from sales_order
		where is_delete = '0'
		  and id in ($salesOrderIdStr)		
		order by date_order, no_order, name";
	$data = mysql_query($query) or die(mysql_error());

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getSheet(0)->setTitle('Expedisi Ninja');		

	$objPHPExcel->getSheet(0)
        ->setCellValue('A1', 'REQUESTED TRACKING NUMBER')
        ->setCellValue('B1', 'NAME')
        ->setCellValue('C1', 'ADDRESS')
        ->setCellValue('D1', 'CONTACT')
        ->setCellValue('E1', 'CASH ON DELIVERY')
        ->setCellValue('F1', 'TOTAL SALE');

	$objPHPExcel->getSheet(0)->getStyle('A1:F1')->getFont()->setBold(true);
	$objPHPExcel->getSheet(0)->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('C')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('F')->setWidth(20);
	
	$row = 2;
	while($val = mysql_fetch_array($data)) {
		$objPHPExcel->getSheet(0)
	        ->setCellValue('A'.$row, $val['no_order'])
	        ->setCellValue('B'.$row, ucfirst($val['name']))
	        ->setCellValue('C'.$row, preg_replace("#[^A-Za-z0-9\:,. ]+#", "", preg_replace('/\s+/',' ',$val['address_shipping'])))
	        ->setCellValue('D'.$row, ' '.$val['phone'].' ')
	        ->setCellValue('E'.$row, $val['shipping_cost'])
	        ->setCellValue('F'.$row, $val['jml']);
		$row++;
	}

	$objPHPExcel->getSheet(0)->getStyle('A1:A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('D1:D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('E1:E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('F1:F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	/* output file */
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="expedisi-ninja.xls"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>
