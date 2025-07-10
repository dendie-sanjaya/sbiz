<?php ob_start(); ?>
	<?php include 'detailRead.php' ?>
	<br />

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<?php if(!isset($_REQUEST['dateFrom'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('filterData') ?></h3>
		</div>		
	<?php else: ?>	
		<?php if(mysql_num_rows($data) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<div id="tbl">
				<table width="100%" id="tbl_data">
					<thead>
						<th style="font-size:12px; font-weight:bold" align="center">NO</th>
						<th style="font-size:12px; font-weight:bold" align="center" width="100">NO SO</th>
						<th style="font-size:12px; font-weight:bold" align="center" width="150">TGL PENJUALAN</th>
						<th style="font-size:12px; font-weight:bold" align="center">NAMA PEMBELI</th>
						<th style="font-size:12px; font-weight:bold" align="center">NILAI TRANSAKSI</th>
						<th style="font-size:12px; font-weight:bold" align="center"></th>
					</thead>
					<?php $j=1 ?>
					<tbody>
					<?php $jumlah = 0 ?>
					<?php while($rowdataSub = mysql_fetch_array($data)): ?>
						<tr id="<?php echo $rowdataSub['id'] ?>">
							<td style="font-size:12px"  align="center"><?php echo $j ?></td>
							<td style="font-size:12px"  align="center"><a target="_blank" href="../salesOrder/print.php?id=<?php echo $rowdataSub['id'] ?>"><?php echo $rowdataSub['no_order'] ?></a></td>
							<td style="font-size:12px"  align="center">
								<?php echo $rowdataSub['date_order_frm'] ?>
								<div style="font-size: 10px; font-weight: bold">Sales: <?php echo $rowdataSub['sales_name'] ?></div>		
							</td>
							<td style="font-size:12px"  align="center">
								<?php echo $rowdataSub['name'] ?> <br /><small><?php echo $rowdataSub['phone'] ?></small></td>
							<td style="font-size:12px"  align="center"><b><?php echo number_format($rowdataSub['total_nilai'],0,0,'.') ?></b></td>
							<td style="font-size:12px"  align="center">
								<input type="button" name="" value="HAPUS" onclick="del(<?php echo $rowdataSub['id'] ?>,<?php echo $rowdataSub['no_order'] ?>)"  >
							</td>
						</tr>	
						<?php $jumlah = $jumlah + $rowdataSub['total_nilai'] ?>
						<?php $j++ ?>	
					<?php endwhile; ?>	
						<th colspan="4" align="center">TOTAL</th>
						<th style="font-size:12px; font-weight:bold" align="center"><?php echo number_format($jumlah,0,0,'.') ?></th>	
						<th>&nbsp;</th>					
					</tbody>									
				</table>	
			</div>
		<?php endif; ?>
	<?php endif; ?>	
	
	<script type="text/javascript">
		function del(id,order) {
			if(confirm("Anda yakin, akan hapus transaksi no sales order "+ order +", \nkarena terindikasi duplikat ?")) {
				$.get("../salesOrder/delete.php?id="+id, function(data, status){
				    if(status == 'success') {
				    	//window.alert('Data transaksi berhasil di hapus!');
						//location.reload();
						window.location  = window.location.href + '&msg=deleteSuccess' 
				    } else {
				    	window.alert('Gagal hapus transaksi, silakan coba kembali');
				    }
				});				
			}
		}
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>
