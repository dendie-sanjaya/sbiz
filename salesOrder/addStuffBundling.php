<?php ob_start(); ?>
	<?php include 'addStuffBundlingRead.php' ?>

	<script type="text/javascript">
		function calcPrice(pQty,pStuffId) {
			var priceBasic = $('#priceBasic_'+pStuffId).val();
			var price = $('#price_'+pStuffId).val();

			var priceBasicTotal = (priceBasic * pQty);
			var priceTotal = (price * pQty);

			$('#priceBasicTotal_'+pStuffId).val(priceBasicTotal); 
			$('#priceTotal_'+pStuffId).val(priceTotal);

			var tmp = 0;
			$("input[name='detailPriceBasicTotal']").each(function() {
			    tmp = parseInt($(this).val()) + tmp;			    
			});
			$('#priceBasic').val(tmp);

			var tmp = 0;
			$("input[name='detailPriceTotal']").each(function() {
			    tmp = parseInt($(this).val()) + tmp;			    
			});

			$('#priceReal').val(tmp);
			$('#labelPriceReal').html(tmp).simpleMoneyFormat();
		}

		function validateMinPrice() {
			var priceReal = $('#priceReal').val();
			var price =  $('#price').val();

			if(priceReal < price ) {
			   alert('Jumlah Kombinasi barang yang dipilih belum sesuai');
			   return false;	
			} else {
		   	   return true;
			}	
		}
	</script>


	<h1>PILIH KOMBINASI BARANG</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<div style="text-align: right; margin-top:30px">
		<input type="button" value="KEMBALI KE DAFTAR BARANG BUNDLING" onclick="window.location='addStuff.php?stuffBundlingId=<?php echo $val['id'] ?>&keyword=<?php echo $_REQUEST['keyword'] ?>&categoryId=<?php echo $categoryId ?>&record=<?php echo $record ?>&id=<?php echo $_REQUEST['salesOrderId'] ?>&isBundling=1'" />										
	</div>

	<form action="addStuffSave.php" method="post" onsubmit="return validateMinPrice()">				
		<input type="hidden" name="amount" value="1">
		<input type="hidden" name="isBundling" value="1">
		<input type="hidden" name="id" value="<?php echo $salesOrderId ?>">
		<input type="hidden" id="price" name="price" value="<?php echo $dataHeader['price'] ?>">
		<input type="hidden" id="priceReal" name="priceReal" value="0">
		<input type="hidden" id="priceBasic" name="priceBasic" value="0">
		<input type="hidden" name="stuffId" value="<?php echo $stuffBundlingId ?>">

		<fieldset>
			<legend><b>INFORMASI</b></legend>
			<table width="100%">
				<tr>
					<td width="40%">
						NAMA PAKET <br />
						<b><?php echo $dataHeader['name'] ?> <br /><small>( <?php echo $dataHeader['category_name'] ?>)</small></b>
					</td>
					<td  width="35%">
						HARGA JUAL BUNDLING <br />
						<b><?php echo number_format($dataHeader['price'],0,'','.') ?></b> 
					</td>
					<td>
						KOMISI SALES <br />
						<b><?php echo number_format($dataHeader['fee_sales'],0,'','.') ?></b> 
					</td>
				</tr>			
			</table>
		</fieldset>
		<p></p>
		<?php if(mysql_num_rows($data) < 1) : ?>
		 	<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
		   <div style="float: left; margin-top: 20px; width: 100%; margin-bottom: 10px">
		   	  <input type="submit" value="SIMPAN KOMBINASI BARANG" style="width: 100%; margin-left:-1px; font-weight: bold; background-color: #f98b0c; color: white; border: 0px" />
		   </div>	  

			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="38%">NAMA BARANG</th>
							<th align="center" width="20%">HARGA JUAL</th>
							<th align="center" width="15%">STOK</th>
							<th>&nbsp;</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i = 1 ?>
						<?php while($val = mysql_fetch_array($data)): ?>
								<tr>
									<td align="center"><?php echo $i ?></td>
									<td align="left">
										<input type="hidden" name="bundling_stuff_id[]" value="<?php echo $val['stuff_id'] ?>">
										<input type="hidden" name="detailPriceBasis"  id="priceBasic_<?php echo $val['stuff_id'] ?>"  value="<?php echo $val['price_basic'] ?>">
										<input type="hidden" name="detailPrice"  id="price_<?php echo $val['stuff_id'] ?>" value="<?php echo $val['price'] ?>">
										<input type="hidden" name="detailPriceBasicTotal" id="priceBasicTotal_<?php echo $val['stuff_id'] ?>"  value="<?php echo $val['price_basic'] ?>">
										<input type="hidden" name="detailPriceTotal" id="priceTotal_<?php echo $val['stuff_id'] ?>" value="<?php echo $val['price'] ?>">

										<?php echo $val['name'] ?><br />
										<?php if(strlen($val['nickname']) > 0): ?>
											<small style="font-size:9px; padding-left:5px"><?php echo $val['nickname'] ?></small><br />
										<?php endif; ?>	
										<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>
										<?php if(isset($val['sku'])): ?><br />
											<small style="font-size:9px; padding-left:5px">(SKU : <?php echo $val['sku'] ?>)</small>	
										<?php endif; ?>	
									</td>
									<td align="center">
										<?php echo number_format($val['price'],0,'','.') ?> <br /> /<?php echo $val['const_name'] ?>
									</td>
									<td align="center">
										<?php echo $val['stock'] ?>
										<?php echo $val['const_name'] ?>
										<small>Max Qty Pilih <?php echo $val['qty_max'] ?> <?php echo $val['const_name'] ?></small>
									</td>
									<td align="center">
										<?php if($val['stock'] > 0): ?>
											JUMLAH BELI<input onchange="calcPrice(this.value,<?php echo $val['stuff_id'] ?>)" min="0" max="<?php echo $val['qty_max'] ?>" type="number" value="1" id="amount_<?php echo $val['stuff_id'] ?>" name="amount_<?php echo $val['stuff_id'] ?>" size="3" style="text-align:center; height: 30px" />
										    <script type="text/javascript">calcPrice(1,<?php echo $val['stuff_id'] ?>)</script>											
										<?php else: ?>
											JUMLAH BELI <input disabled type="text" value="0" id="amount_<?php echo $val['stuff_id'] ?>" name="amount_<?php echo $val['stuff_id'] ?>" size="1" style="text-align:center" />
										    <script type="text/javascript">calcPrice(0,<?php echo $val['stuff_id'] ?>)</script>											
										<?php endif; ?>											
									</td>
								</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
					<tr>
					  <td colspan="4" align="center"><b>TOTAL HARGA JUAL</b></td>	
					  <td align="center">
					  	<b><div id="labelPriceReal">0</div></b>
					    <script type="text/javascript">calcPrice(0,<?php echo $val['stuff_id'] ?>)</script>																					  	
					  </td>
					</tr>	
				</table>
			</div>
		<?php endif; ?>
	</form>
	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>	
