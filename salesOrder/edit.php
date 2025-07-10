	<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
	<h1>EDIT PENJUALAN</h1>
	<hr />
	<p style="text-align:right">
		<input type="button" value="PRINT FAKTUR PENJUALAN" onclick="window.open('print.php?id=<?php echo $dataHeader['id'] ?>')" />
	</p>
	<form action="edit.php" method="post" id="frm">
		<input type="hidden" name="id" value="<?php echo $id ?>" />
		<fieldset>
			<legend><b>JENIS PEMBELIAN<b></legend>			
				<table width="100%">
					<tr>
						<td width="20%">NO SALES ORDER</td>
						<td width="25%"><b><?php echo $dataHeader['no_order'] ?></b></td>
						<td width="15%">PELANGGAN</td>
						<td>
							<input type="hidden" name="hiddenClientId" value="<?php echo $_REQUEST['clientId'] ?>" 	/>
							<select name="clientId" style="width:280px" onchange='this.form.submit()'>
								<?php while($valClient = mysql_fetch_array($cmbClient)): ?>
										<option value="<?php echo $valClient[0] ?>" <?php echo $valClient[0] == (isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : $dataHeader['client_id']) ? 'selected' : '' ?>><?php echo $valClient[1] ?> - <?php echo $valClient[2] ?></option>								
								<?php endwhile; ?>
							</select>				
						</td>
					<tr>
					<tr>
						<td width="20%">TRACKING ORDER</td>
						<td width="25%">
							<b>
								<image onclick="copyText()" src="../asset/image/icon-copy.png" style="width: 20px; border: 0px; margin: 0px; cursor: pointer;" border="0" title="Salin Link Tracking ke clipboard" >&nbsp;
								<a href="https://tracking.mahira.co.id/<?php echo base64_encode($dataHeader['no_order']) ?>" target="_blank">Klik Link Tracking  Ini >></a></b>
								<input style="display: none;" type="text" id="tracking" value="https://tracking.mahira.co.id/<?php echo base64_encode($dataHeader['no_order']) ?>">
							</a>											
						</td>
						<td width="20%">
							APAKAH DROPSHIPER ?
						</td>	
						<td>
						   <input type="checkbox" name="is_dropshipper" value="1" onclick="check_dropshipper()" id="is_dropshipper" <?php echo $is_dropshipper == '1' ? 'checked' : '' ?> /> Ya	
						</td>	
					<tr>					
				</table>
				<div style="margin-top: 40px; display: <?php echo $is_dropshipper == '1' ? 'block' : 'none' ?>" id="div_dropshipper">
					<h4>DATA DROPSHIPPER</h4>
					<hr />
					<table width="100%">
						<tr>
							<td width="20%">NAMA DROPSHIPPER</td>
							<td width="25%">
								<input name="dropshipper_name" type="text" value="<?php echo isset($_POST['dropshipper_name']) ? $_POST['dropshipper_name'] : $dataHeader['dropshipper_name'] ?>" />
								<div style="color:red"><?php echo isset($msgError['dropshipper_name']) ? $msgError['dropshipper_name'] : '' ?></div
							</td>
							<td width="20%">TELEPON DROPSHIPPER</td>
							<td>
								<input name="dropshipper_phone" id="dropshipper_phone" type="text" value="<?php echo isset($_POST['dropshipper_phone']) ? $_POST['dropshipper_phone'] : $dataHeader['dropshipper_phone'] ?>" onkeyup="validationPhone()" style="width:280px"  />
								<div style="color:red"><?php echo isset($msgError['dropshipper_phone']) ? $msgError['dropshipper_phone'] : '' ?></div>
							</td>
						<tr>
						<tr>
							<td valign="top">ALAMAT DROPSHIPPER</td>
							<td colspan="3">
								<textarea name="dropshipper_address" style="width:700px; height:50px"><?php echo isset($_POST['dropshipper_address']) ? $_POST['dropshipper_address'] : $dataHeader['dropshipper_address'] ?></textarea>
								<div style="color:red"><?php echo isset($msgError['dropshipper_address']) ? $msgError['dropshipper_address'] : '' ?></div>
							</td>
						<tr>						
					</table>
				</div>
		</fieldset>
		<br />	
		<fieldset id="detailDataBuyer">
			<legend><b>DATA PEMBELI<b></legend>			
				<table width="100%">
					<tr>
						<td width="20%" valign="top">NAMA</td>
						<td width="25%" valign="top">
							<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $dataHeader['name'] ?>" />
							<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
						</td>
						<td width="15%"  valign="top">TELEPON</b>
						<td valign="top">
							<input name="phone" id="phone" type="text" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $dataHeader['phone'] ?>" style="width:280px"  onkeyup="validationPhone()" />
							<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
						</td>												
					</tr>
					<tr>
						<td width="" valign="top">ALAMAT PENGIRIMAN</td>
						<td colspan="4">
							<textarea name="address" style="width:645px; height:50px"><?php echo isset($_POST['address']) ? $_POST['address'] : $dataHeader['address_shipping'] ?></textarea>
							<div style="color:red"><?php echo isset($msgError['address']) ? $msgError['address'] : '' ?></div>
						</td>
					</tr>
					<tr>
						<td width="" valign="top">JALUR PENGIRIMAN</td>
						<td colspan="4">
							<select name="isWarehouseExternal" style="width:87%" onchange="warehouseEsternal(this.value)">
								<option value="0" <?php echo (isset($_REQUEST['isWarehouseExternal']) ? $_REQUEST['isWarehouseExternal'] : $dataHeader['is_warehouse_external']) == '0' ? 'selected' : '' ?>>Via Ekspedisi</option>
								<option value="1" <?php echo (isset($_REQUEST['isWarehouseExternal']) ? $_REQUEST['isWarehouseExternal'] : $dataHeader['is_warehouse_external']) == '1' ?  'selected' : '' ?>>Via Gudang Eksternal</option>
							</select>	
						</td>
					</tr>
					<tr id="warehouseEksternalData4" style="display: none">
						<td>PILIHAN PENGEMASAN</td>
						<td valign="top">
							<select name="packingOption" style="width:89%" >
								<option value="0" <?php echo (isset($_REQUEST['packingOption']) ? $_REQUEST['packingOption'] : $dataHeader['packing_option']) == '0' ? 'selected' : '' ?>>Packing Normal</option>
								<option value="1" <?php echo (isset($_REQUEST['packingOption']) ? $_REQUEST['packingOption'] : $dataHeader['packing_option']) == '1' ? 'selected' : '' ?>>Buble Wrap</option>
								<option value="2" <?php echo (isset($_REQUEST['packingOption']) ? $_REQUEST['packingOption'] : $dataHeader['packing_option']) == '2' ? 'selected' : '' ?>>Packing Kayu</option>
								<option value="3" <?php echo (isset($_REQUEST['packingOption']) ? $_REQUEST['packingOption'] : $dataHeader['packing_option']) == '3' ? 'selected' : '' ?>>Packing Kardus</option>
							</select>	
						</td>
						<td>PILIHAN LAYANAN </td>
						<td valign="top">
							<select name="serviceOption" style="width:285px" >
								<option value="0" <?php echo (isset($_REQUEST['serviceOption']) ? $_REQUEST['serviceOption'] : $dataHeader['service_option']) == '0' ? 'selected' : '' ?>>Reg</option>
								<option value="1" <?php echo (isset($_REQUEST['serviceOption']) ? $_REQUEST['serviceOption'] : $dataHeader['service_option']) == '1' ? 'selected' : '' ?>>Yes</option>
							</select>	
						</td>
					</tr>
					<tr id="viaEkspedisiData3" style="display: none">
						<td>KODE POS</td>
						<td colspan="2" valign="top">
							<input type="hidden" value="0" name="postalCode">
							<input readonly style="width: 100%; height: 35px; background-color: #cccccc" name="ekpedisiPostalCode" type="text" value="<?php echo $dataHeader['postal_code'] ?>" />
							<div style="color:red"><?php echo isset($msgError['ekspedisiPostalCode']) ? $msgError['ekspedisiPostalCode'] : '' ?></div>
						</td>
						<td valign="top">
							<span class="button">
								<input type="button" link="postalCode.php?id=<?php echo $id ?>" data-title="CARI KODE POS" data-width="650" data-height="400" style="margin-left: 2px; margin-top:-1px; height: 37px" value="CARI KODE POS" />								
							</span>
						</td>	
					</tr>
					<tr id="viaEkspedisiData2" style="display: none">
						<td>PROVINSI</td>
						<td>
							<input readonly style="background-color: #cccccc" name="province" type="text" value="<?php echo $dataHeader['province'] ?>" />
							<div style="color:red"><?php echo isset($msgError['province']) ? $msgError['province'] : '' ?></div>
						</td>
						<td>KOTA</b>
						<td>
							<input readonly style="background-color: #cccccc" name="city" type="text" value="<?php echo $dataHeader['city'] ?>" style="width:280px"  />
							<div style="color:red"><?php echo isset($msgError['city']) ? $msgError['city'] : '' ?></div>
						</td>												
					</tr>
					<tr id="viaEkspedisiData1" style="display: none">
						<td>KECAMATAN</td>
						<td>
							<input name="districts" readonly style="background-color: #cccccc" type="text" value="<?php echo $dataHeader['districts'] ?>" />
							<div style="color:red"><?php echo isset($msgError['districts']) ? $msgError['districts'] : '' ?></div>
						</td>
						<td>KELURAHAN</td>
						<td>
							<input name="districts_sub" readonly style="background-color: #cccccc" type="text" value="<?php echo $dataHeader['districts_sub'] ?>" />
							<div style="color:red"><?php echo isset($msgError['districts_sub']) ? $msgError['districts'] : '' ?></div>
						</td>
					</tr>

					<tr id="warehouseEksternalData3" style="display: none">
						<td>KODE KECAMATAN</td>
						<td colspan="2" valign="top">
							<input type="hidden" value="0" name="districtsId">
							<input readonly style="width: 100%; height: 35px; background-color: #cccccc" name="districtsCode" type="text" value="<?php echo $dataHeader['districts_code'] ?>" />
							<div style="color:red"><?php echo isset($msgError['disctritCode']) ? $msgError['disctritCode'] : '' ?></div>
						</td>
						<td valign="top">
							<span class="button">
								<input type="button" link="districts.php?id=<?php echo $id ?>" data-title="CARI KODE KECAMATAN" data-width="650" data-height="400" style="margin-left: 2px; margin-top:-1px; height: 37px" value="CARI KECAMATAN" />								
							</span>
						</td>	
					</tr>
					<tr id="warehouseEksternalData1" style="display: none">
						<td>PROVINSI</td>
						<td>
							<input readonly style="background-color: #cccccc" name="province" type="text" value="<?php echo $dataHeader['province'] ?>" />
							<div style="color:red"><?php echo isset($msgError['province']) ? $msgError['province'] : '' ?></div>
						</td>
						<td>KOTA</b>
						<td>
							<input readonly style="background-color: #cccccc" name="city" type="text" value="<?php echo $dataHeader['city'] ?>" style="width:280px"  />
							<div style="color:red"><?php echo isset($msgError['phone']) ? $msgError['phone'] : '' ?></div>
						</td>												
					</tr>
					<tr id="warehouseEksternalData2" style="display: none">
						<td>KECAMATAN</td>
						<td>
							<input name="districts" readonly style="background-color: #cccccc" type="text" value="<?php echo $dataHeader['districts'] ?>" />
							<div style="color:red"><?php echo isset($msgError['districts']) ? $msgError['districts'] : '' ?></div>
						</td>
						<td>KODE POS</b>
						<td>
							<input name="postalCode" type="text" value="<?php echo isset($_POST['postalCode']) ? $_POST['postalCode'] : $dataHeader['postal_code'] ?>" style="width:280px"  />
							<div style="color:red"><?php echo isset($msgError['postalCode']) ? $msgError['postalCode'] : '' ?></div>
						</td>												
					</tr>
				</table>
		</fieldset>	
		<br />
		<fieldset >
			<legend><b>STATUS PENJUALAN<b></legend>			
			<table width="100%">
				<tr>
					<td width="20%">DARI MARKETPLACE</td>
					<td width="25%">
						<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
							<select name="statusMarketplace" style="width:180px" disabled>
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />TIDAK</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />YA</option>
							</select>	
							<input type="hidden" name="statusMarketplace" value="<?php echo $dataHeader['status_marketplace'] ?>">						
						<?php else: ?>
							<select name="statusMarketplace" style="width:180px"  onclick="setMarketPlace(this.value)" >
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />TIDAK</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace']) ? 'selected' : '' ?> />YA</option>
							</select>							
						<?php endif; ?>	
					</td>
					<td>NAMA MARKETPLACE</td>
					<td>
						<!--	
						<input type="text" id="marketplace"  name="marketplace" value="<?php echo isset($_POST['marketplace']) ? $_POST['marketplace'] : $dataHeader['marketplace'] ?>" style="width: 155px" />
						-->
						<?php 
						   if(isset($_REQUEST['marketplaceId'])) {
						   	  $arrTmp = explode('~',$_REQUEST['marketplaceId']); 
						   	  $marketplaceId = $arrTmp[0];			
						   } else {
						   	  $marketplaceId = 0;
						   }
						?>
						<select name="marketplaceId" id="marketplace" style="width:250px;" onchange="set_market_place_percent()">
							<?php while($valPlaformMarket = mysql_fetch_array($cmbPlatformMarket)): ?>
								<option value="<?php echo $valPlaformMarket['id'] ?>~<?php echo $valPlaformMarket['name'] ?>~<?php echo $valPlaformMarket['fee_admin_percent'] ?>" <?php echo $valPlaformMarket[0] == (isset($_REQUEST['marketplaceId']) ? $marketplaceId : $dataHeader['platform_market_id']) ? 'selected' : '' ?>><?php echo $valPlaformMarket['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>	
				</tr>	
				<tr>
					<td width="20%">STATUS PENJUALAN </td>
					<td width="25%">
						<?php if($_SESSION['loginPosition'] == '1'): ?>									
							<select id="statusOrder" name="statusOrder" style="width:180px" >
								<option value="4" <?php echo 4 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> >Belum Bayar</option>
								<option value="0" <?php echo 0 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
								<option value="1" <?php echo 1 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengemasan</option>
								<option value="2" <?php echo 2 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?> >Pengiriman</option>
								<option value="3" <?php echo 3 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Selesai</option>
							</select>				
						<?php else: ?>
							<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
								<select id="statusOrder" name="statusOrder" style="width:180px">
									<option value="4" <?php echo 4 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Belum Bayar</option>
									<option value="0" <?php echo 0 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
									<option value="1" <?php echo 1 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengemasan</option>
									<option value="2" <?php echo 2 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Pengiriman</option>
									<option value="3" <?php echo 3 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Selesai</option>
								</select>				
							<?php else: ?>
								<select id="statusOrder" name="statusOrder" style="width:180px" >
									<option value="4" <?php echo 4 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Belum Bayar</option>
									<option value="0" <?php echo 0 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pemesanan / Sudah Bayar</option>
									<option value="1" <?php echo 1 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?>>Pengemasan</option>
									<option value="2" <?php echo 2 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?><?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?> >Pengiriman</option>
									<option value="3" <?php echo 3 == (isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : $dataHeader['status_order']) ? 'selected' : '' ?> <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>Selesai</option>
								</select>				
							<?php endif; ?>								
						<?php endif; ?>							
					</td>
					<td  width="20%">TGL PEMESANAN</b>
					<td>
						<input id="dateOrder" name="dateOrder" type="text" id="dateOrder" size="5"   style="width:155px"  />						
						<div style="color:red; font-size: 10px"><?php echo isset($msgError['dateOrder']) ? $msgError['dateOrder'] : '' ?></div>						
					</td>						
				</tr>				
				<tr>
					<td width="" valign="top">TGL PEMBAYARAN</td>
					<td>
						<input id="datePayment" name="datePayment" type="text" id="datePayment" size="5" style="width:180px"/>						
					</td>
					<td  width="">TGL PENGEMASAN</b>
					<td>
						<input id="datePacking" name="datePacking" type="text" id="datePacking" size="5" style="width:155px"/>						
					</td>												
				</tr>					
				<tr>
					<td width="" valign="top">VALIDASI PEMBAYARAN</td>
					<td>
						<select id="statusPayment" name="statusPayment" style="width:180px" <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?>>
							<option value="0" <?php echo 0 == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $dataHeader['status_payment']) ? 'selected' : '' ?>>Belum Valid</option>
							<option value="1" <?php echo 1 == (isset($_REQUEST['statusPayment']) ? $_REQUEST['statusPayment'] : $dataHeader['status_payment']) ? 'selected' : '' ?>>Sudah Valid</option>
						</select>				
					</td>
					<td  width="">TGL PENGIRIMAN</b>
					<td>
						<input name="dateShipping" type="text" id="dateShipping" size="5" style="width:155px" readonly <?php echo $_SESSION['loginPosition'] != '1' ? 'disabled' : '' ?> />						
					</td>												
				</tr>
				<tr>
					<td  width="" valign="top">KET PEMBAYARAN</td>
					<td>						
						<select name="finSourceFundId" style="width:180px">
							<option value="0">&nbsp;</option>
							<?php while($valFoundSource = mysql_fetch_array($dataFoundSource)): ?> 
								<?php $finSourceFundCompare = isset($_REQUEST['finSourceFundId']) ? ($valFoundSource[0].'~'.$valFoundSource[1]) : $valFoundSource[0] ?>
								<option value="<?php echo $valFoundSource[0] ?>~<?php echo $valFoundSource[1] ?>" <?php echo  $finSourceFundCompare == (isset($_REQUEST['finSourceFundId']) ? $_REQUEST['finSourceFundId'] : $dataHeader['fin_source_fund_id']) ? 'selected' : '' ?>><?php echo $valFoundSource[1] ?></option>								
							<?php endwhile; ?>
						</select>				

						<textarea name="descriptionPayment" style="height:50px; width:180px; display: none"><?php echo isset($_POST['descriptionPayment']) ? $_POST['descriptionPayment'] : $dataHeader['description_payment'] ?></textarea>
						<!--
						<br /><small style="font-size:9px">Contoh : BCA: 9098779 A/N Dendie</small>
						-->
					</td>												
					<td  width="" valign="top">NO RESI PENGIRIMAN</td>
					<td valign="top">
						<input name="noResi" type="text" value="<?php echo isset($_POST['noResi']) ? $_POST['noResi'] : $dataHeader['no_resi'] ?>"  size="5" style="width:155px"/>						
					</td>												
				</tr>	
			</table>
		</fieldset>	
		<br />
		<fieldset id="detailStuff">
			<a name="databarang"></a> 
			<legend><b>DATA BARANG<b></legend>	
			<p>
				<?php if($_SESSION['loginPosition'] == '1'): ?>									
					<span class="button">
						<input type="button" link="addStuff.php?id=<?php echo $id ?>" data-title="TAMBAH BARANG" data-width="650" data-height="400"  style="width:220px" value="TAMBAH BARANG" />
					</span>
				<?php else: ?>
					<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
						<input type="button" value="TAMBAH BARANG" disabled />
					<?php else: ?>
						<span class="button">
							<input type="button" link="addStuff.php?id=<?php echo $id ?>" data-title="TAMBAH BARANG" data-width="650" data-height="400"  style="width:220px" value="TAMBAH BARANG" />
						</span>
					<?php endif; ?>								
				<?php endif; ?>	
			</p>
			
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="30%">NAMA BARANG</th>
							<th align="center" width="10%">QTY</th>							
							<th align="center" width="15%">HARGA JUAL</th>
							<th align="center" width="15%">JUMLAH</th>
							<th></th>
						</tr>	
					</thead>					
					<tbody>
						<?php $i=1; ?>
						<?php $total = 0 ?>
						<?php while($val = mysql_fetch_array($dataDetail)): ?>
							<tr>
								<td align="center"><?php echo $i ?></td>
								<td>
									<?php if($val['is_bundling'] == '1'): ?>
										<?php echo $val['name'] ?><br />
									    <?php 
									    	include '../lib/connection.php';
									    	$query = "select b.id, b.stuff_id, b.qty, s.name
												 from sales_order_detail_bundling as b
												 inner join stuff as s
												   on s.id = b.stuff_id
												 where sales_order_detail_id = '{$val['id']}'
												 order by id asc";
											$rstDetailBundling = mysql_query($query) or die (mysql_error());
											include '../lib/connection-close.php';
										?>
										<?php while($dataDetailBundling = mysql_fetch_array($rstDetailBundling)): ?>
											<small style="font-size: 10px"><?php echo $dataDetailBundling['name'] ?> (<?php echo $dataDetailBundling['qty'] ?>),</small>	
										<?php endwhile; ?>											
									<?php else: ?>	
										<?php echo $val['name'] ?><br />
										<small>(SKU : <?php echo $val['sku'] ?>)</small><br />
										<small>(JUDUL :<?php echo $val['nickname'] ?>)</small>
									<?php endif; ?>	
								</td>
								<td align="center">
									<?php if($_SESSION['loginPosition'] == '1'): ?>									
										<span class="button">
											<a href="editStuff.php?id=<?php echo $id ?>&salesDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>"  data-title="EDIT JUMLAH BARANG" data-width="350" data-height="200"><?php echo $val['amount'] ?></a>
										</span>
									<?php else: ?>
										<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
											<?php echo $val['amount'] ?>
										<?php else: ?>
											<span class="button">
												<a href="editStuff.php?id=<?php echo $id ?>&salesDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>"  data-title="EDIT JUMLAH BARANG" data-width="350" data-height="200"><?php echo $val['amount'] ?></a>
											</span>
										<?php endif; ?>								
									<?php endif; ?>	
								</td>
								<td align="center"><?php echo number_format($val['price'],0,'','.') ?></td>	
								<td align="center"><?php echo number_format($val['price'] * $val['amount'] ,0,'','.') ?></td>								
								<td align="center">	
									<?php if($_SESSION['loginPosition'] == '1'): ?>									
										<span class="button">
											<input type="button" link="deleteStuff.php?id=<?php echo $id ?>&salesOrderDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>" data-title="KONFIRMASI HAPUS" data-width="320" data-height="100"  style="width:150px" value="HAPUS BARANG" />
										</span>
									<?php else: ?>
										<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
											<input type="button" data-title="KONFIRMASI HAPUS" data-width="320" data-height="100"  style="width:150px" value="HAPUS BARANG" disabled />
										<?php else: ?>
											<span class="button">
												<input type="button" link="deleteStuff.php?id=<?php echo $id ?>&salesOrderDetilId=<?php echo $val['id'] ?>&qty=<?php echo $val['amount'] ?>" data-title="KONFIRMASI HAPUS" data-width="320" data-height="100"  style="width:150px" value="HAPUS BARANG" />
											</span>
										<?php endif; ?>								
									<?php endif; ?>	
								</td>
							</tr>	
							<?php $total = $total + ($val['price'] * $val['amount']) ?>
						<?php $i++; ?>
						<?php endwhile; ?>
					</tbody>
					<tfoot>	
						<tr>
							<td align="left" colspan="4"><b>TOTAL</b></td>
							<td align="center"><b><?php echo number_format($total,0,'','.') ?></b></td>
							<td>&nbsp;</td>
						</tr>						
						<tr>
							<td align="left" colspan="2"><b>DISKON</b></td>
							<td colspan="2" align="right"><input onkeyup="calcDiscount(<?php echo $total ?>)" style="text-align:center; font-size:15px; height:30px; width:100px" type="text" name="discount" id="discount" value="<?php echo isset($_POST['discount']) ? $_POST['discount'] : $dataHeader['discount_persen'] ?>" size="3" /> %</td>
							<td align="center" width="20%"><span id="labelDiskon">0</span></td>
							<td></td>
						</tr>	
						<tr>
							<td align="left" colspan="2"><b>DISKON NOMINAL</b></td>
							<td colspan="2" align="right"><input onkeyup="calcDiscount(<?php echo $total ?>)" style="text-align:center; font-size:15px; height:30px; width:100px" type="text" name="discountAmount" id="discountAmount" value="<?php echo isset($_POST['discountAmount']) ? $_POST['discountAmount'] : $dataHeader['discount_amount'] ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td align="center" width="20%"></td>
							<td></td>
						</tr>	
						<tr>
							<td colspan="6">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="4"><b>TOTAL SETELAH DISKON</b></td>
							<td align="center"><b><span id="labelTotal"><?php echo number_format($total,0,'','.') ?></b></span></td>
							<td>&nbsp;</td>
						</tr>						
						<tr>
							<td align="left" colspan="4"><b>BIAYA KIRIM SEBELUM DISKON</b> 
							</td>
							<td align="center"><input onkeyup="set_shipping_before_discount(<?php echo $total ?>)" name="costShipping_before_discount" id="costShipping_before_discount" style="text-align:center; font-size:15px;  fontheight:30px; width:100px" type="text" value="<?php echo isset($_POST['costShipping']) ? $_POST['costShipping_before_discount'] : $dataHeader['shipping_cost_before_discount'] ?>" size="5" /></td>
							<td align="center">
								&nbsp;	
							</td>
						</tr>												

						<tr>
							<td align="left" colspan="4"><b>DISKON BIAYA KIRIM</b> 
							</td>
							<td align="center"><input onkeyup="set_shipping_before_discount(<?php echo $total ?>)" name="costShipping_discount" id="costShipping_discount" style="text-align:center; font-size:15px;  fontheight:30px; width:100px" type="text" value="<?php echo isset($_POST['costShipping_discount']) ? $_POST['costShipping_discount'] : $dataHeader['shipping_cost_discount'] ?>" size="5" /></td>
							<td align="center">
								&nbsp;	
							</td>
						</tr>												


						<tr>
							<td align="left" colspan="4"><b>BIAYA KIRIM</b> 
							</td>
							<td align="center"><input onkeyup="updateTotal(<?php echo $total ?>)" name="costShipping" id="costShipping" style="text-align:center; font-size:15px;  font-height:30px; width:100px; background-color: #F4F4F6" type="text" value="<?php echo isset($_POST['costShipping']) ? $_POST['costShipping'] : $dataHeader['shipping_cost'] ?>" size="5" readonly  /></td>
							<td align="center">
								<select id="expeditionId" name="expeditionId" style="width:150px">
									<?php while($valExpedition = mysql_fetch_array($cmbExpedition)): ?>
										<option value="<?php echo $valExpedition[0] ?>" <?php echo $valExpedition[0] == (isset($_REQUEST['expeditionId']) ? $_REQUEST['expeditionId'] : $dataHeader['expedition_id']) ? 'selected' : '' ?>><?php echo $valExpedition[1] ?></option>								
									<?php endwhile; ?>
								</select>				

								<select id="warehouseExternalId" name="warehouseExternalId" style="width:150px; display: none;">
									<?php while($valExpedition = mysql_fetch_array($cmbWarehouseExternal)): ?>
										<option value="<?php echo $valExpedition[0] ?>" <?php echo $valExpedition[0] == (isset($_REQUEST['warehouseExternalId']) ? $_REQUEST['warehouseExternalId'] : $dataHeader['warehouse_external_id']) ? 'selected' : '' ?>><?php echo $valExpedition[1] ?></option>								
									<?php endwhile; ?>
								</select>				

							</td>
						</tr>												
						<tr>
							<th style="text-align:left" width="5%"colspan="4">GRAND TOTAL</th>
							<th style="font-size:15px;"><b><span id="labelGrandTotal"></span></b></th>
							<th>&nbsp;</th>
						</tr>	
						<tr style="" id="platformMarketFeePercent_row">
							<td align="left" colspan="6"><b>BIAYA ADMIN PLATFORM MARKET PLACE</b>
							   <b>[ <span id="platformMarketFeePercent"><?php echo $dataHeader['platform_market_fee_percent'] ?></span> %]</b>
							    <span style="font-size:10px">Berdampak Pada Harga Dasar Barang Yang Bertambah</span> 
							</td>
						</tr>												

					</tfoot>
				</table>
			</div>
		</fieldset>	
		<hr />		
		<?php if($_SESSION['loginPosition'] == '1'): ?>									
			<input type="button" value="SIMPAN" onclick="frmSave()"/>
		<?php else: ?>
			<?php if(in_array($dataHeader['status_order'],array(2,3))): ?>
				<input type="button" value="SIMPAN" disabled />
			<?php else: ?>
				<input type="button" value="SIMPAN" onclick="frmSave()"/>
			<?php endif; ?>								
		<?php endif; ?>	

		<?php if(isset($_REQUEST['redirect'])): ?>
			<?php if($_REQUEST['redirect'] == '1'): ?>
				<input type="button" value="BATAL" onclick="window.location='../salesUnpaid/index.php'" />
			<?php endif; ?>	
		<?php else: ?>	
			<input type="button" value="BATAL" onclick="window.location='index.php?type=0'" />
		<?php endif; ?>	
	</form>
	<script type="text/javascript">

	calcDiscount('<?php echo $total ?>');
	updateTotal('<?php echo $total ?>');
	
	$(document).ready(function() {
		$(function() {
				$( "#dateOrder" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = isset($_REQUEST['dateOrder']) ? strlen(trim($_REQUEST['dateOrder'])) == 0 ?  '' : explode('/',$_REQUEST['dateOrder']) : explode('/',$dataHeader['date_order_frm']) ?>
				<?php if($tmp[0] != '00'): ?>	
					$("#dateOrder" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>
			});
	});
	
	$(document).ready(function() {
		$(function() {
				$( "#datePacking" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				
				<?php $tmp = isset($_REQUEST['datePacking']) ? strlen(trim($_REQUEST['datePacking'])) == 0 ?  '' : explode('/',$_REQUEST['datePacking']) : explode('/',$dataHeader['date_packing_frm']) ?>
				<?php if($tmp[0] != '00'): ?>	
					$("#datePacking" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>
			});
	});

	$(document).ready(function() {
		$(function() {
				$( "#dateShipping" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				
				<?php $tmp = isset($_REQUEST['dateShipping']) ? strlen(trim($_REQUEST['dateShipping'])) == 0 ?  '' : explode('/',$_REQUEST['dateShipping']) : explode('/',$dataHeader['date_shipping_frm']) ?>
				<?php if($tmp[0] != '00'): ?>				
					$("#dateShipping" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>
			});
	});

	$(document).ready(function() {
		$(function() {
				$( "#datePayment" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-2y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = isset($_REQUEST['datePayment']) ? strlen(trim($_REQUEST['datePayment'])) == 0 ?  '' : explode('/',$_REQUEST['datePayment']) : explode('/',$dataHeader['date_payment_frm']) ?>	
				<?php if($tmp[0] != '00'): ?>
					$("#datePayment" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
				<?php endif; ?>	
			});
	});
		var iframe = '';
		var dialog = '';
		$(function () {
			var iframe = $('<iframe id="externalSite" class="externalSite" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
			var dialog = $("<div></div>").append(iframe).appendTo("body").dialog({
				autoOpen: false,
				modal: true,
				resizable: false,
				width: "auto",
				height: "auto",
				close: function () {
					iframe.attr("src", "");
				}
			});
			$(".button a").on("click", function (e) {
				e.preventDefault();
				var src = $(this).attr("href");
				var title = $(this).attr("data-title");
				var width = $(this).attr("data-width");
				var height = $(this).attr("data-height");
				iframe.attr({
					width: +width,
					height: +height,
					src: src
				});	
				dialog.dialog("option", "title", title).dialog("open");
			});
			
			$(".button input").on("click", function (e) {
				e.preventDefault();
				var src = $(this).attr("link");
				var title = $(this).attr("data-title");
				var width = $(this).attr("data-width");
				var height = $(this).attr("data-height");
				iframe.attr({
					width: +width,
					height: +height,
					src: src
				});	
				dialog.dialog("option", "title", title).dialog("open");
			});
			
		});
		
		function warehouseEsternal(p) {
			if(p == 1) {
			  $('#warehouseEksternalData1').show();
			  $('#warehouseEksternalData2').show();
			  $('#warehouseEksternalData3').show();
			  $('#warehouseEksternalData4').show();
			  $('#warehouseExternalId').show();		  
			  $('#expeditionId').hide();		  
			  $('#viaEkspedisiData1').hide();
			  $('#viaEkspedisiData2').hide();
			  $('#viaEkspedisiData3').hide();
			} else {
			  $('#warehouseEksternalData1').hide();
			  $('#warehouseEksternalData2').hide();
			  $('#warehouseEksternalData3').hide();			
			  $('#warehouseEksternalData4').hide();			
			  $('#warehouseExternalId').hide();		  
			  $('#expeditionId').show();		  
			  $('#viaEkspedisiData1').show();
			  $('#viaEkspedisiData2').show();
			  $('#viaEkspedisiData3').show();
			}	
		}	

		warehouseEsternal(<?php echo isset($_REQUEST['isWarehouseExternal']) ? $_REQUEST['isWarehouseExternal'] : $dataHeader['is_warehouse_external'] ?> );	

		function showPeriodePemesanan(p) {
			if(p == 0) { 
				document.getElementById('periodePemesananLabel').style.display='none';		
				document.getElementById('periodePemesananCmb').style.display='none';		
			} else {
				document.getElementById('periodePemesananLabel').style.display='';		
				document.getElementById('periodePemesananCmb').style.display='';		
			}
		}
		
		//showPeriodePemesanan(<?php echo $_REQUEST['tipeOrder'] ?>);

		<?php if(isset($_REQUEST['jumpTo'])): ?>
			document.getElementById("detailStuff").scrollIntoView(true);			
		<?php endif; ?>	

		function calcDiscount(p) { 
			var vDiscount = document.getElementById('discount').value;
			var r = 0;
			r = (p / 100) * vDiscount;				
			document.getElementById('labelDiskon').innerHTML = r; 
			$('#labelDiskon').simpleMoneyFormat();	
	
			updateTotal(p);	
		}
		
		function updateTotal(p) {
			var lDiskon = document.getElementById('labelDiskon').innerHTML;

			lDiskon  = lDiskon.replace(".","");
			lDiskon  = lDiskon.replace(".","");
			lDiskon  = lDiskon.replace(".","");
			
			var total  =  p - lDiskon; 
			var lDiskonAmount = document.getElementById('discountAmount').value;
			total = (total - lDiskonAmount);
			
			document.getElementById('labelTotal').innerHTML = total;
			$('#labelTotal').simpleMoneyFormat();

			updateGrandTotal(total);	
		}
		
		function updateGrandTotal(p) {
			var costShipping =   document.getElementById('costShipping').value;
			costShipping  =  parseInt(costShipping.replace(".","")); 
			var total  =  (p + costShipping); 
			
			document.getElementById('labelGrandTotal').innerHTML = total;			
			$('#labelGrandTotal').simpleMoneyFormat();			
		}
		
		
		function frmSave() {
			parent.document.getElementById('frm').action = 'editSave.php';
			parent.document.getElementById('frm').submit();
		}
		
		/*
		function closeModal(frameElement) {
			//alert('dari parent');
			//dialog("close");
			dialog.modal("hide");
			//alert(dialog.dialog.dialog("open"));
			//dialog.dialog("close")
			//$('#externalSite').modal().hide();
			/*
			if (frameElement) {
				var dialog = $(frameElement).closest(".modal");
				alert (dialog)
				if (dialog.length > 0) {
					alert('ok');
					dialog.modal("hide");
				}
			}
			
		} */

		function closeModal(frameElement) { alert('hai');
			 if (frameElement) {
				var dialog = $('externalSite').closest(".modal");
				if (dialog.length > 0) {
					dialog.modal("hide");
				}
			 }
		}		

		function setMarketPlace(p) {
			if(p == 1) {				
			  var d = new Date();
			  var now = d.getDate() + '/' +d.getMonth() + '/' + d.getFullYear();

			  $('#marketplace').prop("disabled",false);		
			  $("#marketplace option[value='0']").remove();	  
			  $('#statusOrder').val(2);
			  $('#statusPayment').val(1);			  
			  $("#datePayment" ).datepicker("setDate", new Date(d.getFullYear,d.getMonth(),d.getDate()));
			  $("#datePacking" ).datepicker("setDate", new Date(d.getFullYear,d.getMonth(),d.getDate()));
			  $("#platformMarketFeePercent_row").show();
			  set_market_place_percent();
			} else {
			  $('#marketplace').append('<option value="0"></option>');	
			  $('#marketplace').prop("disabled",true);
			  $('#marketplace').val('0');
			  $('#statusOrder').val(4);
			  $('#statusPayment').val(0);			  
			  $("#datePayment" ).val('');
			  $("#datePacking" ).val('');
			  $("#platformMarketFeePercent_row").hide();
			  set_market_place_percent();
			}
		}	

		function checkMarketPlace(p) {
			if(p == 1) {				
			  $('#marketplace').prop("disabled",false);		
			  $("#marketplace option[value='0']").remove();	  
			} else {
			  $('#marketplace').append('<option value="0"></option>');	
			  $('#marketplace').prop("disabled",true);
			  $('#marketplace').val('0');
			}			
		}

		$(document).ready(function() {
			checkMarketPlace(<?php echo isset($_REQUEST['statusMarketplace']) ? $_REQUEST['statusMarketplace'] : $dataHeader['status_marketplace'] ?>)
		});

		function validationPhone() {
		  /*	
		  var validasiAngka = /^[0-9]+$/;
		  var phone = document.getElementById("phone");
		  if (!phone.value.match(validasiAngka)) {
		      document.getElementById("phone").value = '';
		  } else {
		  	var res = phone.value.substring(0, 2);
		  	var newnumber;
		  	if(res != 62) {
 			   newnumber = '62' + phone.value.substring(3, 15); 			   
 			   document.getElementById("phone").value = newnumber; 
		  	}
		  }
		  */
		}	

		function copyText() {
		  /* Get the text field */
		  var copyText = document.getElementById("tracking");

		  /* Select the text field */
		  copyText.select();
		  copyText.setSelectionRange(0, 99999); /* For mobile devices */

		   /* Copy the text inside the text field */
		  navigator.clipboard.writeText(copyText.value);

		  /* Alert the copied text */
		  alert("Salin Link Tracking Berhasil ke clipboard");
		} 

		function check_dropshipper() {
			if ($('#is_dropshipper').attr('checked')) {
			  $("#div_dropshipper").show();
			} else {
			  $("#div_dropshipper").hide();
			}			
		}

		function set_shipping_before_discount(p) {
		   var costShipping_before_discount	= document.getElementById("costShipping_before_discount").value; 
		   var costShipping_discount = document.getElementById("costShipping_discount").value; 
		   var costShipping =  (costShipping_before_discount - costShipping_discount)
		   document.getElementById("costShipping").value = costShipping;	
		   updateTotal(p);
		}

		function set_market_place_percent() {
			var marketplace = $('#marketplace').val();
			var marketplace_percent = marketplace.split('~');
			$('#platformMarketFeePercent').html(marketplace_percent[2]);

			if(marketplace.length > 1) {
			  $("#platformMarketFeePercent_row").show();				
			} else {
			  $("#platformMarketFeePercent_row").hide();				
			}
		}

		<?php if(!empty($_REQUEST['marketplaceId'])): ?>	
			set_market_place_percent();
		<?php else: ?>
			<?php if($dataHeader['status_marketplace'] == 1): ?>
				$("#platformMarketFeePercent_row").show();				
			<?php else : ?>
				$("#platformMarketFeePercent_row").hide();				
			<?php endif; ?>		
		<?php endif; ?>		
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
