<?php
if ($_POST) {
	session_start();
	require_once('config.php');
	 
	// Escape user inputs for security
	$vendor_id = mysqli_real_escape_string($mysqli, $_POST['vendor_id']);
	$vendor_name = mysqli_real_escape_string($mysqli, $_POST['vendor_name']);
	$vendor_address = mysqli_real_escape_string($mysqli, $_POST['vendor_address']);
	$vendor_city = mysqli_real_escape_string($mysqli, $_POST['vendor_city']);
	$vendor_state = mysqli_real_escape_string($mysqli, $_POST['vendor_state']);
	$vendor_country = mysqli_real_escape_string($mysqli, $_POST['vendor_country']);

	 
	// Attempt update query execution
	$sql = "UPDATE vendor SET vendor_name='$vendor_name',vendor_address='$vendor_address',vendor_city='$vendor_city',vendor_state='$vendor_state',vendor_country='$vendor_country' WHERE vendor_id=$vendor_id";
	
	if(mysqli_query($mysqli, $sql)){
		$_SESSION["vendor-update-result"] = true;
		header('location: ../admin_vendor.php');
	} else{
		$_SESSION["vendor-update-result"] = false;
		header('location: ../admin_vendor.php');
	}
	 
	// Close connection
	mysqli_close($mysqli);
}
?>