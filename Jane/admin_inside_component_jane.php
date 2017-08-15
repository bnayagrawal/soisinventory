<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 8/10/2016
 * Time: 1:49 PM
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
    header('Location: index.php');
}
?>
<!--
<script>
    $(document).ready(function(){
        $("#delete").click(function(){
            $.post("admin_delete_component.php",
                {
                    name: "Donald Duck",
                    city: "Duckburg"
                },
                function(data,status){
                    alert("Data: " + data + "\nStatus: " + status);
                });
        });
    });
</script>
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SOIS Inventory</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/css/mycss.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="assets/css/form_theme_blue.css" id="form-element-theme">
		
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script>
        function checkDelete(){
            return confirm('Are you sure?');
        }

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
$name = $_GET['myName'];

require_once('database/config.php');
include("database/class_lib.php");

$info = mysqli_query($mysqli, "select component_id, component_name, component_desc, vendor_name, component_image, component_year from component join vendor on component.vendor_id = vendor.vendor_id where component.component_name='" . $name .  "'order by component.component_id");

$component = array();

while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
    $comp = new mitComponent($row['component_name'],$row['component_id'],$row['component_desc'],$row['vendor_name'],$row['component_image'],$row['component_year']);
    array_push($component, $comp);
}


    $theName = $component[0]->get_name();
    $theNumber = count($component);
    $theDesc = $component[0]->get_desc();
    $theVendor = $component[0]->get_vendor_name();
    $theImage = $component[0]->get_image();
    $theYear = $component[0]->get_year();

?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-6'>
                <div class='panel panel-default'>
                    <!-- Default panel contents -->
                    <div class='panel-heading'>
                        <span><?php echo $theName ?> </span> <span class='pull-right badge'> <?php echo $theNumber ?></span> </div>
                    <div class='panel-body'>
                       <?php echo '<img src="'.$theImage.'" class=\'img-responsive\' align=\'middle\' style=\' width:auto height:auto\' alt=\'Image\' >';  ?>
                    </div>
                    <div class='panel-footer'>
                        <div class='panel-desc'><?php echo "<b>Description:</b> " . $theDesc . '<br><b>Year: </b>' . $theYear . '<br><b>Vendor:</b> ' . $theVendor ?></div>
                    </div>
                </div>
        </div>
        <div class='col-md-6'>
            <div class='row'>
                <div class='col-md-12'>
                    <!-- redica -->
                    <div class='container-fluid bootstrap snippet'>
                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='main-box no-header clearfix'>
                                    <div class='main-box-body clearfix'>
                                        <div class='table-responsive'>
                                            <table class='table user-list'>
                                                <thead>
                                                <tr>
                                                    <th><span>ID</span></th>
                                                    <th><span>Status</span></th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody>



                    <?php
for($i = 0 ; $i < $theNumber; $i++) {
    $theID = $component[$i]->get_id();
echo " 
                                                <tr>
                                                    <td> $theID </td>
                                                    <td>Status</td>
                                                    <td style='width: 50%;'>
                                                            <a href='admin_damage_component.php?myID={$theID}' onclick='return checkDelete()' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span>damage</a>
                                                            
                                                            <a href='admin_lost_component.php?myID={$theID}' onclick='return checkDelete()' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-eye-close'></span>lost</a>
                                                     
                                                            <a href='admin_delete_component.php?myID={$theID}' onclick='return checkDelete()' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span>delete</a>
                                                            
                                                    </td>
                                                </tr>
                    <!-- kraj -->
                    "; }
                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
