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
		<meta name="theme-color" content="#1565C0" id="url-theme">
	  
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="assets/materialize/css/materialize.min.css"  media="screen,projection"/>
		<link href="assets/css/admin_vendor_style.css" rel="stylesheet" type="text/css" /> 
		<link rel="stylesheet" href="assets/css/form_theme_<?php echo $theme; ?>.css" id="form-element-theme">
	</head>
	<body>
		<!-- FIXED FLOATING BUTTON -->
		<div class="fixed-action-btn click-to-toggle">
			<a class="btn-floating btn-large <?php echo $theme; ?> darken-3">
				<i class="large material-icons">add</i>
			</a>
			<ul>
				<li><a class="btn-floating <?php echo $theme; ?> darken-3 tooltipped" id="btn-add-vendor" data-position="left" data-delay="50" data-tooltip="Add Vendor"><i class="material-icons white-text">business</i></a></li>
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
					<li><a class="dropdown-button" id="custom-drop-button" href="#!" data-activates="dropdown1"><img src="<?php require_once('database/config.php'); 
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
					<li><a href="admin_component.php">Component</a></li>
					<li><a href="admin_reservation.php">Rreservation</a></li>
					<li><a href="admin_course.php">Course</a></li>
					<li class="active"><a href="#">Vendor</a></li>
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
			<li><a class="waves-effect" href="admin_component.php"><i class="material-icons">dashboard</i>Component</a></li>
			<li><a class="waves-effect" href="admin_user.php"><i class="material-icons">account_circle</i>User</a></li>
			<li><a class="waves-effect" href="admin_reservation.php"><i class="material-icons">star</i>Reservation</a></li>
			<li><a class="waves-effect" href="admin_course.php"><i class="material-icons">book</i>Course</a></li>
			<li><a class="waves-effect" href="#"><i class="material-icons">business</i>Vendor</a></li>
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
				<div class="row" style="margin:0px;padding:10px;">
					<div class="white col s12">
						<p class="<?php echo $theme; ?>-text text-darken-3" id="current-location"><i class="material-icons prefix">home</i> Home / Vendor </p>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<!-- ALL VENDOR -->
						<div id="vendor-wrapper" class="white z-depth-2">
							<table class="striped responsive-table" id="course-table">
								<thead>
								  <tr>
									<th data-field="Name">Name</th>
									<th data-field="Address">Address</th>
									<th data-field="City">City</th>
									<th data-field="State">State</th>
									<th data-field="Country">Country</th>
									<th data-field="Components">Components</th>
									<th data-field="Menu">Menu</th>
								  </tr>
								</thead>
								<tbody>
									<?php
										require_once('database/config.php');
										$info = mysqli_query($mysqli,"SELECT vendor_id, vendor_name, vendor_address, vendor_city, vendor_state, vendor_country FROM `vendor`");

										while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
											//fetch component count
											$q = mysqli_query($mysqli,'SELECT count(vendor_id) as count FROM component WHERE vendor_id='.$row['vendor_id']);
											while($rec=mysqli_fetch_array($q,MYSQLI_ASSOC)) {
												$cmp_count = $rec['count'];					
											}
											
											echo "<tr>
													<td id='td-name-{$row['vendor_id']}'>{$row['vendor_name']}</td>
													<td id='td-address-{$row['vendor_id']}'>{$row['vendor_address']}</td>
													<td id='td-city-{$row['vendor_id']}'>{$row['vendor_city']}</td>
													<td id='td-state-{$row['vendor_id']}'>{$row['vendor_state']}</td>
													<td id='td-country-{$row['vendor_id']}'>{$row['vendor_country']}</td>
													<td>{$cmp_count}</td>
													<td>
														<a href='#' onclick='setVendoInfo(\"{$row['vendor_name']}\",\"{$row['vendor_id']}\");' data-activates='dropdown-option-{$row['vendor_id']}' class='dropdown-button'>
															<i class='material-icons course_option_menu_icon grey-text'>more_vert</i>
														</a>
													</td>
													
													<ul id='dropdown-option-{$row['vendor_id']}' class='dropdown-content dropdown-user-option'>
														<li><a href='#!' class='<?php echo $theme; ?>-text text-darken-3' onclick='showEditVendorModal(\"{$row['vendor_name']}\",\"{$row['vendor_id']}\")'><i class='material-icons <?php echo $theme; ?>-text text-darken-3 user-dropdown-option-icon'>mode_edit</i>Edit</a></li>
														<li><a href='#!' class='<?php echo $theme; ?>-text text-darken-3' onclick='confirmDialog()'><i class='material-icons <?php echo $theme; ?>-text text-darken-3 user-dropdown-option-icon'>delete_forever</i>Delete</a></li>
													</ul>
												 </tr>";
										}
										
										mysqli_close($mysqli);
								  ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<!-- ADD/EDIT VENDOR MODAL -->
				<div id="add-vendor-modal-background">
					<div id="add-vendor-modal-wrapper" class="white z-depth-3">
						<form id="add-vendor-modal-content" action="database/addNewVendor.php" name="add-edit-vendor-form" method="POST" enctype="multipart/form-data">
							<div id="add-vendor-modal-header">
								<h4 class="<?php echo $theme; ?>-text text-darken-3" id="avmh"> Add new vendor <i class="material-icons" id="btn-close-modal" title="close">close</i></h4>
							</div>
							<div id="add-vendor-modal-inputs" class="row">
								<!-- THIS HIDDEN INPUT ATTRIBUTE IS REQUIRED FOR UPDATE -->
								<input type="text" id="input_vendor_id" name="vendor_id" style="display:none;" value="">
								<div class="input-field col s12">
									<input id="input_vendor_name" name="vendor_name" type="text" class="validate add-vendor-input" required autocomplete="off" maxlength="25" length="25" autofocus>
									<label for="input_vendor_name">Vendor Name</label>
								</div>
								<div class="input-field col s12">
									<input id="input_vendor_city" name="vendor_city" type="text" maxlength="70" length="70" class="validate add-vendor-input" required autocomplete="off" autofocus>
									<label for="input_vendor_city">Vendor City</label>
								</div>
								<div class="input-field col s12">
									<input id="input_vendor_state" name="vendor_state" type="text" class="validate add-vendor-input" required autocomplete="off" maxlength="50" length="50" autofocus>
									<label for="input_vendor_state">Vendor State</label>
								</div>
								<div class="input-field col s12">
									<input id="input_vendor_country" name="vendor_country" type="text" class="validate add-vendor-input" maxlength="70" lenght="70" required autocomplete="off" autofocus>
									<label for="input_vendor_country">Vendor Country</label>
								</div>
								<div class="input-field col s12">
									<input id="input_vendor_address" name="vendor_address" type="text" class="validate add-vendor-input" maxlength="250" lenght="250" required autocomplete="off" autofocus>
									<label for="input_vendor_address">Vendor Address</label>
								</div>
							</div>
							<div id="add-vendor-modal-footer">
								<p class="red-text"> All fields are mandatory* </p>
								<button class="btn waves-effect waves-light <?php echo $theme; ?> darken-3" type="submit" name="submit" style="float:right;">SUBMIT
								</button>
							</div>
						</form>
					</div>
				</div>
				
				<?php
					if(isset($_SESSION['vendor-add-result'])){
						if(!$_SESSION['vendor-add-result']){
							echo "<div id='modal-vendor-add-result' class='modal'>
									<div class='modal-content'>
										<h4>OOPS!</h4>
										<p id='modal-delete-description'>There was an error occured! Vendor was not added :(<br><br> Do you want to retry? </p>
									</div>
									<div class='modal-footer'>
										<a href='#' class='modal-action modal-close waves-effect waves-yellow btn-flat'>CANCEL</a>
										<a href='#' id='retry-add-vendor' class='modal-action modal-close waves-effect waves-green btn-flat'>YES</a>
									</div>
							</div>";
						}
					}
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
            <a class="grey-text text-lighten-4 right" href="#!">@bnayagrawal</a>
            </div>
          </div>
		</footer>
		
		<!-- SCRIPTS -->
		<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/materialize/js/materialize.min.js"></script>
		<script>
			var sd;
			$("#url-theme").attr("content",$(".<?php echo $theme; ?>.darken-3").css("background-color"));
			$("document").ready(function(){
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
				
				$('.dropdown-button').dropdown({
					inDuration: 300,
					outDuration: 225,
					constrain_width: false, // Does not change width of dropdown to that of the activator
					hover: false, // Activate on hover
					gutter: 0, // Spacing from edge
					belowOrigin: false, // Displays dropdown below the button
					alignment: 'left' // Displays dropdown with edge aligned to the left of button
				});
				
				$('#custom-drop-button').dropdown({constrain_width:true});
				
				$("#btn-close-modal").click(function(){
					$("#add-vendor-modal-wrapper").animate({top:'-10%'});
					$("#add-vendor-modal-background").fadeToggle();
					$("#add-vendor-modal-wrapper").css("top","10%");
				});
				
				$("#btn-add-vendor,#retry-add-vendor").click(function(){
					$("#avmh").html("Add new vendor" + "<i class=\"material-icons\" id=\"btn-close-modal\" onclick='closeVendorModal()' title=\"close\">close</i>");
					$("form[name='add-edit-vendor-form']").attr("action","database/addNewVendor.php");
					$("form[name='add-edit-vendor-form']").find("input[type='text']").val("");
					
					$("#add-vendor-modal-wrapper").css("top","-10%");
					$("#add-vendor-modal-background").fadeToggle();
					$("#add-vendor-modal-wrapper").animate({top:'10%'});
				});
			});
			
			function closeVendorModal() {
				$("#add-vendor-modal-wrapper").animate({top:'-10%'});
				$("#add-vendor-modal-background").fadeToggle();
				$("#add-vendor-modal-wrapper").css("top","10%");				
			}
			
			function toggleSearchModal() {
				document.getElementById("search-modal-result-wrapper").style.height = (window.innerHeight - 60) + "px";
				$("#search-modal-wrapper").slideToggle(function(){
					$("#search-modal-background").fadeToggle();
				});
			}
			
			//Notify on vendor add success
			<?php
				//ADD VENDOR RESULT
				if(isset($_SESSION["vendor-add-result"])){
					if($_SESSION["vendor-add-result"]){
						echo "Materialize.toast('Vendor has been added successfully',3000,'rounded');";
						unset($_SESSION["vendor-add-result"]);
					}
					else {
						echo "$('#modal-vendor-add-result').modal('open');";
						unset($_SESSION["vendor-add-result"]);
					}
				}
				
				//UPDATE VENDOR RESULT
				if(isset($_SESSION["vendor-update-result"])){
					if($_SESSION["vendor-update-result"]){
						echo "Materialize.toast('Vendor info has been updated successfully',3000,'rounded');";
						unset($_SESSION["vendor-update-result"]);
					}
					else {
						echo "Materialize.toast('<span style='color:red;'>Failed to update vendor info</span>',3000,'rounded');";
						unset($_SESSION["vendor-update-result"]);
					}
				}
			?>
			
			//VENDOR VARIABLES FOR CONTEXT MENU
			var v_name_c;
			var v_id_c;
			
			function setVendoInfo(vendor_name,vendor_id) {
				v_id_c = vendor_id;
				v_name_c = vendor_name;
			}
			
			function showEditVendorModal(vendor_name,vendor_id) {
				$("#avmh").html("Edit " + vendor_name + "<i class=\"material-icons\" onclick='closeVendorModal()' id='btn-close-modal' title=\"close\">close</i>");
				
				//set form input values
				$("#input_vendor_name").val($("#td-name-" + vendor_id).text());
				$("#input_vendor_city").val($("#td-city-" + vendor_id).text());
				$("#input_vendor_state").val($("#td-state-" + vendor_id).text());
				$("#input_vendor_country").val($("#td-country-" + vendor_id).text());
				$("#input_vendor_address").val($("#td-address-" + vendor_id).text());
				$("#input_vendor_id").attr("value",vendor_id);
				
				//set form action
				$("form[name='add-edit-vendor-form']").attr("action","database/updateVendorInfo.php");
				
				//show edit vendor form
				$("#add-vendor-modal-wrapper").css("top","-10%");
				$("#add-vendor-modal-background").fadeToggle();
				$("#add-vendor-modal-wrapper").animate({top:'10%'});
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

