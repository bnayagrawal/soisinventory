<?php
	//outputs some user details in JSON format
	//for search user
	$search_by = $_POST["searchBy"];
	$search_string = $_POST["searchString"];
	$user_type = $_POST["searchUserType"];
	$record_count = 0;
	$course_name = null;
	$isFaculty = false;
	$isStudent = false;
	
	echo '{"user_info":[';
	
	require_once('config.php');
	
	$exc = mysqli_query($mysqli,"SELECT user_name,user_phone,user_email,user_image,user_username FROM user WHERE {$search_by} LIKE '%{$search_string}%'");
	
	while($row=mysqli_fetch_array($exc,MYSQLI_ASSOC)) {
		if($user_type == "student") {
			$verify = mysqli_query($mysqli,"SELECT faculty_username FROM faculty WHERE faculty_username='".$row['user_username']."'");
			while($vrow=mysqli_fetch_array($verify,MYSQLI_ASSOC)) {
				$isFaculty = true;
			}
			
			if($isFaculty) {
				$isFaculty = false;
				continue;
			}
			
			if($record_count != 0)
				echo ",";
		
			$exc2 = mysqli_query($mysqli,"SELECT course_name FROM course,student WHERE student.student_username='".$row['user_username']."' AND course.course_id=student.course_id");
			while($row2=mysqli_fetch_array($exc2,MYSQLI_ASSOC)){
				$course_name = $row2["course_name"];
			}
			echo '{"user_name":"' . $row['user_name'] . '","user_username":"' . $row['user_username'] .'","user_phone":"' . $row['user_phone'] .'","course_name":"' . $course_name .'","user_email":"' . $row['user_email'] .'","user_image":"' . $row['user_image'].'"}';
		}
		else {
			$verify = mysqli_query($mysqli,"SELECT student_username FROM student WHERE student_username='".$row['user_username']."'");
			while($vrow=mysqli_fetch_array($verify,MYSQLI_ASSOC)) {
				$isStudent = true;
			}
			
			if($isStudent) {
				$isStudent = false;
				continue;
			}
			
			if($record_count != 0)
				echo ",";
		
			echo '{"user_name":"' . $row['user_name'] . '","user_username":"' . $row['user_username'] .'","user_phone":"' . $row['user_phone'] .'","user_email":"' . $row['user_email'] .'","user_image":"' . $row['user_image'].'"}';
		}
		$record_count++;
	}

	echo "]}";
	mysqli_close($mysqli);
?>