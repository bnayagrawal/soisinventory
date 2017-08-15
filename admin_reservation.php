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
					<li><a href="admin_component.php">Component</a></li>
					<li class="active"><a href="#">Reservation</a></li>
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
						<img class="responsive-img" src="assets/img/mu3.jpg" style="filter: blur(4px);">
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
			<li><a class="waves-effect" href="#"><i class="material-icons">star</i>Reservation</a></li>
			<li><a class="waves-effect" href="admin_course.php"><i class="material-icons">book</i>Course</a></li>
			<li><a class="waves-effect" href="admin_vendor.php"><i class="material-icons">business</i>Vendor</a></li>
		</ul>
		<!-- SECTION CONTENT -->
		<section>
				<div class="row" style="margin:0px;padding:10px 10px 0px 10px;">
					<div class="white col s12">
						<p class="<?php echo $theme; ?>-text text-darken-3" id="current-location"><i class="material-icons prefix">home</i> Home / Reservations </p>
					</div>
				</div>

				<div class="row">
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
                                </div>
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
            <a class="grey-text text-lighten-4 right" href="https://github.com/bnayagrawal"><i class="fa fa-github" aria-hidden="true" style="margin-right: 6px;"></i>bnayagrawal</a>
            </div>
          </div>
        </footer>

		<!-- SCRIPTS -->
		<script src="https://use.fontawesome.com/9bb8709353.js"></script>
		<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="assets/materialize/js/materialize.min.js"></script>
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

