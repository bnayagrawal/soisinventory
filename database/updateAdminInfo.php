<?php
if ($_POST) {
	session_start();
	require_once('config.php');
	
	$theme = $_POST["theme"];
	$fullname = $_POST["user_name"];
	$username = $_POST["user_username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	
	// Attempt update query execution
	$sql = "UPDATE admin SET admin_username='$username',admin_name='$fullname',admin_password='$password',admin_email='$email',theme='$theme'";
	
	if(mysqli_query($mysqli, $sql)){
		header('location: ../admin_component.php');
	} else{
		header('location: ../admin_component.php');
	}
	 
	// Close connection
	mysqli_close($mysqli);
}
?>