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
  <title>SOIS Inventory</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link href="../mycss.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="jumbotron">
    <div class="container">
        <div class="row">
			<div class="col-md-6">
				<img id="page-picture-id" src="../mit_logo.png"  height="auto" width="80">
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
        <li class="active"><a href="user_component.php">Component</a></li>
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

<div class="container-fluid">
	<div class="row col-md-12">
		<div id="filter-panel" class="collapse filter-panel">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-inline" role="form">
						<div class="form-group">
							<label class="filter-col" style="margin-right:0;" for="pref-perpage">Rows per page:</label>
							<select id="pref-perpage" class="form-control">
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option selected="selected" value="5">5</option>
							</select>
						</div> <!-- form group [rows] -->
						<div class="form-group">
							<label class="filter-col" style="margin-right:0;" for="pref-search">Search:</label>
							<input type="text" class="form-control input-sm" id="pref-search">
						</div><!-- form group [search] -->
						<div class="form-group">
							<label class="filter-col" style="margin-right:0;" for="pref-orderby">Filter by:</label>
							<select id="pref-orderby" class="form-control">
								<option>category 1</option>
								<option>category 2</option>
								<option>category 3</option>
								<option>category 4</option>
							</select>
						</div> <!-- form group [order by] -->
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#filter-panel">
				<span class="glyphicon glyphicon-cog"></span> Advanced Search
			</button>
		</div>
	</div>
</div>
<br>

<div class="container-fluid">
<?php

require_once('../database/config.php');
include("../class_lib.php");

$info = mysqli_query($mysqli, "select component_id, component_name, component_desc, vendor_name, component_image, component_year, component_available from component join vendor on component.vendor_id = vendor.vendor_id order by component.component_id");

$component = array();

$filteredComponent = array();

while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
       if($row['component_available'] == 1) {
	$comp = new mitComponent($row['component_name'],$row['component_id'],$row['component_desc'],$row['vendor_name'],$row['component_image'],$row['component_year']);	
	array_push($component, $comp);
       }
}
$tmp = $component[0]->get_name();
//echo "start : " . $tmp . " <br>";
$compView = new ComponentsView();
array_push($compView->oneComponent, $component[0]);
for ($i = 1 ; $i < count($component); $i++) {
	//echo " loop : " . $i . " : " . $component[$i]->get_name() ;
	if($component[$i]->get_name() == $tmp ) {
		//echo " enter here <br>";
		array_push($compView->oneComponent, $component[$i]);
		$tmp = $component[$i]->get_name();
	} else {
		//echo "<br>";
		$compView->set_compCount(count($compView->oneComponent)); 
		array_push($filteredComponent, $compView);
		$compView = new ComponentsView();
		array_push($compView->oneComponent, $component[$i]);
		$tmp = $component[$i]->get_name();
	}
}
		$compView->set_compCount(count($compView->oneComponent)); 
		array_push($filteredComponent, $compView);


// Free result set
//mysqli_free_result($info);

mysqli_close($mysqli);

		$theName;
		$theID;
		$theDesc;
		$theVendor;
		$theImage;
		$theYear;
		$theNumber;


		$rowCounter = -3;
		foreach($filteredComponent as &$val){
		$theName = $val->oneComponent[0]->get_name() ;
		$theID = $val->oneComponent[0]->get_id();
		$theDesc = $val->oneComponent[0]->get_desc();
		$theDescShort = substr($theDesc,0,35) . "...";
		$theVendor = $val->oneComponent[0]->get_vendor_name();
		$theImage = "../" . $val->oneComponent[0]->get_image();
		$theYear = $val->oneComponent[0]->get_year();
		$theNumber = $val->compCount;
		
		
			if($rowCounter == 0) {
				echo "<div class='row'>";
			}
			 echo " 
			 
			 <div class='col-sm-3'>			 
			  <div class='panel panel-default'>
			  <!-- Default panel contents -->
			 
			   <div class='panel-heading'> 
			 <span>{$theName} </span> <span class='pull-right badge'> {$theNumber} </span> </div>
			 <a href='user_inside_component.php?myName={$theName}'>
			   <div class='panel-body'>
					<img src='{$theImage}' class='img-responsive' style='width:100%'  alt='Image'>
			  </div>
			  </a>
			  <div class='panel-footer'>
				<div class='panel-desc'> {$theDescShort}</div>
				<div class='panel-button'> 
				<button type='button' class='btn btn-default'>Reserve</button>
				</div>
			  </div>
			  </div>
			  </div>
			  ";
		
			if($rowCounter % 4 == 0) {
				echo "</div>";
			}
			$rowCounter++;
		
		}
?>

</body>
</html>