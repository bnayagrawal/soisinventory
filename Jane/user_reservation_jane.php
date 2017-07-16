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
  <link href="../assets/css/mycss.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="../assets/css/form_theme_blue.css" id="form-element-theme">
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
        <li class="active"><a href="user_reservation.php">Reservation</a></li>
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

require_once('../database/config.php');

$select_sql = "SELECT borrowed_id,borrowed_component_id,borrowed_date, borrowed_whenUserWantIt, borrowed_howLongUserNeedIt, borrowed_permit FROM `borrowed` WHERE borrowed_user ='$current_user'";

$info = mysqli_query($mysqli, $select_sql);


echo "<div class='panel panel-default'>
    <!-- Default panel contents -->
    <div class='panel-body'>
    <!-- Table -->
    <table class='table'>
        <thead>
        <tr>
            <th>#</th>
            <th>Component name</th>
            <th>Reservation date</th>
            <th>Borrowing date</th>
            <th>How many days</th>
            <th>How many days left</th>
            <th>Admin permit</th>
        </tr>
        </thead>
        <tbody>";

$IDcounter = 0;
while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
    $IDcounter++;

    $select_name_by_id = "SELECT component_name from component where component_id={$row['borrowed_component_id']}";

$name_result = mysqli_query($mysqli, $select_name_by_id);


$name_of_comp = '';

while($row_two=mysqli_fetch_array($name_result,MYSQLI_ASSOC)) {

$name_of_comp = $row_two['component_name'];

}


echo "<tr>
            <td>{$IDcounter}</td>
            <td>{$name_of_comp}</td>
            <td>{$row['borrowed_date']}</td>
            <td>{$row['borrowed_whenUserWantIt']}</td>
            <td>{$row['borrowed_howLongUserNeedIt']}</td>
            <td>{$row['borrowed_howLongUserNeedIt']}</td>
            <td>{$row['borrowed_permit']}</td>
        </tr>";
}

echo "        </tbody>
    </table>
    </div>
    </div>
";

mysqli_close($mysqli);

?>


<!--
<footer class="container-fluid text-center">
  <p>MIT Inventory Copyright</p>
</footer>
-->
</body>
</html>		