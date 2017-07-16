<?php
	//Returns the image path for the given username in JSON format
	$username = $_REQUEST["username"];
	$user_password = $_REQUEST["user_password"];
	$user_name = "";
	$image_path = "";
	$theme = "theme-blue";
	
	require_once('config.php');
	
	if($username == "admin") {
		$info = mysqli_query($mysqli, "select admin_image,admin_name from admin WHERE admin_password='" . $user_password ."'");
		
		while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
			$image_path = $row['admin_image'];
			$user_name = $row['admin_name'];
		}
		
		echo '{ "path" : "'. $image_path . '", "username" : "'.$user_name .'" }';
	}
	else {
		$info = mysqli_query($mysqli, "select user_image,user_name,theme from user where user_username='" . $username .  "' AND user_password='" . $user_password ."'");

		while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
			$image_path = $row['user_image'];
			$user_name = $row['user_name'];
			$theme = $row['theme'];
		}
		
		echo '{ "path" : "'. $image_path . '", "username" : "'.$user_name .'", "theme" : "'. $theme . '" }';
	}
	//echo $image_path;
?>
