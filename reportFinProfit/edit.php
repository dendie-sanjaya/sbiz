	<?php ob_start(); ?>
	<?php include 'editRead.php' ?>
	<h1>LAPORAN LABA RUGI</h1>
	<hr />
	<table width="100%">
	<tr>
		<td>
			<input type="button" value="KEMBALI" onclick="window.location='index.php'" />						
		</td>
		<td align="right">
			<input type="button" value="PRINT LAPORAN LABA RUGI" onclick="window.open('editPrint.php?id=<?php echo $dataHeader['id'] ?>')" />
		</td>
	</tr>	
	</table>
	<br />	
	<center style="font-size:30px; padding:5px"><b>LAPORAN LABA RUGI</b></center>
	<?php $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') ?>
	<center style="font-size:20px;  padding:5px"><b>PERIODE <?php echo strtoupper($month[$dataHeader['month'] - 1]) ?> <?php echo $dataHeader['year'] ?></b></center>
	<center style="font-size:15px;  padding:5px"><b><?php echo $dataHeader['name'] ?></b></center>
	<hr style="border:1px solid black" />
	<hr style="border:2px solid black" />
	<br />
	<?php $totalExpenses = 0 ?>
	<?php $totalExpensesPerhari  = 0 ?>
	<?php $totalExpensesPerbulan = 0 ?>
	<?php $totalRevenue = 0 ?>
	<table width="100%" border="0" cellpadding="5" cellspacing="5">
		<tr id="listRevenue">
			<td width="30%" style="font-size:18px; padding:5px" colspan="4"><b>PENDAPATAN</b></td>
			<td	>
				<span class="button">
					<input type="button" link="addStuff.php?id=<?php echo $id ?>&year=<?php echo $_REQUEST['year'] ?>&tipe=1&jumpTo=listRevenue&periode=1" data-title="TAMBAH ITEM PENDAPATAN" data-width="400" data-height="70"  style="width:220px" value="TAMBAH PENDAPATAN" />
				</span>			
			</td>
		</tr>
		<?php while($dataRevenue = mysql_fetch_array($revenue)): ?>	
		<tr>
			<td width="5%">
				<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='deleteStuff.php?id=<?php echo $id ?>&finProfitLossDetailId=<?php echo $dataRevenue['id'] ?>&year=<?php echo $_REQUEST['year'] ?>&jumpTo=listRevenue' : false" />
			</td>		
			<td width="53%" style="font-size:16px; padding:5px 5px 5px 25px " align="left">
				<?php echo $dataRevenue['name'] ?>
				<?php if($dataRevenue['fin_expenses_revenue_id'] == '13'): ?>
					<br /><small style="font-size:10px"><i><?php echo $dataRevenue['description'] ?></i></small>
				<?php endif; ?>
				<br /><a href="javascript:return false" onclick="confirm('Anda yakin akan melakukan aksi ini ?') ? window.location='updateStuff.php?id=<?php echo $id ?>&finProfitLossDetailId=<?php echo $dataRevenue['id'] ?>&year=<?php echo $_REQUEST['year'] ?>&jumpTo=listRevenue&finExpensesRevenueId=<?php echo $dataRevenue['fin_expenses_revenue_id']  ?>' : false" style="font-size:12px;">[ Cek / Update ]</a>

			</td>
			<td width="5%" width="%">&nbsp;</td>
			<td width="15%" style="font-size:16px;" align="right">
				<b><?php echo number_format($dataRevenue['nominal'],0,'','.')  ?></b>				
			</td>	
			<td width="20%">&nbsp;</td>
		</tr>
		<?php $totalRevenue = $totalRevenue + $dataRevenue['nominal'] ?>
		<?php endwhile; ?>	
		<tr>
			<td colspan="4" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
			<td style="font-size:16px;" align="right"><b><?php echo number_format($totalRevenue,0,'','.') ?></b></td>
		</tr>			

		<tr id="listExpenses">	
			<td width="30%" style="font-size:18px; padding:5px" colspan="4"><b>BIAYA KELOMPOK PERHARI</b></td>
			<td	>
				<span class="button">
					<input type="button" link="addStuff.php?id=<?php echo $id ?>&year=<?php echo $_REQUEST['year'] ?>&tipe=0&jumpTo=listExpenses&periode=0" data-title="TAMBAH ITEM BIAYA PERHARI" data-width="400" data-height="70"  style="width:220px" value="TAMBAH ITEM BIAYA PERHARI" />
				</span>			
			</td>
		</tr>
		<?php while($dataExpenses = mysql_fetch_array($expensesPerhari)): ?>	
		<tr>
			<td>
				<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='deleteStuff.php?id=<?php echo $id ?>&finProfitLossDetailId=<?php echo $dataExpenses['id'] ?>&year=<?php echo $_REQUEST['year'] ?>&jumpTo=listExpenses' : false" />
			</td>			
			<td colspan="2" style="font-size:16px; padding:5px 5px 5px 25px ">
				<?php echo $dataExpenses['name'] ?>
				<br /><a href="javascript:return false" onclick="confirm('Anda yakin akan melakukan aksi ini ?') ? window.location='updateStuff.php?id=<?php echo $id ?>&finProfitLossDetailId=<?php echo $dataExpenses['id'] ?>&year=<?php echo $_REQUEST['year'] ?>&jumpTo=listExpenses&finExpensesRevenueId=<?php echo $dataExpenses['fin_expenses_revenue_id']  ?>' : false" style="font-size:12px;">[ Cek / Update ]</a>
			</td>
			<td  style="font-size:16px;" align="right">
				<b><?php echo number_format($dataExpenses['nominal'],0,'','.') ?></b>
			</td>
			<td>&nbsp;</td>
		</tr>
		<?php $totalExpenses = ($totalExpenses + $dataExpenses['nominal']) ?>
		<?php $totalExpensesPerhari = ($totalExpensesPerhari + $dataExpenses['nominal']) ?>

		<?php endwhile; ?>	
		<tr>
			<td colspan="4" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
			<td style="font-size:16px;" align="right"><b><?php echo number_format($totalExpenses,0,'','.') ?></b></td>
		</tr>			

		<tr>
			<td colspan="5" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
		</tr>			

		<tr id="listExpenses">	
			<td width="30%" style="font-size:18px; padding:5px; margin-top:40px" colspan="4"><b>BIAYA KELOMPOK PERBULAN</b></td>
			<td	>
				<span class="button">
					<input type="button" link="addStuff.php?id=<?php echo $id ?>&year=<?php echo $_REQUEST['year'] ?>&tipe=0&jumpTo=listExpenses&periode=1" data-title="TAMBAH ITEM BIAYA PERBULAN" data-width="400" data-height="70"  style="width:220px" value="TAMBAH ITEM BIAYA PERBULAN" />
				</span>			
			</td>
		</tr>

		<?php while($dataExpenses = mysql_fetch_array($expensesPerbulan)): ?>	
			<tr>
				<td>
					<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='deleteStuff.php?id=<?php echo $id ?>&finProfitLossDetailId=<?php echo $dataExpenses['id'] ?>&year=<?php echo $_REQUEST['year'] ?>&jumpTo=listExpenses' : false" />
				</td>			
				<td colspan="2" style="font-size:16px; padding:5px 5px 5px 25px "><?php echo $dataExpenses['name'] ?>
					<br /><a href="javascript:return false" onclick="confirm('Anda yakin akan melakukan aksi ini ?') ? window.location='updateStuff.php?id=<?php echo $id ?>&finProfitLossDetailId=<?php echo $dataExpenses['id'] ?>&year=<?php echo $_REQUEST['year'] ?>&jumpTo=listExpenses&finExpensesRevenueId=<?php echo $dataExpenses['fin_expenses_revenue_id']  ?>' : false" style="font-size:12px;">[ Cek / Update ]</a>
				</td>
				<td  style="font-size:16px;" align="right">
					<b><?php echo number_format($dataExpenses['nominal'],0,'','.') ?></b>
				</td>
				<td>&nbsp;</td>
			</tr>
		<?php $totalExpenses = ($totalExpenses + $dataExpenses['nominal']) ?>
		<?php $totalExpensesPerbulan = ($totalExpensesPerbulan + $dataExpenses['nominal']) ?>
		<?php endwhile; ?>	

		<tr>
			<td colspan="4" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
			<td style="font-size:16px;" align="right"><b><?php echo number_format($totalExpensesPerbulan,0,'','.') ?></b></td>
		</tr>			

		<tr>
			<td colspan="5" style="font-size:16px; padding:5px 5px 5px 25px ">&nbsp;</td>
		</tr>			

		<tr>	
			<td style="font-size:18px" colspan="3"><b>LABA BERSIH <small>(Pendapatan - Biaya)</small></b></td>
			<td style="font-size:16px;" align="right">&nbsp;</td>
			<td style="font-size:20px" style="" align="right" >
				<?php $labaBersih = $totalRevenue-$totalExpenses ?>
				<?php if($labaBersih >= 0): ?>
					<b><?php echo number_format($totalRevenue-$totalExpenses,0,'','.') ?></b>
				<?php else: ?>
					<b style="color:red"><?php echo number_format($totalRevenue-$totalExpenses,0,'','.') ?></b>
				<?php endif; ?>	
			</td>				
		</tr>
	</table>
		
	<script type="text/javascript">
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
		
		function showPeriodePemesanan(p) {
			if(p == 0) { 
				document.getElementById('periodePemesananLabel').style.display='none';		
				document.getElementById('periodePemesananCmb').style.display='none';		
			} else {
				document.getElementById('periodePemesananLabel').style.display='';		
				document.getElementById('periodePemesananCmb').style.display='';		
			}
		}
		
		<?php if(isset($_REQUEST['jumpTo'])): ?>
			document.getElementById('<?php echo $_REQUEST['jumpTo'] ?>').scrollIntoView(true);			
		<?php endif; ?>		
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
