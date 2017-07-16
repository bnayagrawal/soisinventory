<?php
	session_start();
	require_once('config.php');	
	
	if(isset($_FILES["CSVfile"]["name"]))
		$file_name = basename($_FILES["CSVfile"]["name"]);
	else
		goBack("No file was recieved :(");
	
	$file = "../temp/" . $file_name;
	$valid_file = true;
	$error_message = "";
	
	$records_added = 0;
	$records_skipped = 0;
	$records_invalid = 0;
	
	if(isset($_POST["submit"])) {
		if ($_FILES["CSVfile"]["size"] > 100000) {
			$valid_file = false;
			$error_message = "File size too large. It must be less than 1mb.";
		}
		
		$file_parts = pathinfo($file);	
		if($file_parts['extension'] != "csv") {
			$valid_file = false;
			$error_message = "File is not a csv file.";
		}
		
		if($valid_file)
			parseCSV($file);
		else
			goBack($error_message);
	}
	
	function parseCSV($file) {
		$parsed = false;
		
		if(file_exists("not_imported.txt"))
			unlink("not_imported.txt");
		
		if(move_uploaded_file($_FILES["CSVfile"]["tmp_name"], $file)) {
			if(($handle = fopen("{$file}", "r")) !== FALSE) {
				$user = array("user_name" => "","password" => "","full_name" => "","email" => "","phone" => "","user_type" => "","batch" => "","course" => "","image" => "uploads/userimage/user.png");
				$tmp_array = array();
				$invalid_row = false;
				$rows = 1;
				
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					for ($c=0; $c < $num; $c++) {
						$tmp_array[$c] = $data[$c];
						
						if(strlen($data[$c]) == 0) {
							$invalid_row = true;
							break;
						}
					}
					
					if(!$invalid_row) {
						$user['user_name'] = $tmp_array[0];
						$user['password'] = $tmp_array[1];
						$user['full_name'] = $tmp_array[2];
						$user['email'] = $tmp_array[3];
						$user['phone'] = $tmp_array[4];
						$user['user_type'] = $tmp_array[5];
						$user['batch'] = $tmp_array[6];
						$user['course'] = $tmp_array[7];
						$user['image'] = "uploads/userimage/user.png";
						insertRecord($user);
					}
					else {
						$invalid_row = false;
						$records_skipped++;
						continue;
					}
				}
				
				$parsed = true;
				fclose($handle);
			} else {
				goBack("There was an error handling your csv file :(");
			}
		} 
		else
			goBack("There was a problem occured handling the file in the server :(");
			
		if($parsed) {
			global $records_added,$records_invalid,$records_skipped;
			unlink($file);
			$_SESSION["parse_result"] = "success";
			
			if($records_invalid > 0 || $records_skipped > 0)
				$_SESSION["parse_details"] = "records added = {$records_added} | records invalid = {$records_invalid} | records skipped = {$records_skipped}<br><br><a href='database/not_imported.txt' download>click here</a> to download the list of unimported users.";
			else
				$_SESSION["parse_details"] = "{$records_added} records added";
			
			header('location: ../admin_user.php');
		}
		else {
			goBack("Your file was not parsed :(");
		}
	}
	
	function insertRecord($user) {
		global $mysqli;
		global $records_added;
		global $records_invalid;
		global $records_skipped;
		
		$query_one = "INSERT INTO user(user_username,user_password,user_name,user_image,user_email,user_phone) VALUES ('{$user['user_name']}','{$user['password']}','{$user['full_name']}','{$user['image']}','{$user['email']}','{$user['phone']}')";
		
		if($user['user_type'] == "student") {
			$course_id = -99999;

			$cquery = mysqli_query($mysqli, "SELECT course_id from course WHERE course_name='" . $user['course'] . "'");
			while($row=mysqli_fetch_array($cquery,MYSQLI_ASSOC)) {
				$course_id = $row["course_id"];
			}
			
			if($course_id == -99999) {
				$records_invalid++;
				return;
			}
			
			$query_two = "INSERT INTO student(student_username,course_id,batch) VALUES ('{$user['user_name']}',$course_id,{$user['batch']})";
		}
		else
			$query_two = "INSERT INTO faculty(faculty_username) VALUES ('{$user['user_name']}')";
		
		if(mysqli_query($mysqli, $query_one)) {
			if(mysqli_query($mysqli, $query_two))
				$records_added++;
			else {
				$records_invalid++;
				faultyRecord($user,"invalid course");
			}
		} else {
			$records_invalid++;
			faultyRecord($user,"invalid user");
		}
	}

	function faultyRecord($user,$type) {
		$fp = fopen("not_imported.txt","a");
		if($fp == FALSE)
			return;
		
		$line = $type . "........." . PHP_EOL . $user['user_name'] . " | " . $user['password'] . " | " . $user['full_name'] . " | " . $user['email'] . " | " . $user['phone'] . " | " . $user['user_type'] . " | " . $user['batch'] . " | " . $user['course'] . PHP_EOL . PHP_EOL ;
		
		fwrite($fp,$line);
		fclose($fp);
	}
	
	function goBack($error_message) {
		unlink($file);
		$_SESSION["parse_result"] = "failed";
		$_SESSION["csv_parse_error"] = $error_message;
		header('location: ../admin_user.php');
	}
?>