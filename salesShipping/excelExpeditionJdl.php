<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include_once "../lib/PHPExcel/Classes/PHPExcel.php";

	$salesOrderId = $_REQUEST['salesOrderId'];
	$salesOrderIdStr = implode(',',$salesOrderId);

	$query = "select id,name,phone,address 
		from company
		where id='1'";

	$tmp = mysql_query($query);
	$data_company = mysql_fetch_array($tmp);

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
			no_resi,is_cod,
			(select sum(sod.amount) as qty from sales_order_detail as sod where sod.sales_order_id = sales_order.id) as total_qty,			
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml,		
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount)) as jml_belanja		

		from sales_order
		where is_delete = '0'
		  and id in ($salesOrderIdStr)		
		order by date_order, no_order, name";
	$data = mysql_query($query) or die(mysql_error());


	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getSheet(0)->setTitle('Expedisi JDL');		

	$objPHPExcel->getSheet(0)
        ->setCellValue('A1', 'No Order')
        ->setCellValue('B1', 'Nama Pengirim')
        ->setCellValue('C1', 'No HP Pengirim')
        ->setCellValue('D1', 'Provinsi Pengirim')
        ->setCellValue('E1', 'Kota/Kabupaten Pengirim')
        ->setCellValue('F1', 'Kecamatan Pengirim')
        ->setCellValue('G1', 'Alamat Pengirim')
        ->setCellValue('H1', 'Nama penerima')
        ->setCellValue('I1', 'NO HP Penerima')
        ->setCellValue('J1', 'Provinsi Penerima')
        ->setCellValue('K1', 'Kota/Kabupaten Penerima')
        ->setCellValue('L1', 'Kecamatan Penerima')
        ->setCellValue('M1', 'Alamat Penerima')
        ->setCellValue('N1', 'Kodepos')
        ->setCellValue('O1', 'Jumlah Paket')
        ->setCellValue('P1', 'Berat')
        ->setCellValue('Q1', 'COD')
        ->setCellValue('R1', 'Nilai COD/Barang')
        ->setCellValue('S1', 'Asuransi')
        ->setCellValue('T1', 'Remark');

	$objPHPExcel->getSheet(0)->getStyle('A1:T1')->getFont()->setBold(true);
	$objPHPExcel->getSheet(0)->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getSheet(0)->getColumnDimension('B')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('C')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('D')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('E')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('F')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('G')->setWidth(35);
	$objPHPExcel->getSheet(0)->getColumnDimension('H')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('I')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('J')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('K')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('L')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('M')->setWidth(55);
	$objPHPExcel->getSheet(0)->getColumnDimension('N')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('O')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('P')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('Q')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('R')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('S')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('T')->setWidth(35);
	//->setCellValue('F'.$row, preg_replace("#[^A-Za-z0-9\:,. ]+#", "", preg_replace('/\s+/',' ',$val['address_shipping'])))
	//ucfirst($val['name'])		
	$row = 2;
	while($val = mysql_fetch_array($data)) {
		$objPHPExcel->getSheet(0)
	        ->setCellValue('A'.$row, $val['no_order'])
	        ->setCellValue('B'.$row, 'Avandr')
	        ->setCellValue('C'.$row, '081283639090')
	        ->setCellValue('D'.$row, 'Jawa Barat')
	        ->setCellValue('E'.$row, 'Kota Bekasi')
	        ->setCellValue('F'.$row, 'Medan Satria')
	        ->setCellValue('G'.$row, 'Jl. Raya Pejuang Blok C No. 680 B' )
	        ->setCellValue('H'.$row, $val['name'])
	        ->setCellValue('I'.$row, $val['phone'])
	        ->setCellValue('J'.$row, $val['province'])
	        ->setCellValue('K'.$row, $val['city'])
	        ->setCellValue('L'.$row, $val['districts'])
	        ->setCellValue('M'.$row, $val['address_shipping'])
	        ->setCellValue('N'.$row, $val['postal_code'])
	        ->setCellValue('O'.$row, '1')
	        ->setCellValue('P'.$row, '1')
	        //->setCellValue('Q'.$row, ($val['is_cod'] == '1' ? 'Y' : 'N')) 
	        ->setCellValue('Q'.$row, 'Y') 
	        ->setCellValue('R'.$row, ' '.$val['jml'].' ') 
	        ->setCellValue('S'.$row, 'T') 
	        ->setCellValue('T'.$row, '');
		$row++;
	}

	$objPHPExcel->getSheet(0)->getStyle('A1:A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('N1:N'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('O1:O'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('P1:P'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('Q1:Q'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('R1:R'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('S1:S'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
	/* output file */
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="expedisi-jdl.xls"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>
