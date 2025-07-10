<hr />
<table width="100%">
	<tr>
		<td width="<?php echo substr($_SESSION['loginPrivilage'],5,1) == '1' ? '90%' : '90%' ?>" valign="top">
			<div id="smoothmenu" class="ddsmoothmenu">						    		
				<ul>					
					<?php if(in_array($_SESSION['loginPosition'], array('1','2','3','4','5'))): ?>
						<li><a href="../home/index.php">Home</a></li>								
					<?php endif; ?>
					<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
						<li>
							<a href="#">Referensi</a>
							<ul>
								<li><a href="../company/edit.php">Identitas Toko</a></li>										
								<li><a href="../suplier/index.php">Pemasok</a></li>										
								<li><a href="../client/index.php">Kategori Pelanggan</a></li>
								<li><a href="../expedition/index.php">Ekspedisi</a></li>
								<li><a href="../platformMarket/index.php">Platform Market</a></li>													
								<li><a href="../promotionCalendar/index.php">Kalender Promosi</a></li>													
								<li><a href="../warehouseExternal/index.php">Gudang Eksternal</a></li>								
								<li><a href="../location/index.php?type=2">Lokasi Penyimpanan</a></li>
								<li><a href="../measure/index.php">Satuan Ukuran</a></li>																															
							</ul>							
						</li>
					<?php endif; ?>
					<?php if(in_array($_SESSION['loginPosition'], array('1','5'))): ?>
					<li>
						<a href="#">Reseller </a>
						<ul>
							<li><a href="../reseller/index.php">Reseller</a></li>								
							<li><a href="../reportRevenueCommision/index.php">Komisi Reseller</a></li>	
							<li><a href="../resellerWithdrawFee/index.php">Pembayaran Komisi Reseller</a></li>	
							<li><a href="../resellerReceiptCod/index.php">Penerimaan Pembayaran COD</a></li>	
							<li><a href="../resellerPayCod/index.php">Pembayaran COD ke Reseller</a></li>	
							<li><a href="../resellerInformation/edit.php">Informasi Umum</a></li>	
						</ul>	
					</li>	
					<?php endif; ?>					
					<?php if(in_array($_SESSION['loginPosition'], array('1','3','5'))): ?>
						<li><a href="../customer/index.php">Pelanggan</a></li>								
					<?php endif; ?>					
					<?php if(in_array($_SESSION['loginPosition'], array('1'))): ?>
					<li>
						<a href="#">Barang</a>
						<ul>
							<li><a href="../category/index.php">Kategori Barang</a></li>								
							<li><a href="../stuff/index.php">Barang</a></li>	
							<li><a href="../stuffBundling/index.php">Barang Bundling</a></li>	
						</ul>
					</li>										
					<?php endif; ?>
					<?php if(in_array($_SESSION['loginPosition'], array('1','2','3','4','5'))): ?>
					<li>
						<a href="#">Persedian Barang</a>
						<ul >
							<?php if(in_array($_SESSION['loginPosition'], array('1','2'))): ?>
								<li><a href="../transaction/index.php">Keluar & Masuk Barang</a></li>								
							<?php endif; ?>
							<?php if(in_array($_SESSION['loginPosition'], array('1','2','4'))): ?>								
								<li><a href="../corectionStock/index.php">Koreksi Stok</a></li>	
							<?php endif; ?>
							<?php if(in_array($_SESSION['loginPosition'], array('1','2','3','4','5'))): ?>																
								<li><a href="../stuffStockCard/index.php">Kartu Stok</a></li>	
							<?php endif; ?>
							<?php if(in_array($_SESSION['loginPosition'], array('1','2'))): ?>															
								<li><a href="../transactionRemove/index.php">Hapus Log Mutasi Barang</a></li>	
							<?php endif; ?>								
						</ul>
					</li>
					<?php endif; ?>
					<?php if(in_array($_SESSION['loginPosition'], array('1','2','3','4','5'))): ?>
					<li>
						<a href="#">Penjualan</a>
						<ul >
							<?php if(in_array($_SESSION['loginPosition'], array('1','3','4','5'))): ?>
								<li ><a href="../salesOrderFollowup/index.php">Penjualan Follow Up</a></li>	
							<?php endif; ?>								
							<?php if(in_array($_SESSION['loginPosition'], array('1','3','4','5'))): ?>
								<li ><a href="../salesOrderReseller/index.php">Penjualan Reseller</a></li>	
							<?php endif; ?>	
							<?php if(in_array($_SESSION['loginPosition'], array('1','3','4','5'))): ?>
								<li ><a href="../salesOrder/index.php">Penjualan</a></li>	
							<?php endif; ?>	
							<li style="height:2px; background-color: gray;text-shadow: 0px 1px 0px #999;"></li>				
							<?php if(in_array($_SESSION['loginPosition'], array('1','3','4','5'))): ?>
								<li><a href="../salesUnpaid/index.php">Penjualan Belum Bayar</a></li>
							<?php endif ?>										
							<?php if(in_array($_SESSION['loginPosition'], array('1','4','5'))): ?>
								<li><a href="../salesCod/index.php">Validasi Pembayaran COD</a></li>
							<?php endif ?>										
							<?php if(in_array($_SESSION['loginPosition'], array('1','4','5'))): ?>
								<li><a href="../salesPayment/index.php">Validasi Pembayaran Transfer</a></li>
							<?php endif ?>
							<?php if(in_array($_SESSION['loginPosition'], array('1','2','4','5'))): ?>
								<li><a href="../salesPacking/index.php">Pengemasan</a></li>
							<?php endif; ?>								
							<?php if(in_array($_SESSION['loginPosition'], array('1','2','4','5'))): ?>							
								<li><a href="../salesShipping/index.php">Pengiriman Via Ekpedisi</a></li>		
							<?php endif; ?>						
							<?php if(in_array($_SESSION['loginPosition'], array('1','2','4','5'))): ?>							
								<li><a href="../salesShippingWarehouseExternal/index.php">Pengiriman Via Gdg Eksternal</a></li>		
							<?php endif; ?>						

							<?php if(in_array($_SESSION['loginPosition'], array('1','3','4','5'))): ?>
								<li style="height:2px; background-color: gray;text-shadow: 0px 1px 0px #999;"></li>				
								<?php if(in_array($_SESSION['loginPosition'], array('1','5'))): ?>							
								<li><a href="../salesAfterSale/index.php">Purna Jual</a></li>		
								<?php endif; ?>	

								<?php if(in_array($_SESSION['loginPosition'], array('1','3','4','5'))): ?>
									<li ><a href="../salesReturn/index.php">Retur Penjualan </a></li>	
									<li ><a href="../salesTrash/index.php">Penjualan Batal</a></li>	
								<?php endif; ?>	
							<?php endif; ?>						

						</ul>
					</li>
					<?php endif; ?>
					<!--
					<?php if(substr($_SESSION['loginPrivilage'],4,1) == '1'): ?>
					<li>
						<a href="#">Keuangan</a>
						<ul>
							<li><a href="../reportFinProfit/index.php">Laporan Laba & Rugi</a></li>									
							<li><a href="../reportFinEquitas/index.php">Laporan Perubahan	 Modal</a></li>	
							<li style="height:3px; background-color: gray;text-shadow: 0px 1px 0px #999;">&nsbp;</li>														
							<li><a href="../finConstExpenes/index.php">Item Biaya</a></li>
							<li><a href="../finConstRevenue/index.php">Item Pendapatan</a></li>
						</ul>
					</li>
					<?php endif; ?>					
					-->			

					<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
					<li>
						<a href="#">Keuangan</a>
						<ul>
							<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
								<li><a href="../finSourceFund/index.php">Sumber Pendanaan</a></li>
								<li style="height:2px; background-color: gray;text-shadow: 0px 1px 0px #999;">&nbps;</li>
								
								<li><a href="../finConstExpenesDay/index.php">Komp. Pengeluaran Perhari</a></li>
								<li><a href="../finConstExpenesMonth/index.php">Komp. Pengeluaran Perbulan</a></li>								
								<!--
								<li><a href="../finConstRevenue/index.php">Komp. Pendapatan  Bulan</a></li>
								-->
								<li style="height:2px; background-color: gray;text-shadow: 0px 1px 0px #999;">&nsbp;</li>														
								<li><a href="../finPayExpenesDay/index.php">Pengeluaran Perhari </a></li>
								<li><a href="../finPayExpenesMonth/index.php">Pengeluaran Perbulan </a></li>
								<!--							
								   <li><a href="../reportFinEquitas/index.php">Laporan Perubahan	 Modal</a></li>	
								-->
							<?php endif; ?>	
							<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
								<li style="height:2px; background-color: gray;text-shadow: 0px 1px 0px #999;">&nbps;</li>															
								<?php if(in_array($_SESSION['loginPosition'], array('1'))): ?>
									<li><a href="../reportFinProfit/index.php">Laporan Laba & Rugi</a></li>	
								<?php endif; ?>
								<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
									<li><a href="../mutationBank/index.php">Laporan Mutasi Bank</a></li>
								<?php endif; ?>																						
							<?php endif; ?>	
						</ul>
					</li>
					<?php endif; ?>					
							
					<?php if(in_array($_SESSION['loginPosition'], array('1','4','5'))): ?>
					<li>
						<a href="#">Laporan</a>
						<ul>
							<!--	
							<li><a href="../reportSuplier/index.php">Laporan Pemasok</a></li>
							-->
							<?php if(in_array($_SESSION['loginPosition'], array('1'))): ?>
								<li><a href="../reportRevenueByTransaction/index.php">Lap. Pendapatan Per Transaksi</a></li>
							<?php endif; ?>								

							<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
								<li><a href="../reportRevenueByStuffCategory/index.php">Lap. Penjualan Kategori Barang </a></li>												
								<li><a href="../reportRevenueByCustomer/index.php">Lap. Pembelian Pelanggan</a></li>								
								<li><a href="../reportRevenueByStuff/index.php">Lap. Penjualan Barang</a></li>	

								<li><a href="../reportConversionAds/index.php">Lap. Konversi Penjualan &hArr; Iklan</a></li>	

								<li><a href="../reportRevenueBySales/index.php">Lap. Kinerja Sales</a></li>	
							<?php endif; ?>																		

							<?php if(in_array($_SESSION['loginPosition'], array('5'))): ?>
							   <li><a href="../reportRevenueByCustomer/index.php">Lap. Pembelian Pelanggan</a></li>
							<?php endif; ?>
							
							<!--
							<li><a href="../reportClient/index.php">Laporan Pedagang</a></li>
							-->
							<!--
							<li><a href="../resOumeSuplier/index.php">Rekapitulasi Pemasok</a></li>
							-->
							<!--
							<li><a href="../resumeClient/index.php">Rekapitulasi Klien</a></li>
							-->
							<!--
							<li style="height:3px; background-color: gray;text-shadow: 0px 1px 0px #999;">&nsbp;</li>
							-->
							<?php if(in_array($_SESSION['loginPosition'], array('1'))): ?>							
								<li><a href="../reportStock/index.php">Laporan Stok Barang</a></li>		
							<?php endif; ?>	

							<?php if(in_array($_SESSION['loginPosition'], array('1','4'))): ?>
								<li><a href="../reportActivitySale/index.php">Rekap. Aktivitas Penjualan</a></li>
							<?php endif; ?>	
							
							<!--
							<li><a href="../report/index.php">Log Mutasi Barang</a></li>								
							-->
						</ul>
					</li>
					<?php endif; ?>

					<?php if(in_array($_SESSION['loginPosition'], array('3','5'))): ?>
						<li><a href="../reportRevenueSalesIndividu/index.php">Laporan Kinerja</a></li>								
					<?php endif; ?>
				</ul>
			</div>
		</td>	
		<td valign="top">
			<div id="smoothmenu" class="ddsmoothmenu">		
				<ul>
					<li>
						<a href="#">Setting</a>
						<ul>
							<?php if(in_array($_SESSION['loginPosition'], array('1'))): ?>
								<li><a href="../member/index.php">Member</a></li>	
							<?php endif; ?>							
							<li><a href="../changePassword/edit.php">Ubah Password</a></li>															
							<li><a href="../login/signout.php">Logout</a></li>
						</ul>	
					</li>	
				</ul>
			</div>
		</td>
	</tr>
</table>
<hr />
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

