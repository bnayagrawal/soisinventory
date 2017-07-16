<?php
	if ($_POST) {
		require_once('config.php');
		$course_name_s = $_POST["course_name"];
		$isAvailable = 0;
		
		$sql = mysqli_query($mysqli,"SELECT course_name FROM course WHERE course_name='". $course_name_s."'");

		while($row=mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
			$isAvailable = 1;
		}
		
		if($isAvailable)
			echo "false";
		else
			echo "true";
		
		mysqli_close($mysqli);
	}
?>