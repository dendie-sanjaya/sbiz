<?php
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=LAPORAN-RESELLER.xls");
?>

<?php include 'indexRead.php' ?>
<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>RESELLER</h1></center>
	<fieldset style="border:2px solid black">
		<legend style="font-size:14pt"><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td style="font-size:12pt" valign="top"  width="20%">KATA KUNCI</td>
				<td style="font-size:12pt" valign="top"  width="25%"> : <?php echo strlen($keyword) > 0 ? $keyword : 'SEMUA' ?></td>
			</tr>
		</table>
	</fieldset>
	<p></p>
	<br />
	<div id="tbl">
		<table width="100%" style="font-size:12pt; border:1px solid black" cellpadding="0" cellspacing="0">
			<thead>			
					<tr>
						<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="5%">NO</th>
						<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">NAMA</th>						
						<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">HANDPHONE</th>
						<th style="padding:5px; font-size:11pt; border:1px solid black" align="center" width="%">EMAIL</th>
					</tr>	
			</thead>
			<tbody>
				<?php $i=1; ?>
				<?php while($val = mysql_fetch_array($data)): ?>
					<tr >
						<td align="center" style="border:1px solid black"><?php echo $i ?></td>
						<td align="left"   style="padding:8px; border:1px solid black"><?php echo $val['name'] ?></td>
						<td align="center" style="border:1px solid black">&nbsp;<?php echo $val['country_code'] ?><?php echo str_replace('-','',$val['phone_number']) ?></td>
						<td align="center" style="border:1px solid black"><?php echo $val['email'] ?></td>
					</tr>						
				<?php $i++ ?>			
				<?php endwhile; ?>
			<tbody>
		</table>			
	</div>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
