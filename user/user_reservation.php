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
		<link href="../assets/css/user_reservation_style.css" rel="stylesheet" type="text/css" /> 
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
					<li><a href="user_component.php">Component</a></li>
					<li class="active"><a href="#">Rreservation</a></li>
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
			<li><a class="waves-effect" href="user_component.php"><i class="material-icons">dashboard</i>Component</a></li>
			<li><a class="waves-effect" href="#"><i class="material-icons">star</i>Reservation</a></li>
		</ul>
		
		<!-- SECTION CONTENT -->
		<section>
				<div class="row" style="margin:0px;padding:10px;">
					<div class="white col s12">
						<p class=" <?php echo $theme; ?>-text text-darken-3" id="current-location"><i class="material-icons prefix">home</i> Home / Reservations </p>
					</div>
				</div>
				
				<div class="row">
					<div class="col s12">
						<!-- RESERVED COMPONENTS -->
						<div id="reserved-component-wrapper" class="white z-depth-2 reservation">
							<h4 class="reservation-heading"> Reserved Components </h4>
							<table class="striped responsive-table" id="course-table">
								<thead>
								  <tr>
									<th data-field="reservation_id">Reservation ID</th>
									<th data-field="Component">Component</th>
									<th data-field="reservation_date">Reservation Date</th>
									<th data-field="borrowed_date">Borrowed Date</th>
									<th data-field="days_left">Days Left</th>
								  </tr>
								</thead>
								<tbody>
									<?php
										require_once('../database/config.php');
										$info = mysqli_query($mysqli,"SELECT reservation_id,reservation_date,borrowed_date,days_left,reserved.component_id,component_name FROM reserved,component WHERE reserved.user_name='{$current_user}' AND reserved.component_id=component.component_id");

										while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
											echo "<tr>
													<td>{$row['reservation_id']}</td>
													<td>{$row['component_name']}<br>ID : {$row['component_id']}</td>
													<td>{$row['reservation_date']}</td>
													<td>{$row['borrowed_date']}</td>
													<td>{$row['days_left']}</td>
												 </tr>";
										}
								  ?>
								</tbody>
							</table>
						</div>
					</div>		
				</div>
				
				<div class="row">
					<div class="col s12">
						<!-- PENDING RESERVATION -->
						<div id="reservation-pending-wrapper" class="white z-depth-2 reservation">
							<h4 class="reservation-heading"> Pending Reservations </h4>
							<table class="striped responsive-table" id="course-table">
								<thead>
								  <tr>
									<th data-field="reservation_id">Reservation ID</th>
									<th data-field="Component">Component</th>
									<th data-field="reservation_date">Reservation Date</th>
									<th data-field="borrowing_date">Borrowing Date</th>
									<th data-field="for_days">For Days</th>
									<th data-field="action">Action</th>
								  </tr>
								</thead>
								<tbody>
									<?php
										require_once('../database/config.php');
										$info = mysqli_query($mysqli,"SELECT * FROM reservation WHERE user_name='{$current_user}'");

										while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
											echo "<tr id='row-{$row['reservation_id']}'>
													<td>{$row['reservation_id']}</td>
													<td>{$row['component_name']}</td>
													<td>{$row['reservation_date']}</td>
													<td>{$row['borrowing_date']}</td>
													<td>{$row['for_days']}</td>
													<td><i class='material-icons grey-text' style='cursor:pointer;' onclick='confirmDelete({$row['reservation_id']})'>delete_forever</i>
												 </tr>";
										}
								  ?>
								</tbody>
							</table>
						</div>
					</div>		
				</div>
				
				<div class="row">
					<div class="col s12">
						<!-- CANCELED RESERVATION -->
						<div id="canceled-reservation-wrapper" class="white z-depth-2 reservation">
							<h4 class="reservation-heading"> Canceled Reservations </h4>
							<table class="striped responsive-table" id="course-table">
								<thead>
								  <tr>
									<th data-field="reservation_id">Reservation ID</th>
									<th data-field="Component">Component</th>
									<th data-field="reservation_date">Reservation Date</th>
									<th data-field="borrowing_date">Borrowing Date</th>
									<th data-field="reason">Reason</th>
								  </tr>
								</thead>
								<tbody>
									<?php
										require_once('../database/config.php');
										$info = mysqli_query($mysqli,"SELECT reservation_id,reservation_date,borrowing_date,for_days,reason,component_name FROM canceled WHERE canceled.user_name='{$current_user}'");

										while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
											echo "<tr>
													<td>{$row['reservation_id']}</td>
													<td>{$row['component_name']}<br>for {$row['for_days']} days</td>
													<td>{$row['reservation_date']}</td>
													<td>{$row['borrowing_date']}</td>
													<td>{$row['reason']}</td>
												 </tr>";
										}
								  ?>
								</tbody>
							</table>
						</div>
					</div>		
				</div>
				
				<!-- DELETE RESERVATION MODAL -->
				<div id="modal-delete" class="modal">
					<div class="modal-content">
						<h4 class="black-text">Confirm delete</h4>
						<p class="black-text" id="modal-delete-description">Are you sure you want to delete reservation</p>
					</div>
					<div class="modal-footer">
						<a href="#" onclick="Materialize.toast('Task canceled',3000);" class="modal-action modal-close waves-effect waves-green btn-flat black-text">CANCEL</a>
						<a href="#" onclick="deleteReservation();" class="modal-action modal-close waves-effect waves-red btn-flat black-text">DELETE</a>
					</div>
				</div>
				
				<!-- SEARCH WINDOW -->
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
			});
			
			function toggleSearchModal() {
				document.getElementById("search-modal-result-wrapper").style.height = (window.innerHeight - 60) + "px";
				$("#search-modal-wrapper").slideToggle(function(){
					$("#search-modal-background").fadeToggle();
				});
			}
			
			var res_to_delete;
			
			function confirmDelete(reservation_id) {
				res_to_delete = reservation_id;
				$('#modal-delete').modal('open');
			}
			
			function deleteReservation() {
				$.post("../database/deleteReservation.php",
				{
				  res_id: res_to_delete
				},
				function(data,status){
					if(status == 'success') {
						var object = JSON.parse(data);
						if(data == "true") {
							Materialize.toast('Reservation deleted',3000);
							var row = "#row-" + res_to_delete;
							$(row).hide("slow",function(){
								$(row).remove();
							});
						}
						else
							Materialize.toast('Failed to delete reservation',3000);
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
							var sri = "<img class='search-result-image' src='../" + object.component_info[item].component_image + "'>";
							var srd = "<div class='search-result-description' id='srd-" + rcount + "'>";
								//highlight search string
								var comp_name = object.component_info[item].component_name;
								comp_name = comp_name.toLowerCase();
								var s_pos = comp_name.indexOf(search_string);
								var keyword_length = search_string.length;
								var part_one = comp_name.slice(0,s_pos);
								var part_two = comp_name.substr(s_pos + keyword_length,comp_name.length);
							var srcn = "<a href='user_inside_component.php?myName=" + object.component_info[item].component_name + "' class='search-result-component-name truncate'>" + part_one + "<span class='search-keyword  <?php echo $theme; ?>-text'>"+ search_string +"</span>"+ part_two + "</h4>";
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
			
			function setModalResultHeight() {
				document.getElementById("search-modal-result-wrapper").style.height = (window.innerHeight - 60) + "px";
			}
		</script>
	</body>
</html>		