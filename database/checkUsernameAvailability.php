<?php
	$username = $_POST["user_name"];
	$available = 0;
	require_once('config.php');

	$info = mysqli_query($mysqli, "select user_username from user where user_username='" . $username . "'");

	while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
		$available = 1;
	}
	
	if($available == 0)
		echo "available";
	else
		echo "not available";
?>