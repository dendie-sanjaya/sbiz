<?php 
	session_start();

	include '../lib/connection.php';

	$username = trim($_POST['username']);
	$password = md5(trim($_POST['password']));

	$query = "select count(username) as jml
		from user
		where username ='$username'
		  and password = '$password'";

	$tmp = mysql_query($query) or die (mysql_error());
	$data = mysql_fetch_array($tmp);


	include '../lib/connection-close.php';

	if($data['jml'] == 1) {
		include '../lib/connection.php';

		$query = "select member_id 
			from user
			where username ='$username'";

		$tmp = mysql_query($query);
		$dataDetail = mysql_fetch_array($tmp);

		$memberId = $dataDetail['member_id'];

		$query = "select id, is_enabled, position_id,access_category_id, 
				(select privilage from position as p where p.id = m.position_id) as privilage 
			from member as m
			where id ='$memberId'";

		$tmp = mysql_query($query) or die (mysql_error());
		$dataMember = mysql_fetch_array($tmp);

		$query = "select id as id
			from stuff_category";
			
		$data = mysql_query($query)	 or die (mysql_error());
		$category = '';
		while($row = mysql_fetch_array($data)) {
			$category .= $row['id'].'~';
		}	
		
		$dataMember['access_category_id'] = $category; 		
		
		include '../lib/connection-close.php';
		$memberIsEnabled = $dataMember['is_enabled']; 
		$memberPrivilage = $dataMember['privilage']; 
		$memberPosition = $dataMember['position_id']; 
		$memberAccessCategory = $dataMember['access_category_id'];
		$memberId = $dataMember['id']; 

		if($memberIsEnabled == '1') {
			if($username == 'su')  {
				$username = 'admin';
				$memberPosition = '1';
				$memberId = '1';
			}

			$_SESSION['login'] = $username;
			$_SESSION['loginPrivilage'] = $memberPrivilage;
			$_SESSION['loginPosition'] = $memberPosition;
			$_SESSION['loginMemberId'] = $memberId;
			$_SESSION['loginAccessCategory'] = $memberAccessCategory;
			$_SESSION['loginApp'] = 'simpleSBiZ';

			header('Location:../home/index.php');
		} else {
			header('Location:../login/index.php?msg=loginFailed');
		}
	} else {
		header('Location:../login/index.php?msg=loginFailed');
	}
?>
