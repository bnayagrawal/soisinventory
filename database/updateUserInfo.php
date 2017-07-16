<?php
if ($_POST) {
	session_start();
	require_once('config.php');
	
	$cur_user = $_SESSION['userName'];
	
	$theme = $_POST["theme"];
	$fullname = $_POST["user_name"];
	$username = $_POST["user_username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	
	// Attempt update query execution
	$sql = "UPDATE user SET user_username='$username',user_name='$fullname',user_password='$password',user_email='$email',theme='$theme' WHERE user_username='$cur_user'";
	
	if(mysqli_query($mysqli, $sql)){
		header('location: ../user/user_component.php');
	} else{
		header('location: ../user/user_component.php');
	}
	 
	// Close connection
	mysqli_close($mysqli);
}
?>