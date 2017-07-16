<?php
if ($_POST) {
	session_start();
	require_once('config.php');
	 
	// Escape user inputs for security
	$vendor_name = mysqli_real_escape_string($mysqli, $_POST['vendor_name']);
	$vendor_address = mysqli_real_escape_string($mysqli, $_POST['vendor_address']);
	$vendor_city = mysqli_real_escape_string($mysqli, $_POST['vendor_city']);
	$vendor_state = mysqli_real_escape_string($mysqli, $_POST['vendor_state']);
	$vendor_country = mysqli_real_escape_string($mysqli, $_POST['vendor_country']);

	 
	// Attempt insert query execution
	$sql = "INSERT INTO vendor (vendor_name, vendor_address, vendor_city, vendor_state,vendor_country) VALUES ('$vendor_name', '$vendor_address', '$vendor_city', '$vendor_state','$vendor_country')";

	if(mysqli_query($mysqli, $sql)){
		$_SESSION["vendor-add-result"] = true;
		header('location: ../admin_vendor.php');
	} else{
		$_SESSION["vendor-add-result"] = false;
		header('location: ../admin_vendor.php');
	}
	 
	// Close connection
	mysqli_close($mysqli);
}
?>