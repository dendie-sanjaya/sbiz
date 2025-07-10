<?php ob_start(); ?>
	<?php include 'editRead.php' ?>


	<h1>INFORMASI UMUM</h1>
	<hr />

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<form action="editSave.php" method="post">
		<textarea id="description" name="description" style="height:400px; width:100%"><?php echo isset($_POST['description']) ? $_POST['name'] : $data['description'] ?></textarea>
		<hr />
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php'" />
	</form>


	<script type="text/javascript" src="../asset/vendor/tinymce/tinymce.min.js"></script>
	
	<script type="text/javascript">
     tinymce.init({
        selector: '#description',
		plugins: "link lists",
		menubar: "false",
		toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link | numlist bullist"
      });			
	</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
