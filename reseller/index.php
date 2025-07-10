<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<h1>RESELLER</h1>

		<fieldset>
			<legend><b>FILTER<b></legend>	
				<form action="index.php" method="post" >					
					<table width="100%">
						<tr>
							<td width="15%" valign="top">KATA KUNCI</td>
							<td valign="top">
								<input placeholder=""name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:100%"/><br />
								<small style="font-size:8px"><i>NAMA  / NO HANDPHONE / EMAIL</i></small>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="FILTER" style="width: 100%; margin-top:20px" /></td>
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

    <div style="margin: 10px 0px 15px 0px">
        <div style="float: left;">
        	<input type="button" value="TAMBAH" onclick="window.location='add.php'" />
        	<input type="button" value="IMPORT RESELLER" onclick="window.location='../resellerImport/add.php'" />
        </div>

		<?php if(mysql_num_rows($data) > 0) : ?>
			<div style="text-align:right">
				<input type="button" value="PRINT" onclick="window.open('print.php?print=1&keyword=<?php echo $keyword ?>')" />
				<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?print=1&keyword=<?php echo $keyword ?>')" />
			</div>					   
		<?php endif; ?>
	</div>   
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="15%">NAMA</th>
						<th align="center" width="17%">HANDPHONE</th>						
						<th align="center" width="17%">EMAIL</th>		
						<th align="center" width="">INFO</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = (1 + $record); ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td>
								<?php echo $val['name'] ?>
								<div style="font-size: 10px">Username : <?php echo $val['username'] ?></div>
								<div style="font-size: 10px">Tipe :   <b><?php echo $val['is_dropshipper'] == 1 ? 'Drophipper' : 'Reseller Stok'  ?></b></div>
							</td>
							<td align="center">
								<?php echo $val['country_code'] ?><?php echo $val['phone_number'] ?>
							</td>							
							<td align="center">
								<?php echo $val['email'] ?>
							</td>
							<td align="left">
								<div style="font-size: 10">Tgl Daftar: <?php echo $val['date_input_format'] ?></div>
								<div style="font-size: 10">Terakhir Login: <?php echo $val['last_login_format'] ?></div>																		
							</td>	
							<td align="center">
								<input type="button" value="PRODUK" onclick="window.location='../resellerProduk/index.php?resellerId=<?php echo $val['id'] ?>'" />
								<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>'" />
								<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>' : false" />																	
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>

			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$keyword,'dateFrom='.$_REQUEST['dateFrom'],'dateTo='.$_REQUEST['dateTo']));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';a
				?>
			</p>						
		</div>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
