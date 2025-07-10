<?php ob_start(); ?>
	<?php include 'addStuffRead.php' ?>
	<form action="deleteStuffSave.php" method="post">
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
		<input type="hidden" name="salesOrderDetilId" value="<?php echo $_REQUEST['salesOrderDetilId'] ?>" />
		<input type="hidden" name="qty" value="<?php echo $_REQUEST['qty'] ?>" />
		<center>
			<!-- <input type="button" value="CLOSE" onclick="tutup()" />
			<input type="button" value="Cancel" style="width:100px; height:30px" onclick="alert('hai')" />
			-->
			<input type="submit" value="OK, Saya yakin menghapus barang" style="font-weight:bold; width:280px; height:60px" />			
		<center>
	</form>
	
	<script>
		function tutup() {
			//window.parent.$('#externalSite').dialog('close');
			//window.parent.$('#externalSite').dialog('close');
			//$('#externalSite', window.parent.document);
			//alert('abc');
			//window.parent.closeModal('externalSite'); 
			//window.parent.$('#dialog').dialog( "close" );
			//var a = window.parent.document.getElementById('abc').value;
			//var a = window.parent.$('#abc').value;
			//alert(a);
			//alert('xxx');
			window.parent.closeModal(window.frameElement);			
		}	   
	</script>	   
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popupConfirm.php' ?>	
