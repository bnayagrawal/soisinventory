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
<html lang="en">
<head>
  <title>SOIS Inventory</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link href="mycss.css" rel="stylesheet" type="text/css" />
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
		<li class="active"><a href="admin_course.php">Course</a></li>
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

$select_sql = "SELECT course_id, course_name FROM `course`";

$info = mysqli_query($mysqli, $select_sql);


echo "<div class='panel panel-default'>
    <!-- Default panel contents -->
    <div class='panel-body'>
    <!-- Table -->
    <table class='table'>
        <thead>
        <tr>
            <th>Course name</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>";

while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {

echo "<tr>
            <td>{$row['course_name']}</td>
            <td><a href='admin_delete_course.php?myID={$row['course_id']}' onclick='return checkDelete()' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span>delete</a></td>

        </tr>";
}

echo "        </tbody>
    </table>
    </div>
    </div>
";

mysqli_close($mysqli);

?>

<footer class="container-fluid text-center">
  <p>SOIS Inventory Copyright</p>
</footer>

</body>
</html>