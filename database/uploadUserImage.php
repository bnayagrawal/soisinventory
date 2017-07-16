<?php
	session_start();
	$target_dir = "../uploads/userimage/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$errorMessage = "";
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$user_name = $_SESSION["new_user_name"];

	function goBack($message) {
		$_SESSION["image_upload_result"] = "FAIL";
		$_SESSION["upload_error_message"] = $message;
		header("location: ../admin_user.php");
	}

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check == false) {
			$errorMessage = "File is not an image.";
			goBack($errorMessage);
		}
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		$errorMessage = "Sorry, file already exists.";
		goBack($errorMessage);
	}
	
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 3145728) {
		$errorMessage = "Sorry, your file is too large. File size must be less than 3mb.";
		goBack($errorMessage);
	}
	
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" && $imageFileType != "bmp") {
		$errorMessage = "Sorry, only JPG, JPEG, BMP, PNG & GIF files are allowed.";
		goBack($errorMessage);
	}

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		require_once('config.php');
		
		$info = mysqli_query($mysqli, "UPDATE user set user_image='" . $target_file ."' WHERE user_username='" . $user_name . "'");
		
		mysqli_close($mysqli);
		
		unset($_SESSION["new_user_name"]);
		$_SESSION["image_upload_result"] = "PASS";
		header("location: ../admin_user.php");
    }
?>