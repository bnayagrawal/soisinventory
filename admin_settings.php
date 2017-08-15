<?php
	session_start();
	if(isset($_SESSION['userName']))
	{
		$current_user = $_SESSION['userName'];
		$theme = $_SESSION["theme"];
		if($current_user != "admin") {
			echo "<script>
					alert('You are not allowed to access this page! Please login again.');
					window.location.href='../logout.php';
				  </script>
			";
		}
	} 
	else
	{
		echo "<script>
				alert('You need to login to access this page.');
				window.location.href='logout.php';
			  </script>
		";
	 }
	
	$username = "";
	$fullname = "";
	$password = "";
	$email = "";
	
	require_once('database/config.php'); 
	$info = mysqli_query($mysqli, "select * from admin");
					
	while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
		$username= $row['admin_username'];
		$fullname= $row['admin_name'];
		$password= $row['admin_password'];
		$email= $row['admin_email'];
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>SOIS Inventory</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#00acc1" id="url-theme">
	  
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="assets/materialize/css/materialize.min.css"  media="screen,projection"/>
		<link href="assets/css/settings_style.css" rel="stylesheet" type="text/css" /> 
		<link rel="stylesheet" href="assets/css/form_theme_pink.css" id="form-element-theme">
	</head>
	<body class="cyan darken-1">
		<section>
			<div class="row">
				<div class="col s12 m4 l4 offset-l4 valign-wrapper">
					<div id="settings-panel" class="z-depth-5 white valign">
						<a href="admin_component.php" id="sois-heading" class="center-align"> SOIS <span class="pink-text text-darken-1"> INVENTORY </span></a>
						<div id="profile-image-wrapper">
							<div id="profile-image-container" class="z-depth-1">
								<img class="circle responsive-img" id="profile-image" src="<?php require_once('database/config.php'); 
										$info = mysqli_query($mysqli, "select admin_image from admin");
					
										while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
											$image_path = $row['admin_image'];
										}
														
										if(isset($image_path))
											echo $image_path;
										else
											echo "uploads/userimage/user.png";
								?>">
							</div>
						</div>
						<form class="col s12" id="form-user" action="database/updateAdminInfo.php" method="POST" enctype="multipart/form-data">
							<div class="row">
								<div class="input-field col s6">
									<i class="material-icons prefix">perm_identity</i>
									<input id="user_name" name="user_username" type="text" class="validate add-user-input" value="<?php echo $username; ?>" required autocomplete="off" maxlength="25" length="25" onblur="checkUserName(this.value)">
									<label for="user_name">User Name</label>
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix">lock_outline</i>
									<input id="password" name="password" type="password" maxlength="15" length="15" class="validate add-user-input" value="<?php echo $password; ?>" required autocomplete="off">
									<label for="password">Password</label>
								</div>
								<div class="input-field col s12">
									<i class="material-icons prefix">account_circle</i>
									<input id="full_name" name="user_name" type="text" class="validate add-user-input" value="<?php echo $fullname; ?>" required autocomplete="off" maxlength="50" length="50">
									<label for="full_name">Full Name</label>
								</div>
								<div class="input-field col s12">
									<i class="material-icons prefix">mail_outline</i>
									<input id="email" name="email" type="email" class="validate add-user-input" value="<?php echo $email; ?>" required autocomplete="off">
									<label for="email">Email</label>
								</div>								
								<div class="input-field col s12">
									<i class="material-icons prefix">invert_colors</i>
									<select name="theme">
										<option value="blue" selected>blue</option>
										<option value="red">red</option>
										<option value="green">green</option>
										<option value="grey">grey</option>
										<option value="yellow">yellow</option>
										<option value="pink">pink</option>
										<option value="orange">orange</option>
										<option value="indigo">indigo</option>
										<option value="teal">teal</option>
										<option value="cyan">cyan</option>
										<option value="purple">purple</option>
										<option value="brown">brown</option>
									</select>
								</div>
							</div>
							<div id="add-user-modal-footer">
								<p class="red-text"> All fields are mandatory* </p>
								<button class="btn waves-effect waves-light pink darken-1" type="submit" name="submit" style="float:right;">UPDATE
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<!-- USER ID/NAME NOT AVAIALABLE MODAL -->
			<div id="modal-user-name-na" class="modal">
				<div class="modal-content">
					<h4>WAIT</h4>
					<p>User names are unique. The user name you entered is already present in our database, please choose a different user name.</p>
				</div>
				<div class="modal-footer">
					<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">CLOSE</a>
				</div>
			</div>
		</section>
		<!-- SCRIPTS -->
		<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/materialize/js/materialize.min.js"></script>
		<script>
			//modal options
			$('.modal').modal({
				dismissible: true, // Modal can be dismissed by clicking outside of the modal
				opacity: .5, // Opacity of modal background
				in_duration: 300, // Transition in duration
				out_duration: 200, // Transition out duration
				starting_top: '4%', // Starting top style attribute
				ending_top: '10%', // Ending top style attribute
				ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
					console.log(trigger);
			  },
			  complete: function() {} // Callback for Modal close
			});
			
			$('select').material_select();
			
			function checkUserName(user_name) {
				var xhttp;
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if(this.responseText == "available")
							return;
						else{
							$('#modal-user-name-na').modal('open');
							$("#user_name").val("");
						}
					}
				}
				xhttp.open("POST", "database/checkUsernameAvailability.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("user_name=" + user_name);			
			}
		</script>
	</body>
</html>
