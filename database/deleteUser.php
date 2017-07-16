<?php
	$user_name = $_POST['user_name'];
	require_once('config.php');

	$q = mysqli_query($mysqli,"SELECT user_image FROM user WHERE user.user_username = '$user_name'");
	while($row=mysqli_fetch_array($q,MYSQLI_ASSOC)) {
		$file = $row['user_image'];
	}

	if($file != "uploads/userimage/user.png")
		if(file_exists($file))
			unlink($file);
	
	$info = mysqli_query($mysqli, "DELETE FROM user WHERE user.user_username ='$user_name'") or die(mysqli_error($mysqli));
	if($_POST['user_type'] == "student")
		$info += mysqli_query($mysqli, "DELETE FROM student WHERE student_username ='$user_name'") or die(mysqli_error($mysqli));
	else
		$info += mysqli_query($mysqli, "DELETE FROM faculty WHERE faculty_username ='$user_name'") or die(mysqli_error($mysqli));

	if($info == 2)
		echo "deleted successfully";
	elseif($info == 1)
		echo "deleted partially";
	else
		echo "deletion failed";

	mysqli_close($mysqli);
?>