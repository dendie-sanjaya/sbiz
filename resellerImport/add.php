<?php include 'addRead.php' ?>

<?php ob_start(); ?>
	<h1>IMPORT RESELLER</h1>
	<hr />
	<?php if(isset($_GET['msg'])) : ?>
		<?php if(!empty($_SESSION['import_reseller_err_msg']) > 0): ?>
		 	<div class="error">
				Daftar Gagal import karena duplikat data (no hanphone atau email atau username sudah ada) <br />
			    <?php $no = 1 ?>
				<?php foreach($_SESSION['import_reseller_err_msg'] as $val): ?>
			    	<?php echo $no++ ?>.
					(<?php echo $val[0],', ',$val[1],', ',$val[2],', ',$val[3],', ',$val[4],', ',$val[5],', ',$val[6],', ',$val[7] ?>) <br />
				<?php endforeach; ?>	
			</div>		
		<?php endif; ?>	
	<?php endif ?>
	<form action="addSave.php" method="post" enctype="multipart/form-data">
		<table width="100%">
			<tr>
				<td  valign="top" width="40%">
					<fieldset style="height: 140px">
						<legend>Upload File Data Reseller</legend> 
						<input name="data_reseller" type="file" accept=".xls,.xlsx" value="" style="width:100% border: 1px solid black" required  /> 
						<div style="color:red"><?php echo isset($msgError['data_reseller']) ? $msgError['data_reseller'] : '' ?></div>						
					</fieldset>
				</td>
				<td valign="top">
					<fieldset style="height: 140px">
						<legend>Donwload Sample File Excel</legend> 		
						<p>Silakan download format/template file microsoft excel dengan extention *.xlsx untuk import file</p>
						<button style="color: green; width: 100%; padding: 5px; cursor: pointer" onclick="window.location='../asset/sample/sample-import-reseller.xlsx'">Download Sample Excel</button>
					</fieldset>	
				</td>	
			</tr>
			<tr>	
			   <td height="70px">
					<input type="submit" value="UPLOAD"/>
					<input type="button" value="KEMBALI" onclick="window.location='../reseller/index.php'" />			   	
			   </td>	
			<tr/>
		</table>
	</form>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
</table>
