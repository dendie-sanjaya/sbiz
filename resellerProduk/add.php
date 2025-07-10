<?php ob_start(); ?>
	<?php include 'addRead.php' ?>

	<h1>BARANG</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="add.php" method="get">
		   <input type="hidden" name="resellerId" value="<?php echo $resellerId ?>">				
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
		<form action="addSave.php" method="post" onsubmit="return confirm('Anda yakin memilih barang tersebut ?')">		
		   <input type="hidden" name="resellerId" value="<?php echo $resellerId ?>">	
		   <div style="float: left; margin-top: 20px; width: 100%">
		   	  <input type="submit" value="PILIH BARANG " style="width: 100%; font-weight: bold" />
		   </div>	  
		   <div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%"><input type="checkbox" name="checkAll" id="checkAll"></th>
						<th align="center" width="5%"style="font-size: 11px">NO</th>
						<th align="center" width="25%" style="font-size: 11px">NAMA BARANG</th>
						<th align="center" width="12%" style="font-size: 11px">HARGA DASAR </th>
						<th align="center" width="12%" style="font-size: 11px">HARGA PUBLISH </th>
						<th align="center" width="12%" style="font-size: 11px">HARGA UNTUK RESELLER</th>
						<th align="center" width="12%" style="font-size: 11px">KOMISI <br />PERSEN</th>
						<th align="center" style="font-size: 11px">KOMISI NOMINAL</th>
						<th align="center" style="font-size: 11px">POIN</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center">
								<input type="checkbox" name="stuffIdChoose[] " value="<?php echo $val['id'] ?>">
								<input type="hidden" name="stuffId[] " value="<?php echo $val['id'] ?>">
							</td>
							<td align="center">
							  <?php echo $i ?>
							</td>
							<td align="left">
								<?php echo $val['name'] ?> <br />
								<?php if(strlen($val['nickname']) > 0): ?>
									<small style="font-size:9px; padding-left:0px"><?php echo $val['nickname'] ?></small><br />
								<?php endif; ?>	
								<small style="font-size:9px; padding-left:0px">Category : <?php echo $val['category_name'] ?></small><br />
								<input type="text" name="linkStuff[]" placeholder="Link Brosur Barang"  style="text-align: left; margin-top: 10px; width: 100%"> 
							</td>
							<td align="center" style="font-size: 11px">
								<?php echo number_format($val['price_basic'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>
							<td align="center" style="font-size: 11px">
								<?php echo number_format($val['price_publish'],0,'','.') ?> / <?php echo $val['const_name'] ?>
							</td>							
							<td align="center">
								<input type="text" name="priceBasicReseller[]" value="0" size="5" style="text-align: right;">
							</td>
							<td align="center">
							  <input type="text" name="feeResellerPercent[]" value="0" size="1" style="text-align: right;"> %
							</td>
							<td align="center">
							  <input type="text" name="feeResellerNominal[]" value="0" size="5" style="text-align: right;">
							</td>
							<td align="center">
							  <input type="text" name="point[]" value="0" size="2" style="text-align: center;">
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'resellerId='.$resellerId,'categoryId='.$categoryId));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>	
		   </div>
		</form>
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>
	<script type="text/javascript">
		$("#checkAll").click(function(){
		    $('input:checkbox').not(this).prop('checked', this.checked);
		});		
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>	