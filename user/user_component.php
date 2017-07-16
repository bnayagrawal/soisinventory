<?php
	session_start();
	if(isset($_SESSION['userName']))
	{
		$current_user = $_SESSION['userName'];
		$current_user_full_name = $_SESSION['userFullName'];
		$theme = $_SESSION["theme"];
	} 
	else
	{
		echo "<script>
			alert('You need to login to access this page.');
			window.location.href='../logout.php';
		  </script>
		";
	 }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MIT Inventory</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="<?php echo $theme; ?>" id="url-theme">
	  
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="../assets/materialize/css/materialize.min.css"  media="screen,projection"/>
		<link href="../assets/css/user_component_style.css" rel="stylesheet" type="text/css" /> 
		<link rel="stylesheet" href="../assets/css/form_theme_<?php echo $theme; ?>.css" id="form-element-theme">
	</head>
	<body>
		<!-- HEAD AND NAV -->
		<ul id="dropdown1" class="dropdown-content">
		  <li><a href="user_settings.php" class=" <?php echo $theme; ?>-text text-darken-3">Settings</a></li>
		  <li class="divider"></li>
		  <li><a href="../logout.php" class=" <?php echo $theme; ?>-text text-darken-3">Log out</a></li>
		</ul>
		<ul id="dropdown2" class="dropdown-content">
		  <li><a href="#" class=" <?php echo $theme; ?>-text text-darken-3"><i class="material-icons left  <?php echo $theme; ?>-text text-darken-3">swap_vert</i>Sort</a></li>
		  <li><a href="#" class=" <?php echo $theme; ?>-text text-darken-3"><i class="material-icons left  <?php echo $theme; ?>-text text-darken-3">gradient</i>Filter</a></li>
	      <li><a href="#" class=" <?php echo $theme; ?>-text text-darken-3 search-modal-link"><i class="material-icons left  <?php echo $theme; ?>-text text-darken-3">search</i>Search</a></li>
		</ul>
		<div class="navbar-fixed">
		<nav class="nav-extended <?php echo $theme; ?> darken-3">
			<div class="nav-wrapper">
				<a href="#" class="brand-logo">SOIS <span style="font-weight:400;">inventory</span></a>
				<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a class="dropdown-button" href="#!" data-activates="dropdown1"><img src="<?php require_once('../database/config.php'); 
							$info = mysqli_query($mysqli, "select user_image from user where user_username='".$current_user."'");
		
							while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
								$image_path = "../".$row['user_image'];
							}
											
							if(isset($image_path))
								echo $image_path;
							else
								echo "../uploads/userimage/user.png";
							?>"
					id="user_icon" class="circle responsive-img"><?php echo $current_user_full_name; ?><i class="material-icons right">arrow_drop_down</i></a></li>
				</ul>
				<ul id="nav-pc" class="right hide-on-med-and-down">
					<li><a class="dropdown-button" href="#!" data-activates="dropdown2"><i class="material-icons right">view_list</i></a></li>
				</ul>
				<ul class="right hide-on-large-only">
					<li><a href="#!" onclick="toggleSearchModal();"><i class="material-icons" style="padding-right:6px;">search</i></a></li>
				</ul>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li class="active"><a href="#">Component</a></li>
					<li><a href="user_reservation.php">Rreservation</a></li>
					<li class="hide-on-1200px"><a href="#"><i class="material-icons left">swap_vert</i>Sort</a></li>
					<li class="hide-on-1200px"><a href="#"><i class="material-icons left">gradient</i>Filter</a></li>
					<li class="hide-on-1200px"><a href="#" class="search-modal-link"><i class="material-icons left">search</i>Search</a></li>
				</ul>
				<div class="nav-row valign-wrapper hide-on-large-only">
					<ul class="valign" id="center-mobile">
					<li><a href="#"><i class="material-icons left">swap_vert</i>Sort</a></li>
					<li><a href="#"><i class="material-icons left">gradient</i>Filter</a></li>
					<li><a href="#"><i class="material-icons left">view_module</i>Layout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		</div>
		<!-- SIDE NAV MOBILE -->
		<ul id="slide-out" class="side-nav">
			<li>
				<div class="userView">
					<div class="background">
						<img class="responsive-img" src="../assets/img/mu3.jpg">
					</div>
					<a href="#!user"><img class="circle" src="<?php require_once('../database/config.php'); 
							$info = mysqli_query($mysqli, "select user_image from user where user_username='".$current_user."'");
		
							while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
								$image_path =  "../".$row['user_image'];
							}
											
							if(isset($image_path))
								echo $image_path;
							else
								echo "../uploads/userimage/user.png";
							?>"></a>
					<a href="#!name"><span class="white-text name"><?php echo $current_user_full_name; ?></span></a>
					<a href="#!email">
						<span class="white-text email">
						<?php
							require_once('../database/config.php');
							$email = "";
							$info = mysqli_query($mysqli, "select user_email from user where user_username='".$current_user."'");
							while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
								$email = $row['user_email'];
							}
							echo $email;
						?>
						</span>
					</a>
				</div>
			</li>
			<li><a href="user_settings.php"><i class="material-icons">settings</i>Settings</a></li>
			<li><a href="../logout.php"><i class="material-icons">input</i>Logout</a></li>
			<li><div class="divider"></div></li>
			<li><a class="subheader">Navigation</a></li>
			<li><a class="waves-effect" href="#"><i class="material-icons">dashboard</i>Component</a></li>
			<li><a class="waves-effect" href="user_reservation.php"><i class="material-icons">star</i>Reservation</a></li>
		</ul>
		<!-- SECTION CONTENT -->
		<section>
			<!-- SEARCH, FILTER AND OTHER OPTIONS -->
			<div class="row white section" style="display:none;">
				<div class="form-container">
					<form>
						<div class="input-field col s12 m6 l6">
							<i class="material-icons prefix">info_outline</i>
							<select id="select-option">
								<option value="" disabled selected>Search component by</option>
								<option value="1">Component Name</option>
								<option value="2">Vendor Name</option>
							</select>
						</div>
						<div class="input-field col s12 m6 l6">
							<!--
						    <div class="search">
								<i class="material-icons" id="search-icon">search</i>
								<input type="text" id="search">
								<div class="search-results"></div>
							</div>-->
							<i class="material-icons prefix">search</i>
							<input type="text" id="autocomplete-input" class="autocomplete">
							<label for="autocomplete-input">Search component</label>
						</div>
					</form>
				</div>
				<div>
				</div>
			</div>
				<div class="row" style="margin:0px;padding:10px 10px 0px 10px;">
					<div class="white col s12">
						<p class=" <?php echo $theme; ?>-text text-darken-3" id="current-location"><i class="material-icons prefix">home</i> Home / All Components </p>
					</div>
				</div>
				<div class="row">
					<?php
						//FETCH COMPONENT DETAILS FROM DATABASE AND STORE THEM IN ARRAYS OF OBJECTS
						require_once('../database/config.php');
						include("../database/class_lib.php");

						$info = mysqli_query($mysqli, "select component_id, component_name, component_desc, vendor_name, component_image, component_year from component join vendor on component.vendor_id = vendor.vendor_id order by component.component_id");
						$component = array();
						$filteredComponent = array();

						while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
							$comp = new mitComponent($row['component_name'],$row['component_id'],$row['component_desc'],$row['vendor_name'],$row['component_image'],$row['component_year']);	
							array_push($component, $comp);
						}
						
						if(!empty($component)) {
							$tmp = $component[0]->get_name();
							$compView = new ComponentsView();
							array_push($compView->oneComponent, $component[0]);

							for ($i = 1 ; $i < count($component); $i++) {
								if($component[$i]->get_name() == $tmp ) {
									array_push($compView->oneComponent, $component[$i]);
									$tmp = $component[$i]->get_name();
								} else {
									$compView->set_compCount(count($compView->oneComponent)); 
									array_push($filteredComponent, $compView);
									$compView = new ComponentsView();
									array_push($compView->oneComponent, $component[$i]);
									$tmp = $component[$i]->get_name();
								}
							}
							
							$compView->set_compCount(count($compView->oneComponent)); 
							array_push($filteredComponent, $compView);
						}
						
					?>
					
					<?php
						//DISPLAY THE COMPONENTS
						$theName;
						$theID;
						$theDesc;
						$theVendor;
						$theImage;
						$theYear;
						$theNumber;
						
						$rowCounter = -2;
						foreach($filteredComponent as &$val) {
							$theName = $val->oneComponent[0]->get_name();
							$theID = $val->oneComponent[0]->get_id();
							$theDesc = $val->oneComponent[0]->get_desc();
							$theDescShort = substr($theDesc,0,35) . "...";
							$theVendor = $val->oneComponent[0]->get_vendor_name();
							$theImage = "../" .$val->oneComponent[0]->get_image();
							$theYear = $val->oneComponent[0]->get_year();
							$theNumber = $val->compCount;

							echo "					<div class='col s12 m6 l4' style='padding: 0.5rem 0.75rem;'>
						<div class='component-card z-depth-1 white'>
							<div class='component-image-section'>
								<div class='component-card-image-container'>
									<img src='{$theImage}' class='component-card-image' alt='{$theName}'>
								</div>
							</div>
							<div class='component-info-section'>
								<div class='component-heading'>
									<h3 class='truncate {$theme}-text text-darken-3'> {$theName} </h3> 
								</div>
								<div class='component-description'>
									<p> {$theDesc} </p>
								</div>
							</div>
							<div class='component-options-section'>
								<div class='component-option'>
									<p class='component-card-brand truncate'>{$theVendor}</p>
									<i class='material-icons grey-text'>business</i>									
								</div>
								<div class='component-option'>
									<p class='component-card-brand truncate'>{$theNumber} Available</p>
									<i class='material-icons grey-text'>dashboard</i>
								</div>
								<div class='component-option' style='border-right:0px;'>
									<a class='component-card-brand truncate' href='user_inside_component.php?myName={$theName}'>Reserve</a>
									<i class='material-icons grey-text'>star</i>
								</div>
							</div>
						</div>
					</div>";
							$rowCounter++;
						} //END OF FOREACH BODY
					?>
				</div>
				<!-- SEARCH WINDOW FOR LARGE SCREEN -->
				<div id="search-modal-background">
					<div id="search-modal-wrapper" class="z-depth-5">
						<div id="search-modal-bar" class="white z-depth-1">
							<form>
								<input type="text" name="search" id="search-input-for-search-modal" onkeyup="performSearch(this.value)" placeholder="Search for components" autocomplete="off" autofocus>
								<i class="material-icons" id="search-icon-left" style="cursor:pointer;" onclick="toggleSearchModal()">arrow_back</i>
								<i class="material-icons" id="search-icon-right" style="cursor:pointer;">more_vert</i>
							</form>
						</div>
						<!-- SEARCH RESULT -->
						<div id="search-modal-result-wrapper">
							<div id="search-modal-result">
								<!-- SEARCH RESULT ITEMS [SAMPLE] 
								<div class="search-result-wrapper z-depth-1">
									<div class="search-result-image-wrapper">
										<img class="search-result-image" src="uploads/arduino.jpg">
									</div>
									<div class="search-result-description">
										<h4 class="search-result-component-name truncate"> Component name </h4>
										<h6 class="search-result-vendor-name grey-text darken-3"> vendor : name </h6>
										<h6 class="search-result-component-id grey-text darken-3"> id : id </h6>
									</div>
								</div>
								-->
							</div>
						</div>
					</div>
				</div>
		</section>
		<!-- SCRIPTS -->
		<script type="text/javascript" src="../assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="../assets/materialize/js/materialize.min.js"></script>
		<script>
			var sd;
			$("#url-theme").attr("content",$(".<?php echo $theme; ?>.darken-3").css("background-color"));
			$("document").ready(function(){
				$(".dropdown-button").dropdown();
				$(".button-collapse").sideNav();
				$('select').material_select();
	
				$('.tooltipped').tooltip({delay: 50});
				$(".search-modal-link").click(function(){
					$("#search-modal-background").fadeToggle(function(){
						$("#search-modal-wrapper").slideToggle();
					})
				});
								
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
			});

				<?php 
					if(isset($_SESSION['reservation-result'])){
						echo "Materialize.toast('{$_SESSION['reservation-result']}', 3000, 'rounded')";
						unset($_SESSION['reservation-result']);
					}
				?>
				
			function toggleSearchModal() {
				$("#search-modal-wrapper").slideToggle(function(){
					$("#search-modal-background").fadeToggle();
				});
			}
			
			function performSearch(search_string) {
				  var xhttp;
				  var returnedObject;
				  
				  //trim white spaces
				  search_string = search_string.trim();
				  search_string = search_string.toLowerCase();
				  
				  xhttp = new XMLHttpRequest();
				  xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var object = JSON.parse(this.responseText);
						var item;
						
						//remove all childs from search-modal-result div element. Now using jQuery
						$("#search-modal-result").empty();
						
						if(search_string == "")
							return;
						
						//add new elements. Now using jQuery
						var rcount = 0;
						for(item in object.component_info) {
							var srw = "<div class='search-result-wrapper' id='srw-" + rcount + "'></div>";
							var sriw = "<div class='search-result-image-wrapper' id='sriw-" + rcount + "'></div>";
							var sri = "<img class='search-result-image' src='../" + object.component_info[item].component_image + "'>";
							var srd = "<div class='search-result-description' id='srd-" + rcount + "'>";
								//highlight search string
								var comp_name = object.component_info[item].component_name;
								comp_name = comp_name.toLowerCase();
								var s_pos = comp_name.indexOf(search_string);
								var keyword_length = search_string.length;
								var part_one = comp_name.slice(0,s_pos);
								var part_two = comp_name.substr(s_pos + keyword_length,comp_name.length);
							var srcn = "<a href='admin_inside_component.php?myName=" + object.component_info[item].component_name + "' class='search-result-component-name truncate'>" + part_one + "<span class='search-keyword  <?php echo $theme; ?>-text'>"+ search_string +"</span>"+ part_two + "</h4>";
							var srvn = "<h6 class='search-result-vendor-name grey-text darken-3'> by " + object.component_info[item].vendor_name + "</h6>";
							var srci = "<h6 class='search-result-component-id grey-text darken-3'>" + object.component_info[item].item_count + " Available </h6>";

							$("#search-modal-result").append(srw);
								$("#srw-" + rcount).append(sriw);
									$("#sriw-" + rcount).append(sri);
								$("#srw-" + rcount).append(srd);
									$("#srd-" + rcount).append(srcn);
									$("#srd-" + rcount).append(srvn);
									$("#srd-" + rcount).append(srci);
							rcount++;
						}
					}
				  };
				  xhttp.open("GET", "../database/getComponentDetails.php?component_name=" + search_string, true);
				  xhttp.send();
			}
			
		</script>
	</body>
</html>

