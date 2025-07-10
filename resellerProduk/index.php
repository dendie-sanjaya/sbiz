<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<table width="100%">
	   <tr>
	   	  <td valign="top"><h1>RESELLER PRODUK</h1></td>
	   	  <td valing="top" align="right"><input type="button" value="KEMBALI" onclick="window.location='../reseller/index.php'" /></td>	
	   </tr>	
	</table>	
		
	<fieldset>
		<legend><b>INFO RESELLER<b></legend>	
			<form action="index.php" method="post" >					
				<table width="100%">
					<tr>
						<td width="20%" valign="top">NAMA</td>
						<td width="28%" valign="top"><b><?php echo strtoupper($dataReseller['name']) ?></b></td>
						<td width="20%" valign="top">TGL DAFTAR</td>
						<td valign="top"><b><?php echo $dataReseller['date_input_format'] ?></b></td>
					</tr>
					<tr>
						<td valign="top">HANDPHONE</td>
						<td valign="top"><b><?php echo $dataReseller['country_code'] ?><?php echo $dataReseller['phone_number'] ?></b></td>
						<td valign="top">EMAIL</td>
						<td valign="top"><b><?php echo $dataReseller['email'] ?></b></td>
					</tr>
				</table>
			</form>	
	</fieldset>
	<br />

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<?php if(mysql_num_rows($data) < 1) : ?>
	    <div style="margin: 10px 0px 5px 0px" class="button">
	        <div style="float: left;"><input type="button" value="TAMBAH BARANG" data-title="TAMBAH BARANG" data-width="950" data-height="500"  link="add.php?resellerId=<?php echo $resellerId ?>"  /></div>
		</div>   
	<?php endif; ?>

	<div style="clear: both"></div>
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="editSave.php" method="post" onsubmit="return submitAct()" id="frm">		
		   <input type="hidden" name="resellerId" value="<?php echo $resellerId ?>">	
		   <div style="float: left; margin-bottom: 2px; margin-top: 20px">
				<select name="actionType" id="actionType" style="width:200px;">
					<option value="0">-- PILIH AKSI --</option>
					<option value="1">UPDATE</option>
					<option value="2">DELETE</option>	
				</select>
				<input style="font-weight:bold; width:60px; height:30px" name="submit" type="submit" value=" OK " />
		   </div>	  
		   <div style="float: right; margin-bottom: 2px; margin-top: 20px">
	          <div style="float: right;"  class="button"><input type="button" value="TAMBAH BARANG" data-title="TAMBAH BARANG" data-width="950" data-height="500"  link="add.php?resellerId=<?php echo $resellerId ?>"  /></div>
		   </div>   
		   <div id="tbl">
			<table width="100%" border="1">
				<thead >			
					<tr >
						<th align="center" width="5%">&nbsp;</th>
						<th align="center" width="5%"  style="font-size: 11px" >NO</th>
						<th align="center" width="25%" style="font-size: 11px">NAMA BARANG</th>
						<th align="center" width="12%" style="font-size: 11px">HARGA DASAR </th>
						<th align="center" width="12%" style="font-size: 11px">HARGA PUBLISH </th>
						<th align="center" width="12%" style="font-size: 11px">HARGA UNTUK RESELLER</th>
						<th align="center" width="12%" style="font-size: 11px">KOMISI <br />PERSEN</th>
						<th align="center" style="font-size: 11px">KOMISI <br />NOMINAL</th>
						<th align="center"  style="font-size: 11px">POIN</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center">
								<input type="checkbox" name="resellerStuffIdChoose[] " value="<?php echo $val['reseller_stuff_id'] ?>">
								<input type="hidden" name="resellerStuffId[] " value="<?php echo $val['reseller_stuff_id'] ?>">
							</td>
							<td align="center">
							  <?php echo $i ?>
							</td>
							<td align="left" style="font-size: 11px">
								<?php echo $val['name'] ?> <br />
								<?php if(strlen($val['nickname']) > 0): ?>
									<small style="font-size:9px; padding-left:0px"><?php echo $val['nickname'] ?></small><br />
								<?php endif; ?>	
								<small style="font-size:9px; padding-left:0px">Category : <?php echo $val['category_name'] ?></small><br />
								<input type="text" name="linkStuff[]" placeholder="Link Brosur Barang"  style="text-align: left; margin-top: 10px; width: 100%" value="<?php echo $val['link_product_brosur'] ?>"> 
							</td>
							<td align="center">
								<?php echo number_format($val['price_basic_store'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>
							<td align="center">
								<?php echo number_format($val['price_publish'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>
							<td align="center">
								<input type="text" name="priceBasicReseller[]" value="<?php echo $val['price_basic_reseller'] ?>" size="5" style="text-align: right;" value="<?php echo $val['link_product_brosur'] ?>">
							</td>
							<td align="center">
							  <input type="text" name="feeResellerPercent[]" value="<?php echo $val['fee_reseller_percent'] ?>" size="1" style="text-align: right;"> %
							</td>
							<td align="center">
							  <input type="text" name="feeResellerNominal[]" value="<?php echo $val['fee_reseller_nominal'] ?>" size="5" style="text-align: right;">
							</td>
							<td align="center">
							  <input type="text" name="point[]" value="<?php echo $val['point'] ?>" size="2" style="text-align: center;">
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
					document.getElementById('frm').action = 'editSave.php';	
					document.getElementById('frm').target = '';						
					return true;
				} else {
					return false;
				}				
			}

			if(p == '2') {
				if(confirm('Anda yakin akan melakukan hapus ?')) {
					document.getElementById('frm').action = 'delete.php';	
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
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
