<?php
if ($_POST) {
	session_start();
	require_once('config.php');
	 
	// Escape user inputs for security
	$theme = mysqli_real_escape_string($mysqli, $_POST['theme_color']);
	 
	// Attempt update query execution
	$sql = "UPDATE user SET theme='$theme";
	
	if(mysqli_query($mysqli, $sql))
		echo "true";
	else
		echo "false";
	 
	// Close connection
	mysqli_close($mysqli);
}
?>