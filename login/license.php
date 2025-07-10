<?php 
$masaaktif = "2017-12-15";
$sekarang = date("d-m-Y");
$masaberlaku = strtotime($masaaktif) - strtotime($sekarang);
?>

<?php if($masaberlaku/(24*60*60)<1): ?>
	<center>
		<div style="border:1px red solid; width:100%; padding:10px">
			<h1 style="color:red">Masa Trial Telah Habis, Silakan menghubungi <br />Vendor : 087899509023 - Bpk. Dendie</h1>
		</div>
	</center>	
	<?php exit; ?>
<?php elseif ($masaberlaku/(24*60*60)<8 ): ?>	
	<center>
		<div style="border:1px red solid; width:100%; padding:10px">
			<h1 style="color:red">Masa Trial Segera Habis, <?php echo $masaberlaku/(24*60*60) ?> Hari Lagi, silakan menghubungi <br />Vendor : 087899509023 - Bpk. Dendie</h1>
		</div>
	</center>			
<?php endif; ?>	
