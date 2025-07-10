<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />
	<center><h1>RESELLER</h1></center>
	<fieldset style="border:2px solid black">
		<legend style="font-size:14pt"><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td style="font-size:12pt" valign="top" width="20%">KATA KUNCI</td>
				<td style="font-size:12pt" valign="top">: <?php echo strlen($keyword) > 0 ? $keyword : 'SEMUA' ?></td>
			</tr>
		</table>
	</fieldset>
	<p></p>
	<br />
	<?php if(mysql_num_rows($data) < 1) : ?>
		<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
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
					<?php $totalBiayaKirim = 0; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr style="height: 0px">
							<td align="center" style="border:1px solid black"><?php echo $i ?></td>
							<td align="left"   style="padding:8px; border:1px solid black"><?php echo $val['name'] ?></td>
							<td align="center" style="border:1px solid black"><?php echo $val['country_code'] ?><?php echo str_replace('-','',$val['phone_number']) ?></td>
							<td align="center" style="border:1px solid black"><?php echo $val['email'] ?></td>
						</tr>						
					<?php $i++ ?>			
					<?php endwhile; ?>
				<tbody>
			</table>			
		</div>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
