<?php

	session_start();
	if(isset($_SESSION['userName']))
	{
		$current_user = $_SESSION['userName'];	
	//	echo'<h1>WELCOME ' . $_SESSION['userName'] . '</h1>';
	//	echo'<img src="profilepic/' . $_SESSION['userName'] . '.jpg" width="200px" // height="200px" <br>';
//		echo'<br> <h1> <a href="logout.php">LOGOUT</a> </h1>';
	} 
	else
	{
	 	header('Location: index.php');
	 }
?>
<!DOCTYPE html>
<html>
<head>
<title>Add vendor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link href="mycss.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <script>
  
  </script>
</head>
<body>


<div class="jumbotron">
    <div class="container">
        <div class="row">
			<div class="col-md-6">
				<img id="page-picture-id" src="mit_logo.png"  height="auto" width="80">
				<h2 id="page-name-id">SOIS Inventory</h2>
			</div>
			
			<div class="col-md-6">
				<div id="custom-search-input">
					<div class="input-group col-md-12">
						<input type="text" class="form-control input-lg" placeholder="Search..." />
						<span class="input-group-btn">
							<button class="btn btn-default btn-lg" type="button">
								<i class="glyphicon glyphicon-search"></i>
							</button>
						</span>
					</div>
				</div>    
			</div>
		</div>
	</div>
</div>

<nav class="navbar navbar-inverse">
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="admin_component.php">Component</a></li>
		<li><a href="admin_user.php">User</a></li>
        <li><a href="admin_reservation.php">Reservation</a></li>
        <li><a href="admin_course.php">Course</a></li>
        <li><a href="admin_vendor.php">Vendor</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
	  <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		<?php
		echo "Hello," . $current_user;
		?>
        <span class="caret"></span></a>
	 	
        <ul class="dropdown-menu">
          <li><a href="admin_settings.php">Settings</a></li>
          <li><a href="logout.php">Logout</a></li>  
        </ul>
      </li>
      </ul>
    </div>
</nav>


<?php
if ($_POST) {
require_once('config.php');
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security
$vendor_name = mysqli_real_escape_string($mysqli, $_POST['vendor_name']);
$vendor_address = mysqli_real_escape_string($mysqli, $_POST['vendor_address']);
$vendor_city = mysqli_real_escape_string($mysqli, $_POST['vendor_city']);
$vendor_state = mysqli_real_escape_string($mysqli, $_POST['vendor_state']);
$vendor_country = mysqli_real_escape_string($mysqli, $_POST['vendor_country']);

 
// Attempt insert query execution
$sql = "INSERT INTO vendor (vendor_name, vendor_address, vendor_city, vendor_state,vendor_country) VALUES ('$vendor_name', '$vendor_address', '$vendor_city', '$vendor_state','$vendor_country')";

if(mysqli_query($mysqli, $sql)){
    echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('Vendor added successfully');
        window.location.replace(\"admin_add_vendor.php\");
    </SCRIPT>";
} else{
//    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
    echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('There is error with entered data');
        window.location.replace(\"admin_add_vendor.php\");
    </SCRIPT>";
}
 
// Close connection
mysqli_close($mysqli);
	
   $message = 'This is a message.';


	
   exit();
}



?>

<div class="container">
            <div id="legend">
              <legend class="">Add vendor</legend>
            </div>
		
			<div class="row col-md-8">
			<form action="admin_add_vendor.php" method="post">
				<div class="control-group">
				  <label class="control-label" for="fullname">Vendor name</label>
				  <div class="controls">
					<input type="text" id="vendor_name" name="vendor_name" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label" for="address">Vendor address</label>
				  <div class="controls">
					<input type="text" id="vendor_address" name="vendor_address" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label" for="city">Vendor city</label>
				  <div class="controls">
					<input type="text" id="vendor_city" name="vendor_city" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label" for="state">Vendor state</label>
				  <div class="controls">
					<input type="text" id="vendor_state" name="vendor_state" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label" for="country">Vendor country</label>
				  <div class="controls">
					<input type="text" id="vendor_country" name="vendor_country" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				 
				<br>
				<div class="control-group">
				<!-- Button -->
				  <div class="controls">
					<button class="btn btn-success">Save</button>
	
				  </div>
				</div>
			</div>
			</form>
</div>
<br>
</body>
</html>