<?php
session_start();
if($_POST) {
	$borrow_date = $_POST['borrowdate'];
	$for_days = $_POST['fordays'];
	$rid = rand(111111111, 999999999);
	
	require_once('config.php');
	
	$sql = "INSERT INTO reservation VALUES({$rid},'{$_SESSION['userName']}','" . date("Y-m-d") . "','{$borrow_date}',{$for_days},'{$_SESSION['component-to-reserve']}')";                          
	echo $sql;
	
	if(mysqli_query($mysqli, $sql)) {
		$_SESSION['reservation-result'] = "Reservation request of {$_SESSION['component-to-reserve']} for {$for_days} has been sent to the admin.";
		header("location: ../user/user_component.php");
	}
	else {
		$_SESSION['reservation-result'] = "Reservation of {$_SESSION['component-to-reserve']} failed :(";
		header("location: ../user/user_component.php");
	}
}
?>