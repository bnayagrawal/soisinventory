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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>MIT Inventory</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="white" id="url-theme">
	  
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="assets/materialize/css/materialize.min.css"  media="screen,projection"/>
		<link href="assets/css/admin_component_style.css" rel="stylesheet" type="text/css" /> 
		<link rel="stylesheet" href="assets/css/form_theme_<?php echo $theme; ?>.css" id="form-element-theme">
	</head>
	<body>
		<!-- PRE LOADER -->
		<div id="pre-loader">
			<div id="pre-loader-container" style="margin:auto;">
				<h6> Loading please wait... </h6>
				<div class="progress <?php echo $theme; ?> lighten-3">
					<div class="indeterminate <?php echo $theme; ?> darken-3"></div>
				</div>
			</div>
		</div>
		<!-- FIXED FLOATING BUTTON -->
		<div class="fixed-action-btn click-to-toggle">
			<a class="btn-floating btn-large <?php echo $theme; ?> darken-3">
				<i class="large material-icons">add</i>
			</a>
			<ul>
				<li><a class="btn-floating <?php echo $theme; ?> darken-3 tooltipped" onclick="addComponentShow();" data-position="left" data-delay="50" data-tooltip="Add Component"><i class="material-icons white-text">dashboard</i></a></li>
			</ul>
		 </div>
		<!-- HEAD AND NAV -->
		<ul id="dropdown1" class="dropdown-content">
		  <li><a href="admin_settings.php" class="<?php echo $theme; ?>-text text-darken-3">Settings</a></li>
		  <li class="divider"></li>
		  <li><a href="logout.php" class="<?php echo $theme; ?>-text text-darken-3">Log out</a></li>
		</ul>
		<ul id="dropdown2" class="dropdown-content">
		  <li><a href="#" class="<?php echo $theme; ?>-text text-darken-3"><i class="material-icons left <?php echo $theme; ?>-text text-darken-3">swap_vert</i>Sort</a></li>
		  <li><a href="#" class="<?php echo $theme; ?>-text text-darken-3"><i class="material-icons left <?php echo $theme; ?>-text text-darken-3">gradient</i>Filter</a></li>
	      <li><a href="#" class="<?php echo $theme; ?>-text text-darken-3 search-modal-link"><i class="material-icons left <?php echo $theme; ?>-text text-darken-3">search</i>Search</a></li>
		</ul>
		<div class="navbar-fixed">
		<nav class="nav-extended <?php echo $theme; ?> darken-3">
			<div class="nav-wrapper">
				<a href="#" class="brand-logo">SOIS <span style="font-weight:400;">inventory</span></a>
				<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a class="dropdown-button" href="#!" data-activates="dropdown1"><img src="<?php require_once('database/config.php'); 
							$info = mysqli_query($mysqli, "select admin_image from admin");
		
							while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
								$image_path = $row['admin_image'];
							}
											
							if(isset($image_path))
								echo $image_path;
							else
								echo "uploads/userimage/user.png";
							?>"
					id="user_icon" class="circle responsive-img"><?php echo $current_user; ?><i class="material-icons right">arrow_drop_down</i></a></li>
				</ul>
				<ul id="nav-pc" class="right hide-on-med-and-down">
					<li><a class="dropdown-button" href="#!" data-activates="dropdown2"><i class="material-icons right">view_list</i></a></li>
				</ul>
				<ul class="right hide-on-large-only">
					<li><a href="#!" onclick="toggleSearchModal();"><i class="material-icons" style="padding-right:6px;">search</i></a></li>
				</ul>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li class="active"><a href="#">Component</a></li>
					<li><a href="admin_reservation.php">Rreservation</a></li>
					<li><a href="admin_course.php">Course</a></li>
					<li><a href="admin_vendor.php">Vendor</a></li>
					<li><a href="admin_user.php">User</a></li>
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
						<img class="responsive-img" src="assets/img/final-background.png">
					</div>
					<a href="#!user"><img class="circle" src="<?php require_once('database/config.php'); 
							$info = mysqli_query($mysqli, "select admin_image from admin");
		
							while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
								$image_path = $row['admin_image'];
							}
											
							if(isset($image_path))
								echo $image_path;
							else
								echo "uploads/userimage/user.png";
							?>"></a>
					<a href="#!name"><span class="white-text name"><?php echo $current_user; ?></span></a>
					<a href="#!email">
						<span class="white-text email">
						<?php
							require_once('database/config.php');
							$email = "";
							$info = mysqli_query($mysqli, "select admin_email from admin");
							while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
								$email = $row['admin_email'];
							}
							echo $email;
						?>
						</span>
					</a>
				</div>
			</li>
			<li><a href="admin_settings.php"><i class="material-icons">settings</i>Settings</a></li>
			<li><a href="logout.php"><i class="material-icons">input</i>Logout</a></li>
			<li><div class="divider"></div></li>
			<li><a class="subheader">Navigation</a></li>
			<li><a class="waves-effect" href="#"><i class="material-icons">dashboard</i>Component</a></li>
			<li><a class="waves-effect" href="admin_user.php"><i class="material-icons">account_circle</i>User</a></li>
			<li><a class="waves-effect" href="admin_reservation.php"><i class="material-icons">star</i>Reservation</a></li>
			<li><a class="waves-effect" href="admin_course.php"><i class="material-icons">book</i>Course</a></li>
			<li><a class="waves-effect" href="admin_vendor.php"><i class="material-icons">business</i>Vendor</a></li>
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
						<p class="<?php echo $theme; ?>-text text-darken-3" id="current-location"><i class="material-icons prefix">home</i> Home / All Components </p>
					</div>
				</div>
				<div class="row">
					<?php
						//FETCH COMPONENT DETAILS FROM DATABASE AND STORE THEM IN ARRAYS OF OBJECTS
						require_once('database/config.php');
						include("database/class_lib.php");

						$info = mysqli_query($mysqli, "select component_id, component_name, component_desc, vendor_name, component_image, component_year from component join vendor on component.vendor_id = vendor.vendor_id WHERE component.status='ok' ORDER BY component.component_id");
						$component = array();
						$filteredComponent = array();
						$components_per_page = 9;
						$page_number = 1;

						if(isset($_GET['page']))
							$page_number = $_GET['page'];
						
						if(isset($_GET['cpp']))
							$components_per_page = $_GET['cpp'];

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
						$i = 1;
						$rowCounter = -2;
						$shownComponents = 0;
						$totalComponents = count($filteredComponent);
						
						if($components_per_page < 1 || $page_number < 1 ) {
							$components_per_page = 9;
							$page_number = 1;
						}
						else if($page_number < 2 && ($components_per_page * $page_number) > $totalComponents) {
							$components_per_page = 9;
							$page_number = 1;
						} else if($page_number > 1) {
							if((($components_per_page * $page_number) - $components_per_page ) > $totalComponents) {
								$components_per_page = 9;
								$page_number = 1;
							}
						}
							
						foreach($filteredComponent as &$val) {
							if($i <= ($components_per_page*($page_number-1)) && ($components_per_page*($page_number)-1) != $components_per_page) {
								$i++;
								continue;
							}
							$theName = $val->oneComponent[0]->get_name();
							$theID = $val->oneComponent[0]->get_id();
							$theDesc = $val->oneComponent[0]->get_desc();
							$theDescShort = substr($theDesc,0,35) . "...";
							$theVendor = $val->oneComponent[0]->get_vendor_name();
							$theImage = $val->oneComponent[0]->get_image();
							$theYear = $val->oneComponent[0]->get_year();
							$theNumber = $val->compCount;

							echo "					<div class='col s12 m6 l4 xl3' style='padding: 0.5rem 0.75rem;'>
						<div class='component-card hoverable z-depth-1 white'>
							<div class='component-image-section'>
								<div class='component-card-image-container'>
									<img src='{$theImage}' class='component-card-image' alt='{$theName}'>
								</div>
							</div>
							<div class='component-info-section'>
								<div class='component-heading'>
									<h3 class='truncate {$theme}-text text-darken-3'> {$theName} </h3> 
								</div>
								<div class='component-description custom_scroll_bar'>
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
									<a class='component-card-brand truncate' href='admin_inside_component.php?myName={$theName}'>UPDATE</a>
									<i class='material-icons grey-text'>mode_edit</i>
								</div>
							</div>
						</div>
					</div>";
							$i++;
							$shownComponents++;
							if($shownComponents >= $components_per_page)
								break;
							$rowCounter++;
						} //END OF FOREACH BODY
				
					echo "</div>";
					
					$prev_page = ($page_number > 1) ? $page_number - 1: '#';
					
					echo "<div style='width: 100%;text-align: center;'><ul class='pagination'>";
					if($page_number > 1)
						echo "<li><a href='admin_component.php?page={$prev_page}&cpp={$components_per_page}'><i class='material-icons'>chevron_left</i></a></li>";
					else
						echo "<li class='disabled'><a href='#'><i class='material-icons'>chevron_left</i></a></li>";
					
					for($i = 1; $i < $page_number; $i++)
						echo "<li><a href='admin_component.php?page={$i}&cpp={$components_per_page}'>{$i}</a></li>";
					
					echo "<li class='active {$theme} darken-3'><a href='#'>{$page_number}</a></li>";
					
					for($i = $page_number+1; $i <= ceil(($totalComponents/$shownComponents)); $i++) 
						echo "<li><a href='admin_component.php?page={$i}&cpp={$components_per_page}'>{$i}</a></li>";
						
					if($page_number != ceil(($totalComponents/$shownComponents))){
						$next_page = $page_number+1;
						echo "<li><a href='admin_component.php?page={$next_page}&cpp={$components_per_page}'><i class='material-icons'>chevron_right</i></a></li>";
					}
					else
						echo "<li class='disabled'><a href='#!'><i class='material-icons'>chevron_right</i></a></li></ul></div>";
					?>
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
								<div class="search-result-wrapper">
									<div class="search-result-image-wrapper">
										<img class="search-result-image" src="uploads/arduino.jpg">
									</div>
									<div class="search-result-description">
										<a href="#" class="search-result-component-name truncate"> Component name </a>
										<h6 class="search-result-vendor-name grey-text darken-3"> vendor : name </h6>
										<h6 class="search-result-component-id grey-text darken-3"> id : id </h6>
									</div>
								</div>
								-->
							</div>
						</div>
					</div>
				</div>
				
				<!-- ADD NEW COMPONENT -->
				<div id="add-com-modal-background">
					<div id="add-com-modal-wrapper" class="white z-depth-3">
						<form style="text-align:left;" id="add-com-modal-content" action="database/addNewComponent.php" method="POST" enctype="multipart/form-data">
							<div id="add-com-modal-header">
								<h4 class="<?php echo $theme; ?>-text text-darken-3"> Add Component <i class="material-icons" id="btn-close-modal" title="close" onclick="addComponentHide();">close</i></h4>
							</div>
							<div id="add-com-modal-inputs" class="row">
								<div class="col s8">
									<div class="input-field col s12">
										<input id="com_name" name="com_name" type="text" class="validate" required autocomplete="off" maxlength="75" length="75">
										<label for="com_name">Component name</label>
									</div>
									<div class="input-field col s12">
										<select name="com_ven">
											<?php
												require_once('database/config.php');
												$info = mysqli_query($mysqli, "select * from vendor");

												while ($row = mysqli_fetch_array($info)) {
													echo "<option value='". $row['vendor_name'] ."'>". $row['vendor_name'] ."</option>";
												}
											?>
										</select>
								    </div>
								   	<div class="input-field col s6">
										<input id="com_year" name="com_year" type="number" class="validate" min="1990" max="2017" required autocomplete="off">
										<label for="com_year">Year</label>
									</div>
									<div class="input-field col s6">
										<input id="com_quantity" name="com_qty" type="number" class="validate" min="1" required autocomplete="off">
										<label for="com_qty">Quantity</label>
									</div>
									<div class="input-field col s12" style="margin-top:0px;">
										<textarea id="com_desc" name="com des" class="materialize-textarea"></textarea>
										<label for="com_des">Component description</label>
									</div>
								</div>
								<div class="col s4">
									<div id="com_image_wrap">
										<img src="uploads/comp_def.png" alt="comp_image" id="com_image_to_upload">
									</div>
									<div class="file-field input-field">
										<div class="btn <?php echo $theme; ?> darken-3">
											<span>FILE</span>
											<input type="file" name="fileToUpload" id="fileToUploadImage">
										</div>
										<div class="file-path-wrapper">
											<input class="file-path validate" type="text">
										</div>
									</div>
								</div>
							</div>
							<div id="add-com-modal-footer">
								<p class="red-text"> All fields are mandatory* </p>
								<button class="btn waves-effect waves-light <?php echo $theme; ?> darken-3" type="submit" name="submit" style="float:right;">ADD
								</button>
							</div>
						</form>
					</div>
				</div>
				
				<!-- COMPONENT ADD RESULT -->
				<?php
					if(isset($_SESSION['comp_add_result'])){
						if($_SESSION['comp_add_result'] == 'FAIL') {
							echo "<div id='modal-comp-add-result' class='modal'>
								<div class='modal-content'>
									<h4>ADD COMPONENT!</h4>
									<p id='modal-delete-description'> Your component was not added due to some error :( <br><br> Please try again.</p>
								</div>
								<div class='modal-footer'>
									<a href='#' class='modal-action modal-close waves-effect waves-yellow btn-flat'>CLOSE</a>
								</div>
							</div>";
						}
						else {
							if($_SESSION['comp_image_upload_result'] == "FAIL") {
								echo "<div id='modal-comp-add-partial-result' class='modal'>
								<div class='modal-content'>
									<h4>ADD COMPONENT!</h4>
									<p id='modal-delete-description'> Your component was added successfully, however there was an error seting image for the component :( <br><br> {$_SESSION['comp_image_upload_error_message']} </p>
								</div>
								<div class='modal-footer'>
									<a href='#' class='modal-action modal-close waves-effect waves-yellow btn-flat'>CLOSE</a>
								</div>
							</div>";
							}
						}
					}
				?>
		</section>
		<!-- FOOTER SECTION -->
        <footer class="page-footer <?php echo $theme; ?> darken-3">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">SOIS Inventory</h5>
                <p class="grey-text text-lighten-4">Designed and developed by bnayagrawal.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="https://facebook.com/bnayagrawal"><i class="fa fa-facebook-official" aria-hidden="true" style="margin-right: 6px;"></i> facebook</a></li>
                  <li><a class="grey-text text-lighten-3" href="https://twitter.com/bnayagrawal"><i class="fa fa-twitter" aria-hidden="true" style="margin-right: 6px;"></i> twitter</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright" style="background-color:rgba(0,0,0,0.1);">
            <div class="container">
            © <?php echo date("Y"); ?> School Of Information Sciences | Manipal University
            <a class="grey-text text-lighten-4 right" href="https://github.com/bnayagrawal"><i class="fa fa-github" aria-hidden="true" style="margin-right: 6px;"></i>bnayagrawal</a>
            </div>
          </div>
        </footer>

		<!-- SCRIPTS -->
		<script src="https://use.fontawesome.com/9bb8709353.js"></script>
		<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/materialize/js/materialize.min.js"></script>
		<script>
			 $(window).on('load', function () {
				$("#pre-loader").fadeToggle("slow");
			});
			var sd;
			$("#url-theme").attr("content",$(".<?php echo $theme; ?>.darken-3").css("background-color"));
			$("document").ready(function(){
				/* UPLOAD IMAGE PREVIEW */
				window.URL    = window.URL || window.webkitURL;
				var elBrowse  = document.getElementById("fileToUploadImage"),
					elPreview = document.getElementById("com_image_wrap"),
					useBlob   = false && window.URL; // `true` to use Blob instead of Data-URL

				function readImage (file) {
					var reader = new FileReader();
					reader.addEventListener("load", function () {
						var image  = new Image();
						image.addEventListener("load", function () {
							var imageInfo = ' '+
								image.width  +'×'+
								image.height +' '+
								file.type    +' '+
								Math.round(file.size/1024) +'KB';
						});
						document.getElementById("com_image_to_upload").src = useBlob ? window.URL.createObjectURL(file) : reader.result;
						if (useBlob) {
							window.URL.revokeObjectURL(file); // Free memory
						}
					});
					reader.readAsDataURL(file);  
				}

				elBrowse.addEventListener("change", function() {
					var files  = this.files;
					var errors = "";
					if (!files) {
						errors += "File upload not supported by your browser.";
					}
					
					if (files && files[0]) {
						for(var i=0; i<files.length; i++) {
							var file = files[i];
							if ((/\.(png|jpeg|jpg|gif)$/i).test(file.name) ) {
								readImage( file ); 
							}
							else {
								errors += file.name +" Unsupported Image extension\n";  
							}
						}
					}
				  
					if (errors) {
						alert(errors); 
					}
				});
				
				$(".dropdown-button").dropdown();
				$(".button-collapse").sideNav();
				$('select').material_select();
				$('input.autocomplete').autocomplete({
					data: {
					  "Apple": null,
					  "Microsoft": null,
					  "Google": 'http://placehold.it/250x250'
					}
				  });
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
				if(isset($_SESSION['comp_add_result'])){
					if($_SESSION['comp_add_result'] == "PASS") {
						if($_SESSION['comp_image_upload_result'] == "PASS") {
							echo "Materialize.toast('Component added successfully', 3000, 'rounded')";
							unset($_SESSION['comp_image_upload_result']);
							unset($_SESSION['comp_add_result']);
						}
						else {
							echo "$('#modal-comp-add-partial-result').modal('open');";
							unset($_SESSION['comp_image_upload_result']);
							unset($_SESSION['comp_add_result']);
						}
					}
					else {
						echo "$('#modal-comp-add-result').modal('open');";
						unset($_SESSION['comp_add_result']);
						unset($_SESSION['comp_image_upload_result']);
					}
				}
			?>
			
			function addComponentHide() {
				$("#add-com-modal-wrapper").animate({top:'-12%'});
				$("#add-com-modal-background").fadeToggle();
				$("#add-com-modal-wrapper").css("top","12%");
			}
			
			function addComponentShow() {
				$("#add-com-modal-wrapper").css("top","-12%");
				$("#add-com-modal-background").fadeToggle();
				$("#add-com-modal-wrapper").animate({top:'12%'});
			}
			
			$(".component-card-image").load(function(){
				alert("hello");
				$(".preloader-wrapper").hide();
				$(".component-card-image").show();
			});
			
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
							var sri = "<img class='search-result-image' src='" + object.component_info[item].component_image + "'>";
							var srd = "<div class='search-result-description' id='srd-" + rcount + "'>";
								//highlight search string
								var comp_name = object.component_info[item].component_name;
								comp_name = comp_name.toLowerCase();
								var s_pos = comp_name.indexOf(search_string);
								var keyword_length = search_string.length;
								var part_one = comp_name.slice(0,s_pos);
								var part_two = comp_name.substr(s_pos + keyword_length,comp_name.length);
							var srcn = "<a href='admin_inside_component.php?myName=" + object.component_info[item].component_name + "' class='search-result-component-name truncate'>" + part_one + "<span class='search-keyword <?php echo $theme; ?>-text'>"+ search_string +"</span>"+ part_two + "</h4>";
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
				  xhttp.open("GET", "database/getComponentDetails.php?component_name=" + search_string, true);
				  xhttp.send();
			}
			
		</script>
	</body>
</html>

