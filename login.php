<?php
session_start();
include("database/config.php");
if(isset($_POST['login']))
{
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
	} else {
			$userName = secure($_POST['username'], $mysqli);
			$pass =  secure($_POST['password'], $mysqli);
			
			if($userName == "admin") {
				$q = "SELECT * FROM admin WHERE admin_username = '$userName' AND admin_password = '$pass'";
				
				if($res = $mysqli->query($q))
				{
					if($res->num_rows > 0)
					{
						while($row = $res->fetch_assoc()) {
							$theme = $row["theme"];
						}
						
						$_SESSION["error"] = 1;
						$_SESSION["LoggedIn"] = true;
						$_SESSION['userName'] = $userName;
						$_SESSION['userPassword'] = $pass;
						$_SESSION['theme'] = $theme;
						header("Location:admin_component.php");
						exit;
					}
					else
					{
						$_SESSION["error"] = "Incorrect username or password!";
						header("Location:index.php");
						exit;
					}
				} 			
			} else {
				$q = "SELECT * FROM user WHERE user_username = '$userName' AND
					user_password = '$pass'";
				if($res = $mysqli->query($q))
				{
					if($res->num_rows > 0)
					{
						while($row = $res->fetch_assoc()) {
							$user_full_name = $row["user_name"];
							$theme = $row["theme"];
						}
						
						$_SESSION["error"] = 1;
						$_SESSION["LoggedIn"] = true;
						$_SESSION['userName'] = $userName;
						$_SESSION['theme'] = $theme;
						
						if(isset($user_full_name))
							$_SESSION['userFullName'] = $user_full_name;
						else
							$_SESSION['userFullName'] = $userName;
						
						$_SESSION['userPassword'] = $pass;
						header("Location: user/user_component.php");
						exit;
					}
					else
					{
						$_SESSION["error"] = "Incorrect username or password!";
						header("Location:index.php");
						exit;
					}
				}
			}
	}

}
header("Location:index.php");
?>