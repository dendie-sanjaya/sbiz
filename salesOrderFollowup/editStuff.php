<?php ob_start(); ?>
	<?php include 'editStuffRead.php'?>
		<hr />
		<form action="editStuffSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $id ?>" />	
			<table width="">
				<tr>
					<td  valign="center" width="100">QUANTITY</td>
					<td>
						<input name="totalHidden" type="hidden" value="<?php echo $data['qty'] ?>" />
						<input id="total" onkeyup="isNumberKey(<?php echo ($data['qty'] + $sisaStock) ?>)" type="number" name="total"  min="1" max="<?php echo($data['qty'] + $sisaStock)  ?>"  size="10" type="text" value="<?php echo $data['qty'] ?>" /><br />
						<small style="font-size:9px">Sisa Stok : <?php echo $sisaStock  ?></small>
					</td>
				</tr>
			</table>
			<hr />
			<input type="submit" value="SIMPAN"/>
		</form>

	<script>
		function isNumberKey(max) {
			var p = document.getElementById('total').value;
			
			if(p > max) {
				document.getElementById('total').value = max;
			}			
			
			if(p < 0) {
				document.getElementById('total').value = 0;
			}
			
		}
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>
