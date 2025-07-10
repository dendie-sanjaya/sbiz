<?php ob_start(); ?>
<?php include 'editRead.php' ?>

	<h1>EDIT BARANG BUNDLING</h1>
	<hr />
	<form action="editSave.php" method="post" enctype="multipart/form-data">
		<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />		
		<table width="100%">
			<tr>
				<td width="30%">KATEGORI</td>
				<td>
					<select name="categoryId" >
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : $data['category_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>			
					<div style="color:red"><?php echo isset($msgError['categoryId']) ? $msgError['categoryId'] : '' ?></div>	
				</td>
			</tr>		
			<tr>
				<td width="20%" valign="top">NAMA BARANG</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>			
			<tr>
				<td width="20%" valign="top">HARGA BUNDLING</td>
				<td>
					<div id="divHargaBundlingLabel" style="height: 25px; font-weight: bold">0</div>
				</td>
			</tr>			

			<tr>
				<td>SEMBUNYIKAN</td>
				<td>
					<select name="isHidden" style="width: 95px">
						<option value="0" <?php echo 0 == isset($_POST['isHidden']) ? $_POST['isHidden'] : $data['is_hidden']  ? 'selected' : '' ?>>Tidak</option>
						<option value="1" <?php echo 1 == isset($_POST['isHidden']) ? $_POST['isHidden'] : $data['is_hidden']  ? 'selected' : '' ?>>Ya</option>
					</select>
					<small style="margin-top: 20px"><i>Sembunyikan, agar tidak tampil dipilih menu penjualan</i></small>
				</td>
			</tr>			
		</table>
		<br />
		<hr />
		<div style="text-align: right;">
			<input type="submit" value="SIMPAN"/>
			<input type="button" value="BATAL" onclick="window.location='index.php'" />
		</div>
		<hr />	
		<br />

	</form>

	<?php if(mysql_num_rows($dataStuff) < 1) : ?>
		<div style="margin: 10px 0px 10px 0px; text-align: right;" class="button">
		    <div style=""><input type="button" value="TAMBAH BARANG" data-title="TAMBAH BARANG" data-width="950" data-height="500"  link="addStuff.php?stuffBundlingId=<?php echo $data['id'] ?>"  /></div>
		</div>   
	<?php endif; ?>	

	<div style="clear: both"></div>
	<?php if(mysql_num_rows($dataStuff) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="editStuffSave.php" method="post" onsubmit="return submitAct()" id="frm">		
		   <input type="hidden" name="stuffBundlingId" value="<?php echo $data['id'] ?>">	
		   <div style="float: left; margin-bottom: 2px; margin-top: 20px">
				<select name="actionType" id="actionType" style="width:200px;">
					<option value="0">-- PILIH AKSI --</option>
					<option value="1">UPDATE</option>
					<option value="2">DELETE</option>	
				</select>
				<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
		   </div>	  
		   <div style="float: right; margin-bottom: 2px; margin-top: 20px" class="button">
			    <div style=""><input type="button" value="TAMBAH BARANG" data-title="TAMBAH BARANG" data-width="950" data-height="500"  link="addStuff.php?stuffBundlingId=<?php echo $data['id'] ?>"  /></div>
		   </div>   
		   <div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">&nbsp;</th>
						<th align="center" width="5%">NO</th>
						<th align="center" width="25%">NAMA BARANG</th>
						<th align="center" width="15%">HARGA DASAR </th>
						<th align="center" width="35%">HARGA BUNDLING</th>
						<th align="center" width="">KOMISI SALES</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php $totalPriceBasic = 0 ?>
					<?php $totalFeeSales = 0 ?>
					<?php $totalPrice = 0 ?>
					<?php while($val = mysql_fetch_array($dataStuff)): ?>
						<?php $totalPriceBasic = ($totalPriceBasic + $val['price_basic'])?>
						<?php $totalFeeSales = ($totalFeeSales + $val['fee_sales'])?>
						<?php $totalPrice = ($totalPrice + ($val['price'] * $val['qty']))?>
						<tr>
							<td align="center" valign="top">
								<input type="checkbox" name="stuffIdChoose[] " value="<?php echo $val['id'] ?>">
							</td>
							<td align="center" valign="top">
							  <?php echo $i ?>
							</td>
							<td align="left" valign="top">
								<?php echo $val['name'] ?> <br />
								<small style="font-size:9px; padding-left:0px">Category : <?php echo $val['category_name'] ?></small>
							</td>
							<td align="center" valign="top">
								<?php echo number_format($val['price_basic'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>
							<td align="center" valign="top">
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
								  		<input type="text" onkeyup="priceBundling($('#discount_type_<?php echo $val['id'] ?>').val(),$('#discount_val_<?php echo $val['id'] ?>').val(),'<?php echo $val['price_normal'] ?>','price_<?php echo $val['id'] ?>','price_bundling_label_<?php echo $val['id'] ?>','price_bundling_label_total_<?php echo $val['id'] ?>',$('#qty_<?php echo $val['id'] ?>').val())" name="discount_val_<?php echo $val['id'] ?>" id="discount_val_<?php echo $val['id'] ?>" value="<?php echo $val['discount_type'] == '0' ? $val['discount_percent'] : $val['discount_nominal']  ?>" style="width: 90px"><br /> 
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
								  	    <input type="number" min="1" onchange="priceBundling($('#discount_type_<?php echo $val['id'] ?>').val(),$('#discount_val_<?php echo $val['id'] ?>').val(),'<?php echo $val['price_normal'] ?>','price_<?php echo $val['id'] ?>','price_bundling_label_<?php echo $val['id'] ?>','price_bundling_label_total_<?php echo $val['id'] ?>',$('#qty_<?php echo $val['id'] ?>').val())" name="qty_<?php echo $val['id'] ?>" id="qty_<?php echo $val['id'] ?>" value="<?php echo $val['qty'] ?>" style="width: 50px; height: 30px; text-align: center;"> 								  		
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
								<input type="text" name="fee_sales_<?php echo $val['id'] ?>" value="<?php echo $val['fee_sales'] ?>"  style="width: 70px">
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
				<thead>			
					<tr>
						<th align="center" width="5%" colspan="3">TOTAL</th>
						<th><?php echo number_format($totalPriceBasic,0,'','.') ?></th>
						<th><?php echo number_format($totalPrice,0,'','.') ?></th>
						<th><?php echo number_format($totalFeeSales,0,'','.') ?></th>
					</tr>	
					<script type="text/javascript">
						document.getElementById("divHargaBundlingLabel").innerHTML = "<?php echo number_format($totalPrice,0,'','.') ?>"; 
					</script>
				</thead>

			</table>
		   </div>
		</form>
	<?php endif; ?>

	<script type="text/javascript">
		function submitAct() { 
			var e = document.getElementById ("actionType");
			var p = e.options [e.selectedIndex] .value;
				
			if(p == '0') {
				alert('Mohon untuk memilih aksi terlebih dahulu');
				return false;
			}
			
			if(p == '1') {
				if(confirm('Anda yakin akan melakukan update ?')) {
					document.getElementById('frm').action = 'editStuffSave.php';	
					document.getElementById('frm').target = '';						
					return true;
				} else {
					return false;
				}				
			}

			if(p == '2') {
				if(confirm('Anda yakin akan melakukan hapus ?')) {
					document.getElementById('frm').action = 'deleteStuff.php';	
					document.getElementById('frm').target = '';						
					return true;
				} else {
					return false;
				}				
			}			
		}

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


<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
