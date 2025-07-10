<?php ob_start(); ?>
	<?php include 'addStuffRead.php' ?>
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
						<th align="center" width="50%">NAMA BARANG</th>
						<th align="center" >PENGATURAN</th>
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
								<?php echo $val['name'] ?><br /> 
								<div style="font-size:9px; padding-left:0px; margin-top:5px">Category : <?php echo $val['category_name'] ?></div>
							</td>
							<td align="center"  valign="top">
								<table width="100%" style="border: 0px; font-size: 11px">
								  <tr>
								  	<td  style="border: 0px"  width="50%">Harga Dasar</td>
								  	<td  style="border: 0px">: 
								  		<?php echo number_format($val['price_basic'],0,'','.') ?> / <?php echo $val['const_name'] ?>
								  	</td>
								  </tr>			
								  <tr>
								  	<td  style="border: 0px"  width="50%">Harga Normal</td>
								  	<td  style="border: 0px">: 
								  		<?php echo number_format($val['price_normal'],0,'','.') ?> / <?php echo $val['const_name'] ?>
								  	</td>
								  </tr>			
								  <tr>
								  	<td  style="border: 0px">Kuantiti Maksimum</td>
								  	<td  style="border: 0px">: 
								  	    <input name="qty_<?php echo $val['id'] ?>" type="number" min="0"  value="1" style="width: 50px; height: 30px; text-align: center;"> 								  		
								  	</td>
								  </tr>		
								</table>

							</td>
						</tr>	
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