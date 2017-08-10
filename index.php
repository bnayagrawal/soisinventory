<?php
session_start();
if(isset($_SESSION["error"]) == false)
	$_SESSION["error"] = 1;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#00acc1" id="url-theme">
        <title>SOIS Inventory Login Form</title>

        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/index_style.css">
		<link rel="stylesheet" href="assets/css/form_theme_cyan.css" id="form-element-theme">
		
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="assets/materialize/css/materialize.min.css"  media="screen,projection"/>
		
	  
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

		<!--<link rel="icon" href="/assets/ico/favicon.png" /> -->
    </head>

    <body>
        <!-- Top content -->
        <div class="content">
            <div class="row valign-wrapper theme-cyan cyan darken-1 topcontent">
                <div class="container">
                    <h1 class="white-text center-align" id="mitheading">SOIS <span style="font-weight:300;">inventory</span></h1>
					<p class="white-text center-align message" id="userMessage"></p>
                </div>
			</div>
			<div class="container middlecontent">
				<div class="row valign-wrapper">
					<div class="col s12 m6 z-depth-4 valign" id="formcontainer" style="margin:auto;border-radius:4px;padding:0px;">
						<form role="form" action="login.php" method="post" class="loginform">
							<div id="profileContainer" class="z-depth-1">
								<img class="responsive-img profile-image" id="profileImage" src="assets/ico/people_icon.png">
							</div>
							<div class="row" style="margin-bottom:0px !important;">
								<div class="input-field col s12">
									<i class="material-icons prefix">account_circle</i>
									<input id="username" name="username" required="required" type="text" class="validate" onkeyup="getProfileImage();">
									<label for="form-username" class="left-align">Username</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix">lock</i>
									<input id="password" name="password" required="required" type="password" class="validate" onkeyup="getProfileImage();">
									<label for="form-password" class="left-align">Password</label>
								</div>
							</div>
							<?php
								if(isset($_SESSION["LoggedIn"])) {
									if($_SESSION["LoggedIn"] == true) {
										session_unset(); 
										session_destroy();
									}
								}
								if(isset($_SESSION["error"]))
									if($_SESSION["error"] != 1)
										echo "<p id='error_message' style='color:red;margin-top:-20px;padding-left:5px;'>" . $_SESSION["error"] . "</p>";
							?>
							<div style="margin-bottom:0px;">
								<div id="btnholder"><button name="login" type="submit" class="btn waves-effect waves-light theme-pink pink darken-1">Sign in</button></div>
								<div id="labelholder" style="display:none;"><a href="#" class="right-align" id="fplink"> forgot password? </a></div>
							</div>
						</form>
					</div>
				</div>
			</div>
        </div>
		
        <!-- Javascript -->
		<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/materialize/js/materialize.min.js"></script>
        
		<script>
			function getProfileImage() {
				  var user_name = document.getElementById("username").value;
				  var user_password = document.getElementById("password").value;
				  var xhttp;
				  var returnedObject;				  
				  if (user_name == "" || user_password == "") {
					document.getElementById("profileImage").src = "assets/ico/people_icon.png";
					return;
				  }
				  xhttp = new XMLHttpRequest();
				  xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var object = JSON.parse(this.responseText);
						if(object.path == "" || object.username == "") {
							document.getElementById("profileImage").src = "assets/ico/people_icon.png";
						}
						else {
							$("#profileImage").animate({opacity: '0'},"slow",function(){
								document.getElementById("profileImage").src = object.path;
								$("#profileImage").animate({opacity : '1'},"slow");
								$("#error_message").hide("slow");
								var date = new Date();
								var hour = date.getHours();
								var message = "";
								var name = (object.username).slice(0,(object.username).indexOf(" ") > 0 ? (object.username).indexOf(" ") : (object.username).length);
								if(hour < 12)
									message = "Good morning";
								else if(hour < 17)
									message = "Good afternoon";
								else
									message = "Good evening";
								document.getElementById("userMessage").innerHTML = message + ", <span style='color: rgb(255, 208, 91);'>" + name + "</span>";
								if(object.username == "")
									$("#userMessage").hide("slow");
								else
									$("#userMessage").show("slow");
							});
						}
					}
				  };
				  xhttp.open("GET", "database/getUserImage.php?username=" + user_name + "&user_password=" + user_password, true);
				  xhttp.send();
			}
			
		</script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>
	<footer>
		<h6> Copyright &copy 2016 | SOIS Manipal </h6>
    </footer>
</html>