<?php ob_start(); ?>
<?php include 'printLabelRead.php' ?>

<style type="text/css">
div {
  font-family: Arial, Helvetica, sans-serif;
}
</style>

<?php $i=1 ?>
<?php $index=1 ?>
<?php $jumlahData = mysql_num_rows($data) ?>

<?php while($row = mysql_fetch_array($data)): ?>
	<?php if(($i%2) == 1): ?>
		<table width="100%" cellpadding="10" cellspacing="10"><tr>
	<?php endif; ?>					
		<?php if(($i%2) == 1): ?>
			<td valign="top" style="border:2px solid black; height:150px; width: 200px">				
				<div style="text-align: left; font-size:9pt;"><b>NO ORDER : <?php echo $row['no_order'] ?></b> <sup style="font-size: 9px">(tgl pesan : <?php echo $row['date_order_format'] ?>)</sup></b> </div>
				<div style="font-size:7pt;  margin: 10px 0px 20px 0px" >
					<div style="">
						<?php 
						    $salesOrderId = $row['id'];
							$query = "select sod.name, sod.amount, is_bundling, sod.id,
							 		  (select c.name from const as c where c.id = s.const_id) as satuan 
							 	    from sales_order_detail as sod 
							 	    left join stuff as s 
							 	      on s.id = sod.stuff_id
								    where sod.sales_order_id = '$salesOrderId'
								    order by sod.name asc
								    ";
							$tmpProduk = mysql_query($query) or die(mysql_error());
						?>
						<?php while($rowDetail = mysql_fetch_array($tmpProduk)): ?>
							<?php if($rowDetail['is_bundling'] == '1'): ?>
								<div>
								  (<?php echo $rowDetail['amount'] ?> <?php echo ucfirst(strtolower($rowDetail['satuan'])) ?>) 	
								  <?php echo $rowDetail['name'] ?>	
								</div>
							    <?php 
							    	$query = "select b.id, b.stuff_id, b.qty, s.name
										 from sales_order_detail_bundling as b
										 inner join stuff as s
										   on s.id = b.stuff_id
										 where sales_order_detail_id = '{$rowDetail['id']}'
										 order by id asc";
									$rstDetailBundling = mysql_query($query) or die (mysql_error());
								?>
								<div style="padding-left: 35px; font-style: italic; font-size: 8px">
								Bundling Detail :
								<?php while($dataDetailBundling = mysql_fetch_array($rstDetailBundling)): ?>
									<small style="font-size: 8px"><?php echo $dataDetailBundling['name'] ?> (<?php echo $dataDetailBundling['qty'] ?>),</small>	
								<?php endwhile; ?>											
								</div>
							<?php else: ?>	
								<div>
								  (<?php echo $rowDetail['amount'] ?> <?php echo ucfirst(strtolower($rowDetail['satuan'])) ?>) 	
								  <?php echo $rowDetail['name'] ?>	
								</div>
							<?php endif; ?>	
						<?php endwhile ?>	
					</div>	
				</div>	
				<table width="100%" style="margin-top: -15px">
					<td width="50%" valign="top">
						<div style="font-size:12pt; ">
							<b>PENGIRIM :</b>
						</div>	
						<div style="font-size:12px; text-align:justify;">
							<?php if($row['is_reseller'] == '1'): ?>
								<div><?php echo strtoupper($row['reseller_name']) ?></div>
								<div style="margin-top:5px">Telepon &nbsp;&nbsp;&nbsp;: <?php echo $row['reseller_phone'] ?></div>
							<?php else: ?>
								<?php if($row['is_dropshipper'] == '1'): ?>
									<div><?php echo $row['dropshipper_name'] ?></div>
									<div style="margin-top:5px">Telepon &nbsp;&nbsp;&nbsp;: <?php echo $row['dropshipper_phone'] ?></div>					
								<?php else: ?>	
									<div><?php echo $row['sales_name'] ?></div>
									<div style="margin-top:5px">Telepon &nbsp;&nbsp;&nbsp;: <?php echo $row['sales_phone'] ?></div>					
								<?php endif; ?>	
							<?php endif; ?>	
						</div>
					</td>						
					<td valign="top">
						<div style="font-size: 7px; text-align: justify;">
							<b><u>Disclaimer</u></b>
							<ol style="margin-left: -28px">
								<li>Buka Paket Wajib menggunakan Video dan Foto</li>
								<li>Jika ada masalah pada barang, seperti Rusak/ Salah Kirim/ Kurang Qty, harap menyertakan video dan foto ke admin</li>
								<li>Barang Dikirim terlebih dahulu ke kami, baru kami kirimkan kembali</li>
							</ol>	
						</div>
						
					</td>
				</table>

				<div style="font-size:12pt">
					<b>PENERIMA :</b>
					<div style="font-size:12px; text-align:justify; margin: 10px">
						<div>Pemesan : <?php echo $row['name'] ?></div>
						<div style="margin-top:5px">Telepon &nbsp;&nbsp;: <?php echo $row['phone'] ?></div>
						<div style="margin-top:5px">Alamat  &nbsp;&nbsp;&nbsp;: <?php echo $row['address_shipping'] ?></div>
						<div style="margin-top:5px;">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php echo $row['province'] ?> <?php echo $row['city'] ?> 
							<?php echo $row['districts'] ?> <?php echo $row['districts_sub'] ?>
							<?php echo $row['postal_code'] ?>
					    </div>
					</div>	
				</div>	
				<div style="font-size:10pt">
					<b>KURIR : &nbsp;&nbsp;&nbsp;</b><?php echo $row['expedition_name'] ?>
					<?php if($row['is_cod'] == '1'): ?>
						&nbsp;<span style="font-size: 14px">(PEMBAYARAN <b>COD</b> <b>Rp. <?php echo number_format($row['amount_reseller_to_customer'],0,'','.')  ?></b>)</span>
					<?php endif ?>	
				</div>	
			</td>				
		<?php endif; ?>	

		<?php if(($i%2) == 0): ?> 
			<td width="50%" valign="top" style="border:2px solid black; height:150px; ">				
				<div style="text-align: left; font-size:9pt;"><b>NO ORDER : <?php echo $row['no_order'] ?></b> <sup style="font-size: 9px">(tgl pesan : <?php echo $row['date_order_format'] ?>)</sup></b> </div>
				<div style="font-size:7pt;  margin: 10px 0px 20px 0px" >
					<div style="">
						<?php 
						    $salesOrderId = $row['id'];
							$query = "select sod.name, sod.amount, is_bundling, sod.id,
							 		  (select c.name from const as c where c.id = s.const_id) as satuan 
							 	    from sales_order_detail as sod 
							 	    left join stuff as s 
							 	      on s.id = sod.stuff_id
								    where sod.sales_order_id = '$salesOrderId'
								    order by sod.name asc
								    ";
							$tmpProduk = mysql_query($query) or die(mysql_error());
						?>
						<?php while($rowDetail = mysql_fetch_array($tmpProduk)): ?>
							<?php if($rowDetail['is_bundling'] == '1'): ?>
								<div>
								  (<?php echo $rowDetail['amount'] ?> <?php echo ucfirst(strtolower($rowDetail['satuan'])) ?>) 	
								  <?php echo $rowDetail['name'] ?>	
								</div>
							    <?php 
							    	$query = "select b.id, b.stuff_id, b.qty, s.name
										 from sales_order_detail_bundling as b
										 inner join stuff as s
										   on s.id = b.stuff_id
										 where sales_order_detail_id = '{$rowDetail['id']}'
										 order by id asc";
									$rstDetailBundling = mysql_query($query) or die (mysql_error());
								?>
								<div style="padding-left: 35px; font-style: italic; font-size: 8px">
								Bundling Detail :
								<?php while($dataDetailBundling = mysql_fetch_array($rstDetailBundling)): ?>
									<small style="font-size: 8px"><?php echo $dataDetailBundling['name'] ?> (<?php echo $dataDetailBundling['qty'] ?>),</small>	
								<?php endwhile; ?>											
								</div>
							<?php else: ?>	
								<div>
								  (<?php echo $rowDetail['amount'] ?> <?php echo ucfirst(strtolower($rowDetail['satuan'])) ?>) 	
								  <?php echo $rowDetail['name'] ?>	
								</div>
							<?php endif; ?>	
						<?php endwhile ?>	
					</div>	
				</div>	
				<table width="100%" style="margin-top: -15px">
					<tr>	
					 	<td width="50%" valign="top">					
							<div style="font-size:12pt;">
								<b>PENGIRIM :</b>
							</div>	
							<div style="font-size:12px; text-align:justify; margin: 10px">
								<?php if($row['is_reseller'] == '1'): ?>
									<div><?php echo strtoupper($row['reseller_name']) ?></div>
									<div style="margin-top:5px">Telepon &nbsp;&nbsp;&nbsp;: <?php echo $row['reseller_phone'] ?></div>
								<?php else: ?>
									<?php if($row['is_dropshipper'] == '1'): ?>
										<div><?php echo $row['dropshipper_name'] ?></div>
										<div style="margin-top:5px">Telepon &nbsp;&nbsp;&nbsp;: <?php echo $row['dropshipper_phone'] ?></div>					
									<?php else: ?>	
										<div><?php echo $row['sales_name'] ?></div>
										<div style="margin-top:5px">Telepon &nbsp;&nbsp;&nbsp;: <?php echo $row['sales_phone'] ?></div>					
									<?php endif; ?>	
								<?php endif; ?>	
							</div>	
						</td>
						<td valign="top">
							<div style="font-size: 7px; text-align: justify;">
								<b><u>Disclaimer</u></b>
								<ol style="margin-left: -28px">
									<li>Buka Paket Wajib menggunakan Video dan Foto</li>
									<li>Jika ada masalah pada barang, seperti Rusak/ Salah Kirim/ Kurang Qty, harap menyertakan video dan foto ke admin</li>
									<li>Barang Dikirim terlebih dahulu ke kami, baru kami kirimkan kembali</li>
								</ol>	
							</div>							
						</td>	
					</tr>		
				</table>					

				<table width="100%">
					<tr>
						<td width="50%">
							
						</td>
						<td width="50%">
							
						</td>

					</tr>	
				</table>	
				<div style="font-size:12pt">
					<b>PENERIMA :</b>
					<div style="font-size:12px; text-align:justify; margin: 10px">
						<div>Pemesan : <?php echo $row['name'] ?></div>
						<div style="margin-top:5px">Telepon &nbsp;&nbsp;: <?php echo $row['phone'] ?></div>
						<div style="margin-top:5px">Alamat  &nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $row['address_shipping'] ?></div>
						<div style="margin-top:5px; font-size: 10px ">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php echo $row['province'] ?> <?php echo $row['city'] ?> 
							<?php echo $row['districts'] ?> <?php echo $row['districts_sub'] ?>
							<?php echo $row['postal_code'] ?>
					    </div>
					</div>	
				</div>	
				<div style="font-size:10pt">
					<b>KURIR : &nbsp;&nbsp;&nbsp;</b><?php echo $row['expedition_name'] ?>
					<?php if($row['is_cod'] == '1'): ?>
						&nbsp;<span style="font-size: 14px">(PEMBAYARAN <b>COD</b> <b>Rp. <?php echo number_format($row['amount_reseller_to_customer'],0,'','.')  ?></b>)</span>
					<?php endif ?>	
				</div>	
			</td>				
		<?php endif; ?>	

	<?php if(($i%2) == 0): ?></tr></table><?php endif; ?>
	<?php if($index == $jumlahData): ?>
		<td width="50%"></td>
		</tr></table>
	<?php endif; ?>
	
	<?php $i++ ?>	
	<?php $index++ ?>
	<?php if($i == 7): ?>
		<div style="page-break-after: always;"></div>	
		<?php $i=1 ?>
	<?php endif; ?>			
<?php endwhile; ?>	



<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>
