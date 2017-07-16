<?php
	$db_username = 'root';
	$db_password = '';
	$db_name = 'soisinventory';
	$db_host = 'localhost:3306';
	$mysqli = new mysqli($db_host, $db_username, $db_password,$db_name);
	
	function secure($str,$sqlHandle)
	{
		$secured = strip_tags($str);
		$secured = htmlspecialchars($secured);
		$secured = mysqli_real_escape_string($sqlHandle,$secured);
		
		return $secured;
	}
?>