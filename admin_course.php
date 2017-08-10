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
		<link href="assets/css/admin_course_style.css" rel="stylesheet" type="text/css" /> 
		<link rel="stylesheet" href="assets/css/form_theme_<?php echo $theme; ?>.css" id="form-element-theme">
		
	</head>
	<body onresize="setModalResultHeight()">
		<!-- FIXED FLOATING BUTTON -->
		<div class="fixed-action-btn click-to-toggle">
			<a class="btn-floating btn-large <?php echo $theme; ?> darken-3">
				<i class="large material-icons">add</i>
			</a>
			<ul>
				<li><a class="btn-floating <?php echo $theme; ?> darken-3 tooltipped" id="btn-add-course" data-position="left" data-delay="50" data-tooltip="Add Course"><i class="material-icons white-text">class</i></a></li>
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
					<li class="active"><a href="#">Course</a></li>
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
			<li><a class="waves-effect" href="admin_component.php"><i class="material-icons">dashboard</i>Component</a></li>
			<li><a class="waves-effect" href="admin_user.php"><i class="material-icons">account_circle</i>User</a></li>
			<li><a class="waves-effect" href="admin_reservation.php"><i class="material-icons">star</i>Reservation</a></li>
			<li><a class="waves-effect" href="#"><i class="material-icons">book</i>Course</a></li>
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
				<div class="row" style="margin:0px;padding:10px;">
					<div class="white col s12">
						<p class="<?php echo $theme; ?>-text text-darken-3" id="current-location"><i class="material-icons prefix">home</i> Home / Course </p>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m6 l6" style="margin-bottom:10px;">
						<!-- ALL COURSE -->
						<div id="course-wrapper" class="white z-depth-2">
							<table class="striped responsive-table" id="course-table">
								<thead>
								  <tr>
									<th data-field="Id">Id</th>
									<th data-field="Course">Course</th>
									<th data-field="Students">Students</th>
									<th data-field="Menu">Menu</th>
									<th data-field="View">View</th>
								  </tr>
								</thead>
								<tbody>
									<?php
										require_once('database/config.php');
										$info = mysqli_query($mysqli,"SELECT course_id, course_name FROM course");

										while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
											//fetch student count
											$q = mysqli_query($mysqli,'SELECT count(student_username) as count FROM student WHERE course_id='.$row['course_id']);
											while($rec=mysqli_fetch_array($q,MYSQLI_ASSOC)) {
												$std_count = $rec['count'];					
											}
											
											echo "<tr>
													<td>{$row['course_id']}</td>
													<td>{$row['course_name']}</td>
													<td>{$std_count}</td>
													<td>
														<a href='#' onclick='setCourseInfo(\"{$row['course_name']}\",\"{$row['course_id']}\");' data-activates='dropdown-option-{$row['course_id']}' class='dropdown-button dropdown-user-option'>
															<i class='material-icons course_option_menu_icon grey-text'>more_vert</i>
														</a>
													</td>
													
													<ul id='dropdown-option-{$row['course_id']}' class='dropdown-content'>
														<li><a href='#!' class='<?php echo $theme; ?>-text text-darken-3 btn-edit-course'><i class='material-icons <?php echo $theme; ?>-text text-darken-3'>mode_edit</i>Edit</a></li>
														<li><a href='#!' class='<?php echo $theme; ?>-text text-darken-3' onclick='confirmDialog()'><i class='material-icons <?php echo $theme; ?>-text text-darken-3'>delete_forever</i>Delete</a></li>
													</ul>
								
													<td>
														<input class='with-gap' name='course_radio' type='radio' id='id_{$row['course_name']}' value='{$row['course_id']}' onclick='listUsers(this.value,\"{$row['course_name']}\");'/>
														<label for='id_{$row['course_name']}'></label>
													</td>
												 </tr>";
										}
										
										mysqli_close($mysqli);
								  ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col s12 m6 l6">
						<ul class='collection z-depth-2 white' id='selected-course-collection'>
							<li class='collection-header'><h4 class='center' id='selected-course-title'>Select a course to view students</h4></li>
							<div id="collection-item">
							<!-- SAMPLE [STUDENT LIST]
							<li class='collection-item avatar' id='collection-item-{$user_username}'>
								<img src='{$user_image}' alt='{$user_name}' class='circle'>
								<span class='title black-text'>{$user_name}</span>
								<p class='grey-text collection-description'>Email : {$user_email}<br>
									 Phone : {$user_phone}
								</p>
							</li>
							-->
							</div>
						</ul>
					</div>
				</div>
				
				<!-- DELETE COURSE MODAL -->
				<div id="modal-delete-course" class="modal">
					<div class="modal-content">
						<h4>Confirm delete</h4>
						<p id="modal-delete-course-description">Are you sure you want to delete </p>
					</div>
					<div class="modal-footer">
						<a href="#" onclick="Materialize.toast('Task canceled', 3000);" class="modal-action modal-close waves-effect waves-green btn-flat">CANCEL</a>
						<a href="#" onclick="performDeleteCourse();" class="modal-action modal-close waves-effect waves-red btn-flat">DELETE</a>
					</div>
				</div>
				
				<!-- ADD COURSE FAILED MODAL -->
				<div id="modal-add-course-failed" class="modal">
					<div class="modal-content">
						<h4>OOPS!</h4>
						<p>There was an error adding/updating the course :( <br><br>Do you want to retry?</p>
					</div>
					<div class="modal-footer">
						<a href="#" id="retry-add-course" class="modal-action modal-close waves-effect waves-green btn-flat">YES</a>
						<a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">NO</a>
					</div>
				</div>
				
				<!-- ADD COURSE CUSTOM MODAL -->
				<div id="add-course-modal-background">
					<div id="add-course-modal-wrapper" class="white z-depth-3">
						<form id="add-course-modal-content">
							<div id="add-course-modal-header">
								<h4 class="<?php echo $theme; ?>-text text-darken-3" id="add-course-modal-heading"> Add course <i class="material-icons btn-close-modal" onclick='closeCourseModal()' title="close">close</i></h4>
							</div>
							<div id="add-course-modal-inputs" class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix grey-text text-darken-2">book</i>
									<input id="course_name_input" name="course_name" type="text" class="validate add-user-input" autofocus required autocomplete="off" maxlength="25" length="25" onkeyup="checkCourse(this.value)">
									<label for="course_name_input">Enter a unique course name</label>
								</div>
							</div>
							<div id="add-course-modal-footer">
								<a class="btn waves-effect waves-light <?php echo $theme; ?> darken-3 disabled" onclick="addCourse($('#course_name_input').val());" id="add-btn" style="float:right;">ADD COURSE</a>
							</div>
						</form>
					</div>
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
		<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/materialize/js/materialize.min.js"></script>
		<script>
			var sd;
			$("#url-theme").attr("content",$(".<?php echo $theme; ?>.darken-3").css("background-color"));
			$("document").ready(function(){
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
					document.getElementById("search-modal-result-wrapper").style.height = (window.innerHeight - 60) + "px";
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
				

				
				$('#custom-drop-button').dropdown({constrain_width:true});

				$('.dropdown-user-option').dropdown({
					inDuration: 300,
      				outDuration: 225,
      				constrainWidth: false, // Does not change width of dropdown to that of the activator
      				hover: false, // Activate on hover
      				gutter: 0, // Spacing from edge
      				belowOrigin: false, // Displays dropdown below the button
      				alignment: 'left', // Displays dropdown with edge aligned to the left of button
				});
				
				$("#btn-add-course,#retry-add-course").click(function(){
					$("#add-course-modal-heading").html("Add course <i class='material-icons btn-close-modal' title='close' onclick='closeCourseModal()'>close</i>");
					$("#add-btn").text("ADD COURSE");
					course_option = "add";
					$("#add-course-modal-wrapper").css("top","-10%");
					$("#add-course-modal-background").fadeToggle();
					$("#add-course-modal-wrapper").animate({top:'10%'});
				});
			});
			
			function toggleSearchModal() {
				document.getElementById("search-modal-result-wrapper").style.height = (window.innerHeight - 60) + "px";
				$("#search-modal-wrapper").slideToggle(function(){
					$("#search-modal-background").fadeToggle();
				});
			}
			
			//Holds course info and options
			var course_name_o;
			var course_id_o;
			var course_option;
			
			//close modal
			function closeCourseModal(){
				$("#add-course-modal-wrapper").animate({top:'-10%'});
				$("#add-course-modal-background").fadeToggle();
				$("#add-course-modal-wrapper").css("top","10%");	
			}
			
			//set option for current course menu
			function setCourseInfo(course_name,course_id) {
				course_name_o = course_name;
				course_id_o = course_id;
			}
			
			//to update
			$('.btn-edit-course').click(function(){
				$("#add-course-modal-heading").html("Update " + course_name_o + "<i class='material-icons btn-close-modal' title='close' onclick='closeCourseModal()'>close</i>");
				$("#add-btn").text("UPDATE");
				course_option = "update";
				$("#add-course-modal-wrapper").css("top","-10%");
				$("#add-course-modal-background").fadeToggle();
				$("#add-course-modal-wrapper").animate({top:'10%'});
			});
				
			//to delete course confirm
			function confirmDialog(){
				document.getElementById("modal-delete-course-description").innerHTML = "Are you sure you want to delete <strong>" + course_name_o + "</strong>? This can not be undone.";
				$('#modal-delete-course').modal('open');
			}
			
			//to delete course
			function performDeleteCourse(){
				
			}
			
			//list users for the course
			function listUsers(course_id,course_name) {
				$.post("database/getUserDetails.php",
				{
				  course_id_post: course_id
				},
				function(data,status){
					if(status == 'success') {
						var object = JSON.parse(data);
						
						//remove all childs from collection-item div element
						$("#collection-item").empty();

						//parse and list students
						var img,span,p,li,li_id;
						for(item in object.user_info) {
							img = "<img src='" + object.user_info[item].user_image + "' alt='user image' class='circle'>";
							span = "<span class='title black-text'>" + object.user_info[item].user_name + "</span>";
							p = "<p class='grey-text collection-description'>Email : " + object.user_info[item].user_email + "<br>Phone : " + object.user_info[item].user_phone +"</p>";
							li = "<li class='collection-item avatar' style='display:none;' id='collection-item-" + object.user_info[item].user_username + "'>";
							li_id = "#collection-item-" + object.user_info[item].user_username;
							$("#collection-item").append(li);
							$(li_id).append(img);
							$(li_id).append(span);
							$(li_id).append(p);
							$(li_id).fadeToggle('slow');
						}
						
						//If no. of students equals zero
						if(Object.keys(object.user_info).length == 0) {
							li = "<li class='collection-item avatar' style='display:none;padding-left:0px !important;' id='collection-item-null" + "'>";
							li_id = "#collection-item-null";
							var inf = "<h4 style='text-align:center;'> No students to show! </h4>";
							$("#collection-item").append(li);
							$(li_id).append(inf);
							$(li_id).fadeToggle('slow');
						}

						//Set course title
						$("#selected-course-title").html("Students of <span class='<?php echo $theme; ?>-text text-darken-3'>" + course_name + "</span>");
					}
					else
						Materialize.toast('Error fetching data from server',3000);
				});
			}
			
			//check for course name availablility, if available enable add button
			function checkCourse(course_name_s) {
				if((course_name_s.length) == 0) {
					$("#add-btn").addClass("disabled");
					return;
				}
				
				$.post("database/checkCourseAvailability.php",
				{
				  course_name: course_name_s
				},
				function(data,status){
					if(status == 'success') {
						if(data == 'true')
							$("#add-btn").removeClass("disabled");
						else
							$("#add-btn").addClass("disabled");
					}
					else
						Materialize.toast('Error fetching data from server',3000);
				});
			}
			
			//To add a course
			function addCourse(course_name_add) {
				if((course_name_add.length) == 0) {
					Materialize.toast("Course name empty!",3000);
					return;
				}
				
				course_name_add = course_name_add.trim();
				$("#add-course-modal-wrapper").animate({top:'-10%'});
				$("#add-course-modal-background").fadeToggle();
				$("#add-course-modal-wrapper").css("top","10%");
				
				$.post("database/addNewCourse.php",
				{
				  course_name: course_name_add,
				  course_option_post: course_option,
				  course_old: course_name_o
				},
				function(data,status){
					if(status == 'success') {
						if(course_option == 'update'){
							if(data == 'success')
								Materialize.toast("Course name updated. Reload this page.",3000);
							else
								$("#modal-add-course-failed").modal('open');
						}
						else {
							if(data == 'success')
								Materialize.toast("Course added successfully. Reload this page.",3000);
							else
								$("#modal-add-course-failed").modal('open');
						}
					}
					else
						Materialize.toast('Error fetching data from server',3000);
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
			
			function setModalResultHeight() {
				document.getElementById("search-modal-result-wrapper").style.height = (window.innerHeight - 60) + "px";
			}
		</script>
	</body>
</html>

