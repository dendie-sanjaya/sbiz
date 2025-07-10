<?php ob_start(); ?>
	<?php include 'editStuffRead.php'?>
		<hr />
		<form action="editStuffSave.php" method="post">
			<input name="id" type="hidden" value="<?php echo $id ?>" />	
			<input name="finProfitLossDetailId" type="hidden" value="<?php echo $finProfitLossDetailId ?>" />
			<input name="jumpTo" type="hidden" value="<?php echo $_REQUEST['jumpTo'] ?>" />		
			<table width="">
				<tr>
					<td  valign="center" width="100">JUMLAH</td>
					<td>
						<input id="total" onkeyup="" type="text" name="nominal" size="15" style="text-align:center" value="<?php echo $nominal  ?>" />
					</td>
				</tr>
			</table>
			<hr />
			<input type="submit" value="SIMPAN"/>
		</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popup.php' ?>
