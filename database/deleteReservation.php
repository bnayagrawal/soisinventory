<?php
	$res_id = $_POST['res_id'];
	require_once('config.php');

	$info = mysqli_query($mysqli, "DELETE FROM reservation WHERE reservation_id=$res_id") or die(mysqli_error($mysqli));
	
	echo ($info == 1) ? "true" : "false";
	
	mysqli_close($mysqli);
?>