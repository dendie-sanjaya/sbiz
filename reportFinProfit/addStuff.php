<?php ob_start(); ?>
	<?php include 'addStuffRead.php' ?>
	<form action="addStuffSave.php" method="get">
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
		<input type="hidden" name="year" value="<?php echo $_REQUEST['year'] ?>" />
		<input type="hidden" name="jumpTo" value="<?php echo $_REQUEST['jumpTo'] ?>" />			
		<table width="100%">
			<tr>
				<td width="15%"><b>ITEM</b></td>
				<td>
					<select name="itemRevenueExpenses" style="width:220px">
						<?php while($val = mysql_fetch_array($dataCategory)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select> &nbsp;
					<input type="submit" value="TAMBAH" />						
				</td>
		</table>
	</form>
	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>
<?php include '../template/popupConfirm.php' ?>	
