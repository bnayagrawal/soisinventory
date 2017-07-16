<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 8/11/2016
 * Time: 12:42 PM
 */
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
    header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MIT Inventory</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link href="../mycss.css" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

        <!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" /> 

        <!--Font Awesome (added because you use icons in your prepend/append)-->
    <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />


    <script>
    </script>
</head>
<body>

<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img id="page-picture-id" src="../mit_logo.png"  height="auto" width="80">
                <h2 id="page-name-id">MIT inventory</h2>
            </div>

            <div class="col-md-6">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control input-lg" placeholder="Search..." />
                        <span class="input-group-btn">
							<button class="btn btn-info btn-lg" type="button">
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
            <li><a href="user_component.php">Component</a></li>
            <li><a href="user_reservation.php">Reservation</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <?php
                    echo "Hello," . $current_user;
                    ?>
                    <span class="caret"></span></a>

                <ul class="dropdown-menu">
                    <li><a href="user_settings.php">Settings</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>



<?php
$name = $_GET['myName'];

require_once('../config.php');
include("../class_lib.php");

$info = mysqli_query($mysqli, "select component_id, component_name, component_desc, vendor_name, component_image, component_year from component join vendor on component.vendor_id = vendor.vendor_id where component.component_name='" . $name .  "'order by component.component_id");

$component = array();
$found = false;

while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
    $comp = new mitComponent($row['component_name'],$row['component_id'],$row['component_desc'],$row['vendor_name'],$row['component_image'],$row['component_year']);
    array_push($component, $comp);
	$found = true;
}

if(!$found){
	echo "<script>
			alert('No such component :(');
			window.location.href='user_component.php';
		  </script>
	";
}

$theName = $component[0]->get_name();
$theNumber = count($component);
$theDesc = $component[0]->get_desc();
$theVendor = $component[0]->get_vendor_name();
$theImage = "../" . $component[0]->get_image();
$theYear = $component[0]->get_year();

if($theNumber > 0) {
    $componentID = $component[0]->get_id();
}


?>


<div class='container'>
    <div class='row'>
        <div class="col-md-6 col-sm-6 col-xs-12">

                <div class='panel panel-default'>
                    <!-- Default panel contents -->
                    <div class='panel-heading'>
                        <span><?php echo $theName ?> </span> <span class='pull-right badge'> <?php echo $theNumber ?></span> </div>
                    <div class='panel-body'>
                        <?php echo '<img src="'.$theImage.'" class=\'img-responsive\' align=\'middle\' style=\' width:auto height:auto\' alt=\'Image\' >';  ?>
                    </div>
                    <div class='panel-footer'>
                        <div class='panel-desc'><?php echo "Description: " . $theDesc . '<br>Year: ' . $theYear . '<br>Vendor: ' . $theVendor ?></div>
                    </div>
                </div>

        </div>
		
		<div class="col-md-6 col-sm-6 col-xs-6">
<?php echo "<form class='form-horizontal' action='user_makes_reservation.php?myID={$componentID}'' method='post'> " ?>
			 <div class="form-group ">
			 <div class="row">
				  <p class="col-md-12 col-sm-12 col-xs-12">When do you need it ?</p>
			 </div>
			 <div class="row">
				  <div class="col-md-12 col-sm-12 col-xs-12">
				   <div class="input-group">
					<input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" type="text"/>
					<div class="input-group-addon">
					 <i class="fa fa-calendar">
					 </i>
					</div>
				   </div>
				  </div>
			  </div>
			 </div>
			 <div class="form-group ">
			  <div class="row">
				  <p class="col-md-12 col-sm-12 col-xs-12">How long do you need it (in days) ?</p>
			  </div>
			  <div class="row">
			  <div class="col-md-12 col-sm-12 col-xs-12">
                  <input class="form-control" id="days_number" name="days_number" type="text"/>
			  </div>
			 </div>
			 </div>
			 <div class="form-group">
			  <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5 col-sm-offset-5 col-xs-offset-5">
			   <button class="btn btn-primary " name="submit" type="submit">
				Reserve
			   </button>
			  </div>
			 </div>
			</form>
					
        </div>
    </div>
</div>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'yyyy-mm-dd',
            daysOfWeekDisabled: "0",
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>

</body>
</html>