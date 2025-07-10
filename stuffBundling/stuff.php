<?php ob_start(); ?>
<?php include 'stuffRead.php' ?>

<table width="100%">
  <tr>
  	 <td valign="top">
		<h1>EDIT PENGATURAN BARANG BUNDLING</h1>  	 	
  	 </td>
  	 <td align="right" valign="middle">				
  	 	<input type="button" value="KEMBALI KE BARANG BUNDLING" onclick="window.location='index.php'" />
  	 </td>
  </tr>
</table>	
<hr />

<table width="100%">
	<tr>
		<td width="25%">KATEGORI</td>
		<td style="height: 25px;">
		  <?php echo $data['category_name'] ?>	
		</td>
	</tr>		
	<tr>
		<td width="20%" valign="top">NAMA BARANG</td>
		<td>
			<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>
		</td>
	</tr>			
	<tr>
		<td width="20%" valign="top">HARGA MININUM BUNDLING</td>
		<td>
			<?php echo number_format($data['price_min'],0,'','.') ?></div>
		</td>
	</tr>			
	<tr>
		<td width="20%" valign="top">KOMISI SALES</td>
		<td>
			<?php echo number_format($data['fee_sales'],0,'','.') ?></div>
		</td>
	</tr>			

	<tr>
		<td>SEMBUNYIKAN</td>
		<td style="height: 25px;">
			<?php if($data['is_hidden'] == '1'): ?>
				Sembunyikan, agar tidak tampil dipilih menu penjualan
			<?php else: ?>
				Tidak disembunyikan	
			<?php endif; ?>				
		</td>
	</tr>			
</table>
<hr />
<br /><br />

<?php if(isset($_GET['msg'])) : ?>
 	<div class="info">
		<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
	</div>		
<?php endif ?>

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
		    <div style=""><input type="button" value="TAMBAH PENGATURAN BARANG" data-title="TAMBAH BARANG" data-width="950" data-height="500"  link="addStuff.php?stuffBundlingId=<?php echo $data['id'] ?>"  /></div>
	   </div>   
	   <div id="tbl">
		<table width="100%" border="1">
			<thead>			
				<tr>
					<th align="center" width="5%">&nbsp;</th>
					<th align="center" width="5%">NO</th>
					<th align="center" width="25%">NAMA BARANG</th>
					<th align="center" width="35%">PENGATURAN</th>
				</tr>	
			</thead>
			<tbody>
				<script type="text/javascript">var globallistStufId = [];</script>
				<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
				<?php $totalPriceBasic = 0 ?>
				<?php $totalFeeSales = 0 ?>
				<?php $totalPrice = 0 ?>
				<?php while($val = mysql_fetch_array($dataStuff)): ?>
					<script type="text/javascript">globallistStufId.push(<?php echo $val['id'] ?>) ;</script>
					<?php $totalPriceBasic = ($totalPriceBasic + $val['price_basic'])?>
					<?php $totalFeeSales = ($totalFeeSales + $val['fee_sales'])?>
					<?php $totalPrice = ($totalPrice + ($val['price'] * $val['qty']))?>
					<tr>
						<td align="center" valign="top">
							<input type="checkbox" name="stuffIdChoose[] " value="<?php echo $val['id'] ?>" checked>
						</td>
						<td align="center" valign="top">
						  <?php echo $i ?>
						</td>
						<td align="left" valign="top">
							<?php echo $val['name'] ?> <br />
							<small style="font-size:9px; padding-left:0px">Category : <?php echo $val['category_name'] ?></small>
						</td>
						<td align="center" valign="top">
							<table width="100%" style="border: 0px; font-size: 11px">															
							  <tr>
							  	<td  style="border: 0px">Harga Dasar</td>
							  	<td  style="border: 0px">: 
							  		<?php echo number_format($val['price_basic'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							  	</td>
							  </tr>		
							  <tr>
							  	<td  style="border: 0px">Harga Normal</td>
							  	<td  style="border: 0px">: 
							  		<?php echo number_format($val['price_normal'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							  	</td>
							  </tr>		
							  <tr>
							  	<td  style="border: 0px">Kuantiti Maksimum</td>
							  	<td  style="border: 0px">: 
							  	    <input  name="qty_<?php echo $val['id'] ?>" type="number" min="0"  value="<?php echo $val['qty'] ?>" style="width: 50px; height: 30px; text-align: center;"> 								  		
							  	</td>
							  </tr>		
							</table>
						</td>
					</tr>	
				<?php $i++; ?>
				<?php endwhile; ?>
			<tbody>
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

	function priceBundling(pDiscounType,pDiscountVal,pPriceBasic,pPriceBundling,pPriceBundlingLabel,pPriceBundlingLabelTotal,pQty,pPriceNormalQty) {
		var rst = 0;
		if(pDiscounType == 0) {
			rst = (pPriceBasic - ((pDiscountVal / 100) *  pPriceBasic));
		} else {
			rst = (pPriceBasic - pDiscountVal);
		}

		$('#'+pPriceBundling).val(rst);
		$('#'+pPriceBundlingLabel).html(rst).simpleMoneyFormat();

		$('#'+pPriceBundlingLabelTotal).html((rst * pQty)).simpleMoneyFormat();

		grandTotalPriceBundling(globallistStufId);
 
		$('#'+pPriceNormalQty).html(parseInt(pPriceBasic) * parseInt(pQty)).simpleMoneyFormat();;		
	}	

	function grandTotalPriceBundling(pListStuffId) {
		total = 0;
		for (i = 0; i < pListStuffId.length; i++) {
		  var val = $('#price_bundling_label_total_'+pListStuffId[i]).html();	
		  total = (parseInt(total) + parseInt(val.replace(/\./g,'')));
		  //console.log(total);
		} 

		$('#divHargaBundlingLabelFooter').html(total).simpleMoneyFormat();
		$('#divHargaBundlingLabel').html(total).simpleMoneyFormat();
	}
	grandTotalPriceBundling(globallistStufId);

	function grandTotalFeeSales() {
		total = 0; 
		for (i = 0; i < globallistStufId.length; i++) {
		  var val = $('#fee_sales_'+globallistStufId[i]).val();	
		  total = (parseInt(total) + parseInt(val.replace(/\./g,'')));
		  //console.log(val);
		} 

		$('#divFeeSalesLabelFooter').html(total).simpleMoneyFormat();
		$('#divFeeSalesLabel').html(total).simpleMoneyFormat();
	}
	grandTotalFeeSales();
</script>


<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
