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
	 
	$target_dir = "../uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$errorMessage = "";
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	function goBack($message) {
		$_SESSION["comp_image_upload_result"] = "FAIL";
		$_SESSION["comp_image_upload_error_message"] = $message;
	}

	function ret(){
		header('location: ../admin_component.php');
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
		$_SESSION["comp_image_upload_result"] = "PASS";
    }
	else {
		$errorMessage = "An error occured!";
		goBack($errorMessage);
	}
	
	//FOR COMPONENT DETAILS
	$comp_name = $_POST["com_name"];
	$comp_year = $_POST["com_year"];
	$comp_qty = $_POST["com_qty"];
	$comp_ven = $_POST["com_ven"];
	$comp_des = $_POST["com_des"];
	
	require_once("config.php");
	
	if($_SESSION["comp_image_upload_result"] == "PASS")
		$sql = "INSERT INTO component (component_name, component_desc, vendor_id,component_image, component_year) VALUES ('$comp_name', '$comp_des', (select vendor_id from vendor where vendor_name = '$comp_ven') ,'$target_file','$comp_year')";
	else
		$sql = "INSERT INTO component (component_name, component_desc, vendor_id,component_image, component_year) VALUES ('$comp_name', '$comp_des', (select vendor_id from vendor where vendor_name = '$comp_ven') ,'uploads/comp_def.png','$comp_year')";
	
	if(mysqli_query($mysqli, $sql)) {
		for ($i = 0; $i < $comp_qty - 1 ; $i++)
			mysqli_query($mysqli, $sql);
		
		$_SESSION["comp_add_result"] = "PASS";
		ret();
	}
	else {
		$_SESSION["comp_add_result"] = "FAIL";
		ret();
	}
 
	// Close connection
	mysqli_close($mysqli);
?>