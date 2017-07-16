<?php
	session_start();
	if(isset($_SESSION['userName']))
	{
		if($_SESSION['userName'] != "admin") {
			echo "<script>
					alert('You are not allowed to perform modification in the database! login as admin to procceed.');
					window.location.href='../logout.php';
				  </script>
			";
		}
	} 
	else
	{
		echo "<script>
				alert('Login as admin to perform modification in the database.');
				window.location.href='../logout.php';
			  </script>
		";
	}
	
if ($_POST) {
    require_once('config.php');

	$sql = "";
	$course_name = $_POST["course_name"];
	$old_course_name = "";
	
	//if update
	if(isset($_POST["course_option_post"])) {
		if($_POST["course_option_post"] == "update") {
			$old_course_name = $_POST["course_old"];
			$sql = "UPDATE course SET course_name='" . $course_name . "' WHERE course_name='" . $old_course_name . "'";
		}
		else 
			$sql = "INSERT INTO course (course_name) VALUES ('$course_name')";

		if(mysqli_query($mysqli, $sql))
			echo "success";
		else
			echo "failed";
	}
    mysqli_close($mysqli);
}
?>