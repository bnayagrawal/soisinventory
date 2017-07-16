<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 8/16/2016
 * Time: 3:13 PM
 */
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
	 
require_once('config.php');

if(isset($_POST['submit'])) {
    $rdb_button = $_POST['radio'];

    if($rdb_button == 'student') {
        $user_name = $_POST['user_name'];

        $user_username = $_POST['user_username'];

        $student_course = $_POST['coursename'];

        $user_password = $_POST['password'];

        $user_image = "../uploads/userimage/user.png";
		
		$user_email = $_POST['email'];
		
		$user_phone = $_POST['phone'];
		
		$batch = $_POST['batch'];

        $query = "INSERT INTO user(user_username,user_password,user_name,user_image,user_email,user_phone) VALUES ('$user_username','$user_password','$user_name','$user_image','$user_email','$user_phone')";
		$s = mysqli_query($mysqli, $query);
		
		//get the id of course
		$c_id = 0;
		$m = mysqli_query($mysqli, "SELECT course_id from course WHERE course_name='".$student_course."'");
		while($row=mysqli_fetch_array($m,MYSQLI_ASSOC)) {
			$c_id = $row["course_id"];
		}
		
		$second = "INSERT INTO student(student_username,course_id,batch) VALUES ('$user_username',$c_id,$batch)";
        $l = mysqli_query($mysqli, $second);

		//For notifying
		if($s + $l == 2)
			$_SESSION["user_creation"] = "successful";
		elseif($s + $l == 1)
			$_SESSION["user_creation"] = "partial";
		else
			$_SESSION["user_creation"] = "failed";
		$_SESSION["new_user_name"] = $user_username;
		
    } else {
        $user_name = $_POST['user_name'];

        $user_username = $_POST['user_username'];

        $user_password = $_POST['password'];

        $user_image = "../uploads/userimage/user.png";

		$user_email = $_POST['email'];
		
		$user_phone = $_POST['phone'];
		
        $query = "INSERT INTO user(user_username,user_password,user_name,user_image,user_email,user_phone) VALUES ('$user_username','$user_password','$user_name','$user_image','$user_email','$user_phone')";
        $second = "INSERT INTO faculty(faculty_username) VALUES ('$user_username')";

        $s = mysqli_query($mysqli, $query);
        $l = mysqli_query($mysqli, $second);
		
		//For notifying
		if($s + $l == 2)
			$_SESSION["user_creation"] = "successful";
		elseif($s + $l == 1)
			$_SESSION["user_creation"] = "partial";
		else
			$_SESSION["user_creation"] = "failed";
		$_SESSION["new_user_name"] = $user_username;
    }
    // finish the work here...
    mysqli_close($mysqli);
    header('Location: ../admin_user.php');
}
?>