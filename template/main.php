<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Simple Biz :: Administrator</title>

		<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/style.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery	-ui.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/nav.css" />
		<script type="text/javascript" src="../asset/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../asset/js/jquery-ui.min.js"></script>

		<script type="text/javascript" src="../asset/js/ddsmoothmenu.js"></script>
		<script type="text/javascript" src="../asset/js/simple.money.format.js"></script>	
	<head>	
	<body>
		</select>
		<div id="content" style="width:1050px;">
			<div id="body">
			    <?php include '../menu/index.php' ?>
				<?php echo $templateContent ?>
			</div>
		</div>
	<footer>
		<center>
			<div id="footer" style="width:980px">
				<hr />
				<table width="100%">
					<td width="50%">
					</td>
					<td align="right">
						Powered By <b>Simple Biz 1.0.0</b><br />
						<b>@DS Teknologi, Dendie [087899509023]</b>
					</td>
				<table>		
			</div>
		</center>
	</footer>

	<script type="text/javascript">
		function toggleCheckBox(source) {
		  checkboxes = document.getElementsByName('salesOrderId[]');
		  for(var i=0, n=checkboxes.length;i<n;i++) {
		    checkboxes[i].checked = source.checked;
		  }
		}		
	</script>		
</html>