<script>
	//var loc = parent.location + '?jumpTo=<?php echo $_REQUEST['jumpTo'] ?>';
	var loc = 'edit.php?jumpTo=<?php echo $_REQUEST['jumpTo'] ?>&id=<?php echo $id ?>';
	parent.location = loc;
	//parent.document.getElementById('frm').action = 'edit.php?jumpTo=DetailStuff';
	//parent.document.getElementById('frm').submit();
</script>
