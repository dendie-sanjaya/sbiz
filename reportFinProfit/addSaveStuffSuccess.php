<script>
	//var loc = parent.location + '?jumpTo=DetailStuff';
	//var loc = 'edit.php?jumpTo=DetailStuff&id=<?php echo $id ?>'
	//parent.location = loc;
	//parent.document.getElementById('frm').action = 'edit.php?jumpTo=DetailStuff';
	//parent.document.getElementById('frm').submit();
	var loc = 'edit.php?jumpTo=<?php echo $_REQUEST['jumpTo'] ?>&id=<?php echo $id ?>&year=<?php echo $year ?>';
	parent.location = loc;	
</script>
