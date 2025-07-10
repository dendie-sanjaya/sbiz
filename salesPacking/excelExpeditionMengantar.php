<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include_once "../lib/PHPExcel/Classes/PHPExcel.php";

	$salesOrderId = $_REQUEST['salesOrderId'];
	$salesOrderIdStr = implode(',',$salesOrderId);

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name, postal_code, districts_sub,
			(select m.name from member as m where m.id = sales_id) as sales_name,						
			date_format(date_order,'%d-%m-%Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			no_resi, is_cod,
			( ((amount_sale - ((amount_sale / 100) * discount_persen)) - discount_amount) + shipping_cost) as jml,
			(select sum(sod.amount) as qty from sales_order_detail as sod where sod.sales_order_id = sales_order.id) as total_qty,
			(select sod.name as name from sales_order_detail as sod where sod.sales_order_id = sales_order.id limit 0,1) as name_product
		from sales_order
		where is_delete = '0'
		  and id in ($salesOrderIdStr)		
		order by date_order, no_order, name";
	$data = mysql_query($query) or die(mysql_error());

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getSheet(0)->setTitle('Expedisi Mengantar');		

	$objPHPExcel->getSheet(0)
        ->setCellValue('A1', 'Nama Penerima')
        ->setCellValue('B1', 'Alamat Penerima')
        ->setCellValue('C1', 'Nomor Telepon')
        ->setCellValue('D1', 'Kode Pos')
        ->setCellValue('E1', 'Berat')
        ->setCellValue('F1', 'Harga Barang (Jika NON-COD)')
        ->setCellValue('G1', 'Nilai COD (Jika COD)')
        ->setCellValue('H1', 'Isi Paketan (Nama Produk)')
        ->setCellValue('I1', '*Kelurahan')
        ->setCellValue('J1', '*Quantity')
        ->setCellValue('K1', '*Instruksi Pengiriman');

	//$objPHPExcel->getSheet(0)->getStyle('A1:K1')->getFont()->setBold(true);
	//$objPHPExcel->getSheet(0)->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getSheet(0)->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('C')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('H')->setWidth(30);
	$objPHPExcel->getSheet(0)->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getSheet(0)->getColumnDimension('K')->setWidth(20);
	
	$row = 2;
	while($val = mysql_fetch_array($data)) {
		$objPHPExcel->getSheet(0)
	        ->setCellValue('A'.$row, ucfirst($val['name']))
	        ->setCellValue('B'.$row, preg_replace("#[^A-Za-z0-9\:,. ]+#", "", preg_replace('/\s+/',' ',$val['address_shipping'])))
	        ->setCellValue('C'.$row, ' '.$val['phone'].' ')
	        ->setCellValue('D'.$row, $val['postal_code'])
	        //->setCellValue('E'.$row, ($val['total_qty'] * 1))
	        ->setCellValue('E'.$row, 1)
	        ->setCellValue('F'.$row, ($val['is_cod'] == '0' ? $val['jml'] : '0')) 
	        ->setCellValue('G'.$row, ($val['is_cod'] == '1' ? $val['jml'] : '0')) 
	        ->setCellValue('H'.$row, $val['name_product']) 
	        ->setCellValue('I'.$row, $val['districts_sub']) 
	        ->setCellValue('J'.$row, $val['total_qty']) 
	        ->setCellValue('K'.$row,'') 
	        ;
		$row++;
	}

	$objPHPExcel->getSheet(0)->getStyle('C1:D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getSheet(0)->getStyle('D1:d'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getSheet(0)->getStyle('E1:E'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getSheet(0)->getStyle('F1:F'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getSheet(0)->getStyle('G1:G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	/* output file */
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="expedisi-mengantar.xls"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>
