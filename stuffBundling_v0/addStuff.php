<?php ob_start(); ?>
	<?php include 'addStuffRead.php' ?>

	<script type="text/javascript">
		function priceBundling(pDiscounType,pDiscountVal,pPriceBasic,pPriceBundling,pPriceBundlingLabel,pPriceBundlingLabelTotal,pQty) {
			var rst = 0;
			if(pDiscounType == 0) {
				rst = (pPriceBasic - ((pDiscountVal / 100) *  pPriceBasic));
			} else {
				rst = (pPriceBasic - pDiscountVal);
			}

			$('#'+pPriceBundling).val(rst);
			$('#'+pPriceBundlingLabel).html(rst).simpleMoneyFormat();

			$('#'+pPriceBundlingLabelTotal).html((rst * pQty)).simpleMoneyFormat();
		}					
	</script>

	<h1>BARANG</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="addStuff.php" method="get">
		   <input type="hidden" name="stuffBundlingId" value="<?php echo $stuffBundlingId ?>">				
			<table width="100%">
				<tr>
					<td width="15%">KATEGORI</td>
					<td>
						<select name="categoryId" style="width:90%">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
					<td>KATA KUNCI</td>
					<td>
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:90%" /><br />
						<small><i>NAMA BARANG / JUDUL PRODUK</i></small>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>	
				<tr>
					<td colspan="4">
						<input type="submit" value="FILTER" style="width: 100%" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<p></p>

	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="addStuffSave.php" method="post" onsubmit="return confirm('Anda yakin memilih barang tersebut ?')">		
		   <input type="hidden" name="stuffBundlingId" value="<?php echo $stuffBundlingId ?>">	
		   <div style="float: left; margin-top: 20px; width: 100%; margin-bottom: 10px">
		   	  <input type="submit" value="PILIH BARANG" style="width: 100%; margin-left:-1px; font-weight: bold; background-color: #f98b0c; color: white; border: 0px" />
		   </div>	  
		   <div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">&nbsp;</th>
						<th align="center" width="5%">NO</th>
						<th align="center" width="25%">NAMA BARANG</th>
						<th align="center" width="37%">HARGA</th>
						<th align="center" width="">KOMISI SALES</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center" valign="top">
								<input type="checkbox" name="stuffIdChoose[] " value="<?php echo $val['id'] ?>">
							</td>
							<td align="center" valign="top">
							  <?php echo $i ?>
							</td>
							<td align="left" valign="top">
								<?php echo $val['name'] ?> 
								<small style="font-size:9px; padding-left:0px">Category : <?php echo $val['category_name'] ?></small>
							</td>
							<td align="center"  valign="top">
								<table width="100%" style="border: 0px; font-size: 11px">
								  <tr>
								  	<td  style="border: 0px">Harga Normal</td>
								  	<td  style="border: 0px">: 
								  		<?php echo number_format($val['price_normal'],0,'','.') ?> / <?php echo $val['const_name'] ?>
								  	</td>
								  </tr>		
								  <tr>
								  	<td width=""  style="border: 0px;" valign="top">Potongan Harga</td>
								  	<td  style="border: 0px">: 
								  		<input type="text" onkeyup="priceBundling($('#discount_type_<?php echo $val['id'] ?>').val(),$('#discount_val_<?php echo $val['id'] ?>').val(),'<?php echo $val['price_normal'] ?>','price_<?php echo $val['id'] ?>','price_bundling_label_<?php echo $val['id'] ?>','price_bundling_label_total_<?php echo $val['id'] ?>',$('#qty_<?php echo $val['id'] ?>').val())" name="discount_val_<?php echo $val['id'] ?>" id="discount_val_<?php echo $val['id'] ?>" value="0" style="width: 90px"><br /> 
								  		&nbsp;&nbsp;<select name="discount_type_<?php echo $val['id'] ?>" id="discount_type_<?php echo $val['id'] ?>" style="width: 90px" onchange="priceBundling($('#discount_type_<?php echo $val['id'] ?>').val(),$('#discount_val_<?php echo $val['id'] ?>').val(),'<?php echo $val['price_normal'] ?>','price_<?php echo $val['id'] ?>','price_bundling_label_<?php echo $val['id'] ?>','price_bundling_label_total_<?php echo $val['id'] ?>',$('#qty_<?php echo $val['id'] ?>').val())">
								  		    <option value="0"  <?php echo $val['discount_type'] == '0' ? 'selected' : '' ?>>Percent</option>
										    <option value="1"  <?php echo $val['discount_type'] == '1' ? 'selected' : '' ?>>Nominal</option>
								  		</select>
								  	</td>
								  </tr>		
								  <tr>
								  	<td  style="border: 0px">Harga Jual Bundling</td>
								  	<td  style="border: 0px">: 
								  		<span id="price_bundling_label_<?php echo $val['id'] ?>"><?php echo number_format($val['price'],0,'','.') ?> </span>/ <?php echo $val['const_name'] ?>
								  		<input type="hidden"  name="price_<?php echo $val['id'] ?>" id="price_<?php echo $val['id'] ?>" value="<?php echo $val['price'] ?>" >		
								  	</td>
								  </tr>		
								  <tr>
								  	<td  style="border: 0px">Kuantiti</td>
								  	<td  style="border: 0px">: 
								  	    <input type="number" min="1" onchange="priceBundling($('#discount_type_<?php echo $val['id'] ?>').val(),$('#discount_val_<?php echo $val['id'] ?>').val(),'<?php echo $val['price_normal'] ?>','price_<?php echo $val['id'] ?>','price_bundling_label_<?php echo $val['id'] ?>','price_bundling_label_total_<?php echo $val['id'] ?>',$('#qty_<?php echo $val['id'] ?>').val())" name="qty_<?php echo $val['id'] ?>" id="qty_<?php echo $val['id'] ?>" value="1" style="width: 50px; height: 30px; text-align: center;"> 								  		
								  	</td>
								  </tr>		
								  <tr>
								  	<td  style="border: 0px">Jumlah Jual Bundling</td>
								  	<td  style="border: 0px">: 
								  		<span id="price_bundling_label_total_<?php echo $val['id'] ?>"><?php echo number_format(($val['price'] * $val['qty']),0,'','.') ?> </span>
								  	</td>
								  </tr>		
								</table>

							</td>
							<td align="center" valign="top">
								<table width="100%" style="border: 0px;">
								  <tr>
								  	<td width="55%"  style="border: 0px;">Komisi</td>
								  	<td  style="border: 0px">: 
								  		<?php echo number_format($val['fee_sales_basic'],0,'','.') ?>
								  		<input type="hidden" name="fee_sales_basic_<?php echo $val['id'] ?>" id="fee_sales_basic_<?php echo $val['id'] ?>" value="<?php echo $val['fee_sales_basic'] ?>" >										  			
								  	</td>
								  </tr>		
								  <tr>
								  	<td  style="border: 0px">Komisi Bundling</td>
								  	<td  style="border: 0px">: 
								  	  <input type="text" name="fee_sales_<?php echo $val['id'] ?>" value="<?php echo $val['fee_sales_basic'] ?>"  style="width: 70px">
								  	</td>
								  </tr>		
								</table>								
							</td>
						</tr>	

						<script type="text/javascript">
						  priceBundling($('#discount_type_<?php echo $val['id'] ?>').val(),$('#discount_val_<?php echo $val['id'] ?>').val(),'<?php echo $val['price_normal'] ?>','price_<?php echo $val['id'] ?>','price_bundling_label_<?php echo $val['id'] ?>','price_bundling_label_total_<?php echo $val['id'] ?>',$('#qty_<?php echo $val['id'] ?>').val())											
						</script>								  		
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'stuffBundlingId='.$stuffBundlingId,'categoryId='.$categoryId));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>	
		   </div>
		</form>
	<?php endif; ?>
	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>	