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
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml		
		from sales_order
		where is_delete = '0'
		  and id in ($salesOrderIdStr)		
		order by date_order, no_order, name";
	$data = mysql_query($query) or die(mysql_error());


	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getSheet(0)->setTitle('Expedisi SICEPAT');		

	$objPHPExcel->getSheet(0)
        ->setCellValue('A1', 'No')
        ->setCellValue('B1', 'Cabang')
        ->setCellValue('C1', 'Departemen')
        ->setCellValue('D1', 'Kota Pickup')
        ->setCellValue('E1', 'Tanggal Pickup')
        ->setCellValue('F1', 'Waktu Pickup')
        ->setCellValue('G1', 'Alamat Cabang')
        ->setCellValue('H1', 'Provinsi Cabang')
        ->setCellValue('I1', 'Kota Cabang')
        ->setCellValue('J1', 'Kecamatan Cabang')
        ->setCellValue('K1', 'Kode Pos Cabang')
        ->setCellValue('L1', 'Penerima')
        ->setCellValue('M1', 'No. Telepon')
        ->setCellValue('N1', 'Perusahaan')
        ->setCellValue('O1', 'No. DO Balik')
        ->setCellValue('P1', 'No. Ref')
        ->setCellValue('Q1', 'Tanggal Order')
        ->setCellValue('R1', 'Waktu Order')
        ->setCellValue('S1', 'Alamat Tujuan')
        ->setCellValue('T1', 'Provinsi Tujuan')
        ->setCellValue('U1', 'Kota Tujuan')
        ->setCellValue('V1', 'Kecamatan Tujuan')
        ->setCellValue('W1', 'Kode Pos Tujuan')
        ->setCellValue('X1', 'Layanan')
        ->setCellValue('Y1', 'Nama Barang')
        ->setCellValue('Z1', 'Qty')
        ->setCellValue('AA1', 'Berat Paket (KG)')
        ->setCellValue('AB1', 'Panjang Paket')
        ->setCellValue('AC1', 'Lebar Paket')
        ->setCellValue('AD1', 'Tinggi Paket')
        ->setCellValue('AE1', 'Harga Paket')
        ->setCellValue('AF1', 'Asuransi N/Y')
        ->setCellValue('AG1', 'COD')
        ->setCellValue('AH1', 'Pengiriman Emas')
        ->setCellValue('AI1', 'Catatan Pengiriman');


	$objPHPExcel->getSheet(0)->getStyle('A1:AI1')->getFont()->setBold(true);
	$objPHPExcel->getSheet(0)->getStyle('A1:AI1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getSheet(0)->getColumnDimension('A')->setWidth(5);
	$objPHPExcel->getSheet(0)->getColumnDimension('B')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('C')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('D')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('F')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('G')->setWidth(35);
	$objPHPExcel->getSheet(0)->getColumnDimension('H')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('I')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('J')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('K')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('L')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('M')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('N')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('O')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('P')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('Q')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('R')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('S')->setWidth(70);
	$objPHPExcel->getSheet(0)->getColumnDimension('T')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('U')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('V')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('W')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('X')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('Y')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('Z')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('V')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('V')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('V')->setWidth(25);
	$objPHPExcel->getSheet(0)->getColumnDimension('AA')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AB')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AC')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AD')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AE')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AF')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AG')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AH')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('AI')->setWidth(20);

	//->setCellValue('F'.$row, preg_replace("#[^A-Za-z0-9\:,. ]+#", "", preg_replace('/\s+/',' ',$val['address_shipping'])))
	//ucfirst($val['name'])		
	$row = 2;
	while($val = mysql_fetch_array($data)) {
		$objPHPExcel->getSheet(0)
	        ->setCellValue('A'.$row, ($row - 1))
	        ->setCellValue('B'.$row, 'Avandr')
	        ->setCellValue('C'.$row, 'Admin OPS')
	        ->setCellValue('D'.$row, 'Kota Bekasi')
	        ->setCellValue('E'.$row, date('d-m-Y'))
	        ->setCellValue('F'.$row, '17:00')
	        ->setCellValue('G'.$row, 'Jl. Raya Pejuang Blok C No. 680 B' )
	        ->setCellValue('H'.$row, 'Jawa Barat')
	        ->setCellValue('I'.$row, 'Bekasi')
	        ->setCellValue('J'.$row, 'Medan Satria')
	        ->setCellValue('K'.$row, '17131')
	        ->setCellValue('L'.$row, $val['name'])
	        ->setCellValue('M'.$row, ' '.$val['phone'].' ')
	        ->setCellValue('N'.$row, 'Avandr')
	        ->setCellValue('O'.$row, '')
	        ->setCellValue('P'.$row, '')
	        ->setCellValue('Q'.$row, $val['date_order_frm'])
	        ->setCellValue('R'.$row, '07:00')
	        ->setCellValue('S'.$row, $val['address_shipping'])
	        ->setCellValue('T'.$row, $val['province'])
	        ->setCellValue('U'.$row, $val['city'])
	        ->setCellValue('V'.$row, $val['districts'])
	        ->setCellValue('w'.$row, $val['postal_code'])
	        ->setCellValue('X'.$row,'REG')
	        ->setCellValue('Y'.$row, 'PAKAIAN / MAKANAN')
	        ->setCellValue('Z'.$row, $val['total_qty'])
	        ->setCellValue('AA'.$row, '1')
	        ->setCellValue('AB'.$row, '1')
	        ->setCellValue('AC'.$row, '1')
	        ->setCellValue('AD'.$row, '1')
	        ->setCellValue('AE'.$row, $val['jml'])
	        ->setCellValue('AF'.$row, 'N')
	        //->setCellValue('AG'.$row, $val['is_cod'] == 0 ? 'N' : 'Y')
	        ->setCellValue('AG'.$row, 'Y')
	        ->setCellValue('AH'.$row, 'N')
	        ->setCellValue('AI'.$row, '');
		$row++;
	}

	$objPHPExcel->getSheet(0)->getStyle('A1:A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('E1:E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('F1:F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('K1:K'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('P1:P'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('Q1:Q'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('R1:R'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('W1:W'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('X1:X'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('Y1:Y'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('Z1:Z'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('AA1:AA'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('AB1:AB'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('AC1:AC'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('AD1:AD1'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('AE1:AE1'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('AF1:AF1'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('AG1:AG1'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getStyle('Ah1:AH1'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	/* output file */
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="expedisi-sicepat-express.xls"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>
