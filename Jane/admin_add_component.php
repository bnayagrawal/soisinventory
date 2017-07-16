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
<title>Add component</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link href="mycss.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <script>
  
  $(document).ready(function () {
    $(".btn-select").each(function (e) {
        var value = $(this).find("ul li.selected").html();
        if (value != undefined) {
            $(this).find(".btn-select-input").val(value);
            $(this).find(".btn-select-value").html(value);
        }
    });
});

$(document).on('click', '.btn-select', function (e) {
    e.preventDefault();
    var ul = $(this).find("ul");
    if ($(this).hasClass("active")) {
        if (ul.find("li").is(e.target)) {
            var target = $(e.target);
            target.addClass("selected").siblings().removeClass("selected");
            var value = target.html();
            $(this).find(".btn-select-input").val(value);
            $(this).find(".btn-select-value").html(value);
        }
        ul.hide();
        $(this).removeClass("active");
    }
    else {
        $('.btn-select').not(this).each(function () {
            $(this).removeClass("active").find("ul").hide();
        });
        ul.slideDown(250);
        $(this).addClass("active");
    }
});

$(document).on('click', function (e) {
    var target = $(e.target).closest(".btn-select");
    if (!target.length) {
        $(".btn-select").removeClass("active").find("ul").hide();
    }
});

  
  </script>
</head>
<body>


<div class="jumbotron">
    <div class="container">
        <div class="row">
			<div class="col-md-6">
				<img id="page-picture-id" src="mit_logo.png"  height="auto" width="80">
				<h2 id="page-name-id">MIT inventory</h2>
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
require_once('config.php');

$info = mysqli_query($mysqli, "select * from vendor");

$vendor_array = array();
while ($row = mysqli_fetch_array($info)) {
    $vendor_array[] = $row['vendor_name'];
}

?>

<?php
if ($_POST) {

// Escape user inputs for security
if(isset($_POST['component_name'])){ $component_name = $_POST['component_name']; } 
if(isset($_POST['component_desc'])){ $component_desc = $_POST['component_desc']; } 
if(isset($_POST['component_total'])){ $component_total = $_POST['component_total']; } 
if(isset($_POST['vendor_id'])){ $comp_vendor_name = $_POST['vendor_id']; } 
 
if(isset($_POST['component_year'])){ $component_year = $_POST['component_year']; }

// FILE UPLOADS

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
/*
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
*/
// Check file size
/*
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
*/
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<font color='red'> Sorry, your file was not uploaded. </font>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
       // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
		echo "<font color='red'> Sorry, your file was not uploaded. </font>";
    }
}

//END FILE UPLOAD

// Attempt insert query execution
if($uploadOk != 0) {
	
$sql = "INSERT INTO component (component_name, component_desc, vendor_id,component_image, component_year) VALUES ('$component_name', '$component_desc', (select vendor_id from vendor where vendor_name = '$comp_vendor_name') ,'$target_file','$component_year')";	
 

// (select vendor_id from vendor where vendor_name = $comp_vendor_name)


if(mysqli_query($mysqli, $sql)){
	echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('Component added successfully');
        window.location.replace(\"admin_add_component.php\");
    </SCRIPT>";
} else{
	echo "Not working" . mysqli_error($mysqli);
//    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
	echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('There is error with entered data');
        window.location.replace(\"admin_add_component.php\");
    </SCRIPT>";
}

for ($i = 0; $i < $component_total - 1 ; $i++) {
	mysqli_query($mysqli, $sql);
}

} else {
	echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('There is error with entered data outside else');
        window.location.replace(\"admin_add_component.php\");
    </SCRIPT>";
}
 
// Close connection
mysqli_close($mysqli);
}

?>

<form action="admin_add_component.php" method="post" enctype="multipart/form-data">
<div class="container">
  
            <div id="legend">
              <legend class="">Add component</legend>
            </div>
		
			<div class="row col-md-12">
			<div class="col-md-8">
				
				<div class="control-group">
				  <label class="control-label" for="fullname">Component name</label>
				  <div class="controls">
					<input type="text" id="component_name" name="component_name" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label" for="vendor">Component vendor</label>
				  <div class="controls">
					<a class="btn btn-default btn-select">
						<input type="hidden" class="btn-select-input" id="vendor_id" name="vendor_id" value="" />
						<span class="btn-select-value">Select a Vendor</span>
						<span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
						<ul>
							<?php
							for($i = 0; $i < count($vendor_array); $i++ ) {
								echo "<li>" . $vendor_array[$i] . "</li>";
							}
							?>
						</ul>
					</a>
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label" for="total">Component amount</label>
				  <div class="controls">
					<input type="text" id="component_total" name="component_total" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				
				<div class="control-group">
				  <label class="control-label" for="year">Component year</label>
				  <div class="controls">
					<input type="text" id="component_year" name="component_year" placeholder="" class="form-control input-lg">
				  </div>
				</div>
					
<div class="control-group">
				  <label class="control-label" for="description">Component description</label>
				  <div class="controls">
					<input type="text" id="component_desc" name="component_desc" placeholder="" class="form-control input-lg">
				  </div>
				</div>
				<br>	
			</div>
			 	
			<div class="col-md-4 pull-right">
			  <!-- col-sm-6 col-xs-12 -->
				<br>
				<form action="admin_add_component.php" method="post" enctype="multipart/form-data">
					Select image to upload:
					<input type="file" name="fileToUpload" id="fileToUpload">
				</form>
			</div>	
			</div>
			<br>
			
            <div class="control-group">
			<!-- Button -->
              <div class="controls">
                <button class="btn btn-success" name="submit">Save</button>
              </div>
            </div>
</div>

</form>

<br>

</body>
</html>