<?php
	//outputs some user details in JSON format
	//requies course_id
	$course_id = $_POST["course_id"];
	$batch = $_POST["batch_year"];
	$record_count = 0;
	
	echo '{"user_info":[';
	
	require_once('config.php');
	$exc = mysqli_query($mysqli,'SELECT user_name,user_phone,user_email,user_image,user_username FROM user WHERE user_username in (SELECT student_username FROM student WHERE course_id='.$course_id.' AND batch='.$batch.')');
	
	while($row=mysqli_fetch_array($exc,MYSQLI_ASSOC)) {
		if($record_count != 0)
			echo ",";
		echo '{"user_name":"' . $row['user_name'] . '","user_username":"' . $row['user_username'] .'","user_phone":"' . $row['user_phone'] .'","user_email":"' . $row['user_email'] .'","user_image":"' . $row['user_image'].'"}';
		$record_count++;		
	}

	echo "]}";
	mysqli_close($mysqli);
?>