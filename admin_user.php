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
	 
	 require_once('database/config.php');
	 
	 $total_students = 0;
	 $total_faculty = 0;
	 
	 $query = mysqli_query($mysqli, "select count(*) as sc from student");
	 
	 while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
		$total_students = $row['sc'];
	 }
	 
	 $query = mysqli_query($mysqli, "select count(*) as fc from faculty");
	 
	 while($row=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
		$total_faculty = $row['fc'];
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
		<link href="assets/css/admin_user_style.css" rel="stylesheet" type="text/css" /> 
		<link rel="stylesheet" href="assets/css/form_theme_<?php echo $theme; ?>.css" id="form-element-theme">
	</head>
	<body>
		<!-- FIXED FLOATING BUTTON -->
		<div class="fixed-action-btn click-to-toggle">
			<a class="btn-floating btn-large <?php echo $theme; ?> darken-3">
				<i class="large material-icons">add</i>
			</a>
			<ul>
				<li><a class="btn-floating <?php echo $theme; ?> darken-3 tooltipped" id="btn-add-student" data-position="left" data-delay="50" data-tooltip="Add Student"><i class="material-icons white-text">person_add</i></a></li>
				<li><a class="btn-floating <?php echo $theme; ?> darken-3 tooltipped" id="btn-add-faculty" data-position="left" data-delay="50" data-tooltip="Add Faculty"><i class="material-icons white-text">person_outline</i></a></li>
				<li><a class="btn-floating <?php echo $theme; ?> darken-3 tooltipped" id="btn-upload-csv" data-position="left" data-delay="50" data-tooltip="Upload CSV" onclick="toggleCsvModal('show');"><i class="material-icons white-text">file_upload</i></a></li>
			</ul>
		 </div>
		<!-- HEAD AND NAV -->
		<ul id="dropdown1" class="dropdown-content">
		  <li><a href="admin_settings.php" class="<?php echo $theme; ?>-text text-darken-3">Settings</a></li>
		  <li class="divider"></li>
		  <li><a href="logout.php" class="<?php echo $theme; ?>-text text-darken-3">Log out</a></li>
		</ul>
		<ul id="dropdown2" class="dropdown-content">
		  <li><a href="#"><i class="material-icons left">swap_vert</i>Sort</a></li>
		  <li><a href="#"><i class="material-icons left">gradient</i>Filter</a></li>
	      <li><a href="#" class="search-modal-link"><i class="material-icons left">search</i>Search</a></li>
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
							?>" id="user_icon" class="circle responsive-img"><?php echo $current_user; ?><i class="material-icons right">arrow_drop_down</i></a></li>
				</ul>
				<ul id="nav-pc" class="right hide-on-med-and-down">
					<li><a class="dropdown-button" href="#!" data-activates="dropdown2"><i class="material-icons right">view_list</i></a></li>
				</ul>
				<ul class="right hide-on-large-only">
					<li><a href="#!" onclick="toggleSearchModal();"><i class="material-icons" style="padding-right:6px;">search</i></a></li>
				</ul>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a href="admin_component.php">Component</a></li>
					<li><a href="admin_reservation.php">Reservation</a></li>
					<li><a href="admin_course.php">Course</a></li>
					<li><a href="admin_vendor.php">Vendor</a></li>
					<li class="active"><a href="#">User</a></li>
					<li>
						<!--test-->
						<div class="input-field" style="height:inherit">
          					<input id="search" type="search" placeholder="Search" required style="margin:0px;box-shadow:none;border:none;">
          					<label class="label-icon" for="search" style="top:-12px;"><i class="material-icons">search</i></label>
          					<i class="material-icons">close</i>
						</div>
						<!--end-test-->
					</li>
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
			<li><a class="waves-effect" href="#"><i class="material-icons">account_circle</i>User</a></li>
			<li><a class="waves-effect" href="admin_reservation.php"><i class="material-icons">star</i>Reservation</a></li>
			<li><a class="waves-effect" href="admin_course.php"><i class="material-icons">book</i>Course</a></li>
			<li><a class="waves-effect" href="admin_vendor.php"><i class="material-icons">business</i>Vendor</a></li>
		</ul>
		<!-- SECTION CONTENT -->
		<section>
				<!-- PATH -->
				<div class="row" style="margin:0px;padding:10px 10px 0px 10px;">
					<div class="white col s12">
						<p class="<?php echo $theme; ?>-text text-darken-3" id="current-location"><i class="material-icons prefix">home</i> Home / Users </p>
					</div>
				</div>
				<div class="row">
					<!-- USER-OPTIONS
					<ul id='dropdown-user-options' class='dropdown-content dropdown-user-option'>
						<li><a href="#!" class="<?php echo $theme; ?>-text text-darken-3"><i class='material-icons <?php echo $theme; ?>-text text-darken-3' style="position:relative;top:4px;padding-right:4px;">mode_edit</i>Edit</a></li>
						<li><a href="#!" class="<?php echo $theme; ?>-text text-darken-3" onclick="confirmDialog()" ><i class='material-icons <?php echo $theme; ?>-text text-darken-3' style="position:relative;top:4px;padding-right:4px;">delete_forever</i>Delete</a></li>
					</ul>-->
					
					<div class='col s12 m12 l6'>
						<ul class="collapsible" data-collapsible="accordion">
							<li>
							  <h4 class="user-heading">
								<span class='badge-users'>
									<span class='badge-text <?php echo $theme; ?>' id="total_user_count"><?php echo $total_students; ?> USERS</span>
								</span>
								Students
							  </h4>
							  <div class="collapsible-body white"><span></span></div>
							</li>
							<?php						
								$course = mysqli_query($mysqli, "SELECT * FROM course");
								
								while($row=mysqli_fetch_array($course,MYSQLI_ASSOC)) {
									//batch count
									$bc = 0;
									$batch_count = mysqli_query($mysqli, "SELECT count(batch) AS bcount FROM student WHERE course_id={$row['course_id']}");
									while($r = mysqli_fetch_array($batch_count,MYSQLI_ASSOC)) {
										$bc = $r['bcount'];
									}

									if(!$bc > 0)
										continue;

									echo "<li>
										<div class='collapsible-header' onclick='checkAndFillUserInfo({$row['course_id']},document.getElementById(\"select-option-for-{$row['course_id']}\").value)'>
											<div class='collapsible-title'><i class='material-icons grey-text text-darken-2'>account_circle</i>{$row['course_name']}</div>
											<div class='batch-select-wrapper'>
												<select id='select-option-for-{$row['course_id']}' onchange='fillUserInfo({$row['course_id']},this.value);'>";

									$batch = mysqli_query($mysqli, "SELECT DISTINCT batch FROM student WHERE course_id={$row['course_id']}");			
									while($rowb=mysqli_fetch_array($batch,MYSQLI_ASSOC)) {
										echo "<option value='{$rowb['batch']}'>{$rowb['batch']}</option>";
									}
									
									echo "		</select>
											</div>
										</div>
										<div class='collapsible-body white'>
											<ul class='collection'>
												<div id='user-list-{$row['course_id']}'>
												</div>
											</ul>
										</div>
									</li>";
								}
							?>
						</ul>
					</div>
					
					<div class='col s12 m12 l6'>
						<ul class='collection z-depth-1'>
							<?php
							/*********************************
							-------- FACULTY LISTING ---------
							*********************************/
							echo "<li class='collection-header'>
									<h4 class='user-heading'>
										<span class='badge-users'>
											<span class='badge-text {$theme}'>{$total_faculty} USERS</span>
										</span>
										Faculty
									</h4>
								</li>";
							
							$info = mysqli_query($mysqli, "select user_username, user_password, user_name, user_email, user_phone, user_image from user join faculty on user.user_username = faculty.faculty_username");

							while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
								$user_username = $row['user_username'];
								$user_password = $row['user_password'];
								$user_name = $row['user_name'];
								$user_email = $row['user_email'];
								$user_phone = $row['user_phone'];
								$user_image = $row['user_image'];
								$student_course = "Faculty";
								echo "<li class='collection-item avatar' id='collection-item-{$user_username}'>
										  <img src='{$user_image}' alt='{$user_name}' class='circle'>
										  <span class='title black-text'>{$user_username}</span>
										  <p class='grey-text collection-description'>Email : {$user_email}<br>
											 Phone : {$user_phone}<br>
											 Teaches
										  </p>
										  <a href='#' onclick='setUserInfo(\"{$user_username}\",\"faculty\");' data-activates='dropdown-option-{$user_username}' class='secondary-content dropdown-button'><i class='material-icons delete-link grey-text'>more_vert</i></a>
										</li>";
							
								// User-option-dropdown
								echo "<ul id='dropdown-option-{$user_username}' class='dropdown-content dropdown-user-option'>
										<li><a href='#!' class='<?php echo $theme; ?>-text text-darken-3'><i class='material-icons <?php echo $theme; ?>-text text-darken-3 user-dropdown-option-icon'>mode_edit</i>Edit</a></li>
										<li><a href='#!' class='<?php echo $theme; ?>-text text-darken-3' onclick='confirmDialog()' ><i class='material-icons <?php echo $theme; ?>-text text-darken-3 user-dropdown-option-icon'>delete_forever</i>Delete</a></li>
									</ul>";
							}
							?>
						</ul>
					</div>
				</div>
				
				<!-- DELETE USER MODAL -->
				<div id="modal-delete" class="modal">
					<div class="modal-content">
						<h4 class="black-text">Confirm delete</h4>
						<p class="black-text" id="modal-delete-description">Are you sure you want to delete </p>
					</div>
					<div class="modal-footer">
						<a href="#" onclick="cancelDelete();" class="modal-action modal-close waves-effect waves-green btn-flat black-text">CANCEL</a>
						<a href="#" onclick="performDelete();" class="modal-action modal-close waves-effect waves-red btn-flat black-text">DELETE</a>
					</div>
				</div>

				<!-- NOTIFY AFTER USER CREATION MODAL -->
				<?php
					if(isset($_SESSION['user_creation'])){
						echo "<div id='modal-user-created' class='modal'>
								<div class='modal-content'>
									<h4 class='black-text'>USER CREATED</h4>
									<p id='modal-delete-description' class='black-text'>User creation was {$_SESSION["user_creation"]}. Do you want to set image for {$_SESSION["new_user_name"]}. Press yes to set user image. </p>
								</div>
								<div class='modal-footer'>
									<a href='#' class='modal-action modal-close waves-effect waves-yellow btn-flat'>CANCEL</a>
									<a href='#' onclick='setUserImageModal();' class='modal-action modal-close waves-effect waves-green btn-flat'>YES</a>
								</div>
						</div>";
					}
				?>
				
				
				<!-- NOTIFY IMAGE UPLOAD RESULT -->
				<?php
					if(isset($_SESSION['image_upload_result'])){
						if($_SESSION['image_upload_result'] == 'FAIL') {
							echo "<div id='modal-image-upload-result' class='modal'>
								<div class='modal-content'>
									<h4>OOPS!</h4>
									<p id='modal-delete-description'> Your image was not uploaded/set due to some error :( <br><br> {$_SESSION['upload_error_message']}</p>
								</div>
								<div class='modal-footer'>
									<a href='#' class='modal-action modal-close waves-effect waves-yellow btn-flat'>CANCEL</a>
									<a href='#' onclick='setUserImageModal();' class='modal-action modal-close waves-effect waves-green btn-flat'>RETRY</a>
								</div>
							</div>";
						}
					}
				?>
				
				<!-- SET USER IMAGE MODAL -->
				<div id="set-image-modal-background">
					<div id="set-image-modal-wrapper" class="white z-depth-3">
						<div id="set-image-modal-content">
							<div id="set-image-modal-header">
								<h4 class="<?php echo $theme; ?>-text text-darken-3"> Set User Image <i class="material-icons" id="set-image-close-modal" title="Cancel and close">close</i></h4>
							</div>
							<div id="set-image-modal-section">
								<div id="set-image-modal-section-left">
									<div id="image-wrap">
										<img class="circle" id="image-to-set" src="uploads/userimage/user.png" alt="User image">
									</div>
								</div>
								<div id="set-image-modal-section-right">
									<h5 id="set-image-modal-for" class="truncate">For <span class="<?php echo $theme; ?>-text text-darken-3"><?php if(isset($_SESSION['new_user_name'])) echo $_SESSION["new_user_name"]; ?></span></h5>
									<h6 id="image-details-heading"> Image Details </h6>
									<p id="image-details">Height: <br> Width: <br> Size: </p>
								</div>
							</div>
							<div id="upload-image-section">
								<form action="database/uploadUserImage.php" id="form-upload-image" method="post" enctype="multipart/form-data">
									<div class="file-field input-field">
										<div class="btn <?php echo $theme; ?> darken-3">
											<span>FILE</span>
											<input type="file" name="fileToUpload" id="fileToUpload" form="form-upload-image">
										</div>
										<div class="file-path-wrapper">
											<input class="file-path validate" type="text">
										</div>
									</div>
								</form>
							</div>
							<div id="set-image-modal-footer">
								<p class="grey-text" id="upload-percentage"> Upload Image </p>
								<button class="btn waves-effect waves-light <?php echo $theme; ?> darken-3" type="submit" form="form-upload-image" name="action" style="float:right;">UPLOAD
									<i class="material-icons right">cloud_upload</i>
								</button>
							</div>
						</div>
					</div>
				</div>
				
				<!-- ADD NEW USER MODAL -->
				<div id="add-user-modal-background">
					<div id="add-user-modal-wrapper" class="white z-depth-3">
						<form id="add-user-modal-content" action="database/addNewUser.php" method="POST" enctype="multipart/form-data">
							<div id="add-user-modal-header">
								<h4 class="<?php echo $theme; ?>-text text-darken-3"> Create new user <i class="material-icons" id="btn-close-modal" title="close">close</i></h4>
							</div>
							<div id="add-user-modal-inputs" class="row">
								<div class="input-field col s6">
									<i class="material-icons prefix grey-text text-darken-2">perm_identity</i>
									<input id="user_name" name="user_username" type="text" class="validate add-user-input" required autocomplete="off" maxlength="25" length="25" onblur="checkUserName(this.value)">
									<label for="user_name">User Name</label>
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix grey-text text-darken-2">lock_outline</i>
									<input id="password" name="password" type="text" title="double click to generate random password" maxlength="15" length="15" class="validate add-user-input" ondblclick="this.value=randomPassword()" required autocomplete="off">
									<label for="password">Password</label>
								</div>
								<div class="input-field col s12">
									<i class="material-icons prefix grey-text text-darken-2">account_circle</i>
									<input id="full_name" name="user_name" type="text" class="validate add-user-input" required autocomplete="off" maxlength="50" length="50">
									<label for="full_name">Full Name</label>
								</div>
								<div class="input-field col s12">
									<i class="material-icons prefix grey-text text-darken-2">mail_outline</i>
									<input id="email" name="email" type="email" class="validate add-user-input" required autocomplete="off">
									<label for="email">Email</label>
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix grey-text text-darken-2">book</i>
									<select name="coursename" id="coursename">
										<?php
											require_once('database/config.php');
											$info = mysqli_query($mysqli, "select * from course");

											while ($row = mysqli_fetch_array($info)) {
												echo "<option value='". $row['course_name'] ."'>". $row['course_name'] ."</option>";
											}
										?>
									</select>
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix grey-text text-darken-2">star_border</i>
									<input id="batch" name="batch" type="number" class="validate add-user-input" min="2015" max="2017" required autocomplete="off">
									<label for="batch">Batch</label>									
								</div>
								<input type="radio" name="radio" style="display:none;" id="user_type_radio" value="student" checked>
								<div class="input-field col s12">
									<i class="material-icons prefix grey-text text-darken-2">phone_iphone</i>
									<input id="phone" name="phone" type="tel" class="validate add-user-input" required autocomplete="off" pattern="[0-9]{10}" maxlength="10" length="10">
									<label for="phone">Phone</label>
								</div>
							</div>
							<div id="add-user-modal-footer">
								<p class="red-text"> All fields are mandatory* </p>
								<button class="btn waves-effect waves-light <?php echo $theme; ?> darken-3" type="submit" name="submit" style="float:right;">CREATE
								</button>
							</div>
						</form>
					</div>
				</div>
				
				<!-- USER ID/NAME NOT AVAIALABLE MODAL -->
				<div id="modal-user-name-na" class="modal">
					<div class="modal-content">
						<h4>WAIT</h4>
						<p>User names are unique. The user name you entered is already present in our database, please choose a different user name.</p>
					</div>
					<div class="modal-footer">
						<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">CLOSE</a>
					</div>
				</div>
  
				<!-- UPLOAD CSV CUSTOM MODAL -->
				<div id="add-csv-modal-background">
					<div id="add-csv-modal-wrapper" class="white z-depth-3">
						<form id="add-csv-modal-content" action="database/importFromCsv.php" method="POST" enctype="multipart/form-data">
							<div id="add-csv-modal-header">
								<h4 class="<?php echo $theme; ?>-text text-darken-3" id="add-csv-modal-heading"> Upload CSV File <i class="material-icons btn-close-modal" onclick='toggleCsvModal("hide");' title="close">close</i></h4>
							</div>
							<div id="add-csv-modal-inputs" class="row">
								<div class="file-field input-field">
									<div class="btn <?php echo $theme; ?> darken-3">
										<span>File</span>
										<input type="file" name="CSVfile" required>
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text" placeholder="Select a csv file">
									</div>
								</div>
							</div>
							<div id="add-csv-modal-footer">
								<button class="btn waves-effect waves-light <?php echo $theme; ?> darken-3" type="submit" name="submit" style="float:right;"><i class="material-icons left">backup</i> UPLOAD
								</button>
							</div>								
						</form>
					</div>
				</div>
				
				<!-- CSV PARSE RESULT -->
				<?php
					if(isset($_SESSION['parse_result'])){
						echo "<div id='modal-parse-result' class='modal'>
							<div class='modal-content'>
								<h4>CSV IMPORT RESULT</h4>
								<p>";
								
						if($_SESSION['parse_result'] == 'success')
							echo $_SESSION["parse_details"];
						else
							echo $_SESSION["csv_parse_error"];
						
						echo "</p>
							</div>
							<div class='modal-footer'>
								<a href='#' class='modal-action modal-close waves-effect waves-yellow btn-flat'>CLOSE</a>
							</div>
						</div>";
					}
				?>				
				
				<!-- SEARCH USER WINDOW -->
				<div id="search-modal-background">
					<div id="search-modal-wrapper" class="z-depth-5">
						<div id="search-modal-bar" class="white z-depth-1">
							<form>
								<input type="text" name="search" id="search-input-for-search-modal" onkeyup="performSearch(this.value)" placeholder="Search user" autocomplete="off" autofocus>
								<i class="material-icons" id="search-icon-left" style="cursor:pointer;" onclick="toggleSearchModal()">arrow_back</i>
								<i class="material-icons dropdown-button" data-activates="search-user-dropdown" id="search-icon-right" style="cursor:pointer;">more_vert</i>
								<ul id="search-user-dropdown" class="dropdown-content" style="z-index:15;">
									<h6 class="grey-text" style="margin: 0px;padding: 12px 0px 0px 12px;">SEARCH BY</h6>
									<li><a href="#"><p style="margin-top:0px;"><input type="radio" class="with-gap" name="search-user-by" id="uname" value="user_username" checked><label for="uname">User name</label></p></a></li>
									<li><a href="#"><p style="margin-top:0px;"><input type="radio" class="with-gap" name="search-user-by" id="fname" value="user_name"><label for="fname">Full name</label></p></a></li>
									<li class="divider"></li>
									<h6 class="grey-text" style="margin: 0px;padding: 12px 0px 0px 12px;">USER TYPE</h6>
									<li><a href="#"><p style="margin-top:0px;"><input type="radio" class="with-gap" name="search-user-type" id="std" value="student" checked><label for="std">Student</label></p></a></li>
									<li><a href="#"><p style="margin-top:0px;"><input type="radio" class="with-gap" name="search-user-type" id="flt" value="faculty"><label for="flt">Faculty</label></p></a></li>
								</ul>
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
			var page_theme = "<?php echo $theme; ?>";
			
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
					$("#search-modal-background").fadeToggle(function(){
						$("#search-modal-wrapper").slideToggle();
					});
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
				
				<?php 
					if(isset($_SESSION['image_upload_result'])){
						if($_SESSION['image_upload_result'] == "PASS") {
							echo "Materialize.toast('User image has been set successfully', 3000, 'rounded')";
							unset($_SESSION['image_upload_result']);
						}
						else {
							echo "$('#modal-image-upload-result').modal('open');";
							unset($_SESSION['image_upload_result']);
						}
					}
				?>
				
				<?php
					if(isset($_SESSION["user_creation"])){
						echo "$('#modal-user-created').modal('open');";
						unset($_SESSION["user_creation"]);
					}
				?>
				
				<?php
					if(isset($_SESSION['parse_result'])) {
						echo "$('#modal-parse-result').modal('open');";
						unset($_SESSION['parse_result']);
					}
				?>
				
				$("#btn-close-modal").click(function(){
					$("#add-user-modal-wrapper").animate({top:'-10%'});
					$("#add-user-modal-background").fadeToggle();
					$("#add-user-modal-wrapper").css("top","10%");
				});
				
				$("#btn-add-student").click(function(){
					$("#add-user-modal-wrapper").css("top","-10%");
					$("#add-user-modal-background").fadeToggle();
					$("#add-user-modal-wrapper").animate({top:'10%'});
					$("#user_type_radio").val("student");
					$("#coursename").removeAttr("disabled");
					$("#batch").removeAttr("disabled");
				});
				
				$("#btn-add-faculty").click(function(){
					$("#add-user-modal-wrapper").css("top","-10%");
					$("#add-user-modal-background").fadeToggle();
					$("#add-user-modal-wrapper").animate({top:'10%'});
					$("#user_type_radio").val("faculty");
					$("#coursename").attr("disabled","true");
					$("#batch").attr("disabled","true");
				});
				
				$("#set-image-close-modal").click(function(){
					$("#set-image-modal-wrapper").animate({top:'-14%'});
					$("#set-image-modal-background").fadeToggle();
					$("#set-image-modal-wrapper").css("top","14%");
				});
				
				$('.dropdown-button').dropdown({
					inDuration: 300,
					outDuration: 225,
					constrain_width: false,
					hover: false,
					gutter: 0,
					belowOrigin: false,
					alignment: 'left'
				});
				
				$('#custom-drop-button').dropdown({constrain_width:true});
			});
			
			$("#nav-search-input").focus(function(){
				$("#placeholder-text").fadeToggle();
			});
			
			$("#nav-search-input").blur(function(){
				$("#placeholder-text").fadeToggle();
			});
			
			
			function toggleSearchModal() {
				$("#search-modal-wrapper").slideToggle(function(){
					$("#search-modal-background").fadeToggle();
				});
			}
			
			function setUserImageModal() {
				$("#set-image-modal-wrapper").css("top","-14%");
				$("#set-image-modal-background").fadeToggle();
				$("#set-image-modal-wrapper").animate({top:'14%'});
			}
			
			function toggleCsvModal(toggle) {
				if(toggle == "show") {
					$("#add-csv-modal-wrapper").css("top","-10%");
					$("#add-csv-modal-background").fadeToggle();
					$("#add-csv-modal-wrapper").animate({top:'10%'});
				}
				else {
					$("#add-csv-modal-wrapper").animate({top:'-10%'});
					$("#add-csv-modal-background").fadeToggle();
					$("#add-csv-modal-wrapper").css("top","10%");
				}
			}
			
			//For option
			var user_name_o;
			var user_type_o;
			var user_count = <?php echo $total_students; ?>
			
			function setUserInfo(user_name,user_type) {
				user_name_o = user_name;
				user_type_o = user_type;
			}
			
			function confirmDialog() {
				document.getElementById("modal-delete-description").innerHTML = "Are you sure you want to delete <strong>" + user_name_o + "</strong>? This can not be undone.";
				$('#modal-delete').modal('open');
			}
			
			function performDelete() {
				$('#modal-delete').modal('close');
				var xhttp;
				var returnedObject;

				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var msg = "User <span style='color:yellow;'>" + user_name_o+ "</span> " + this.responseText;
						if(this.responseText == "deleted successfully" || this.responseText == "deleted partially") {
							var user = "#collection-item-" + user_name_o;
							$(user).hide("slow",function(){
								$(user).remove();
							});
							user_count = user_count - 1;
							$("#total_user_count").text(user_count + " USERS");
						}
						Materialize.toast(msg, 3000);
					}
				}
				xhttp.open("POST", "database/deleteUser.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("user_name=" + user_name_o + "&user_type=" + user_type_o);
			}
			
			function cancelDelete(){
				Materialize.toast("Task canceled", 3000);
			}
			
			function randomPassword(){
				var alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				var n = 0;
				var pass = "";
				for (var i = 0; i < 10; i++) {
					n = Math.round(Math.random() * 60);
					pass = pass + alphabet[n];
				}
				return pass; 
			}
			
			function checkUserName(user_name) {
				var xhttp;
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if(this.responseText == "available")
							return;
						else{
							$('#modal-user-name-na').modal('open');
							$("#user_name").val("");
						}
					}
				}
				xhttp.open("POST", "database/checkUsernameAvailability.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("user_name=" + user_name);			
			}
			
			function performUpload(filename) {
				var xhttp = new XMLHttpRequest();
				if (xhttp.upload && file.type == "image/jpeg" && file.size <= 2097152) {

					xhttp.upload.addEventListener("progress", function(e) {
						$("#upload-percentage").text((parseInt(e.loaded/e.total * 100)).toString());
					}, false);
					
					// file received/failed
					xhttp.onreadystatechange = function(e) {
						if (this.readyState == 4 && this.status == 200) {
							
						}
			
						xhr.open("POST", "database/uploadUserImage.php", true);
						xhr.setRequestHeader("X-FILENAME", file.name);
						xhr.send(file);
					}
				}
			}
			
			/* UPLOAD IMAGE PREVIEW */
			window.URL    = window.URL || window.webkitURL;
			var elBrowse  = document.getElementById("fileToUpload"),
				elPreview = document.getElementById("image-details"),
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
					document.getElementById("image-details").innerHTML = "Height : " + image.height + "<br>Width : " + image.width + "<br>Type : " + file.type + "<br>Size : " + Math.round(file.size/1024) +"KB";
					document.getElementById("image-to-set").src = useBlob ? window.URL.createObjectURL(file) : reader.result;
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
				  if ( (/\.(png|jpeg|jpg|gif)$/i).test(file.name) ) {
					readImage( file ); 
				  } else {
					errors += file.name +" Unsupported Image extension\n";  
				  }
				}
			  }
			  if (errors) {
				alert(errors); 
			  }
			});
							
			function checkAndFillUserInfo(courseId,batch) {
				if($("#user-list-" + courseId).children().length == 0)
					fillUserInfo(courseId,batch);
			}				
							
			function fillUserInfo(courseId,batch) {
				$.post("database/getBatchUserDetails.php",
				{
				   course_id: courseId,
				   batch_year: batch
				},
				function(data,status){
					if(status == 'success') {
						var object = JSON.parse(data);
						
						//remove all childs from collection-item div element
						$("#user-list-" + courseId).empty();

						//parse and list students
						for(item in object.user_info) {
							var img = "<img src='" + object.user_info[item].user_image + "' alt='user image' style='top:11px !important;' class='circle'>";
							var span = "<span class='title black-text'>" + object.user_info[item].user_name + "</span>";
							var p = "<p class='grey-text collection-description' style='padding:0px !important;'>Email : " + object.user_info[item].user_email + "<br>Phone : " + object.user_info[item].user_phone +"</p>";
							var a = "<a href=\"#\" onclick=\"setUserInfo(\'" + object.user_info[item].user_username + "\',\'student\');\" data-activates=\'dropdown-option-" + object.user_info[item].user_username + "' class='secondary-content dropdown-button'><i class='material-icons student-delete-link grey-text'>more_vert</i></a>";
							var li = "<li class='collection-item avatar' style='display:none;' id='collection-item-" + object.user_info[item].user_username + "'>";
							var li_id = "#collection-item-" + object.user_info[item].user_username;
							
							$("#user-list-" + courseId).append(li);
							$(li_id).append(img);
							$(li_id).append(span);
							$(li_id).append(p);
							$(li_id).append(a);
							$(li_id).fadeToggle('slow');
							
							//User dropdown menu
							var ul_do = "<ul id='dropdown-option-" + object.user_info[item].user_username + "' class='dropdown-content dropdown-user-option'></ul>";
							var ul_li_txt = "<li><a href='#!' class='" + page_theme + "-text text-darken-3'><i class='material-icons " + page_theme + "-text text-darken-3 user-dropdown-option-icon'>mode_edit</i>Edit</a></li>";
							var ul_li_btn = "<li><a href='#!' class='" + page_theme + "-text text-darken-3' onclick='confirmDialog()' ><i class='material-icons " + page_theme + "-text text-darken-3 user-dropdown-option-icon'>delete_forever</i>Delete</a></li>";
							var opt = "#dropdown-option-" + object.user_info[item].user_username;
							
							$("#user-list-" + courseId).append(ul_do);
							$(opt).append(ul_li_txt);
							$(opt).append(ul_li_btn);
							$('.dropdown-button').dropdown({
								inDuration: 300,
								outDuration: 225,
								constrain_width: false,
								hover: false,
								gutter: 0,
								belowOrigin: false,
								alignment: 'left',
								stopPropagation: false
							});
						}
					} 
					else
						Materialize.toast('Error fetching data from server',3000);
				});
			}
			
			function performSearch(keyword) {
				keyword = keyword.trim().toLowerCase();
				var sb = $("input[type='radio'][name='search-user-by']:checked").val();
				var st = $("input[type='radio'][name='search-user-type']:checked").val();
				$.post("database/getCustomUserDetails.php",
				{
				   searchBy: sb,
				   searchUserType: st,
				   searchString: keyword
				},
				function(data,status){
					if(status == 'success') {
						var object = JSON.parse(data);
						$('#search-modal-result').empty();
						
						if(keyword == "")
							return;
						
						//add new elements. Now using jQuery
						var rcount = 0;
						for(item in object.user_info) {
							var srw = "<div class='search-result-wrapper' id='srw-" + rcount + "'></div>";
							var sriw = "<div class='search-result-image-wrapper' id='sriw-" + rcount + "'></div>";
							var sri = "<img class='search-result-image circle' src='" + object.user_info[item].user_image + "'>";
							var srd = "<div class='search-result-description' id='srd-" + rcount + "'>";
								//highlight search string
								var name;
								if(sb == "user_username")
									name = object.user_info[item].user_username;
								else
									name = object.user_info[item].user_name;
								
								name = name.toLowerCase();
								var s_pos = name.indexOf(keyword);
								var part_one = name.slice(0,s_pos);
								var part_two = name.substr(s_pos + keyword.length,name.length);
							
							if(sb == "user_username")
								var srcn = "<a href='#' class='search-result-component-name truncate'>" + object.user_info[item].user_name + " (" + part_one + "<span class='search-keyword <?php echo $theme; ?>-text'>"+ keyword +"</span>"+ part_two + ") </a>";
							else
								var srcn = "<a href='#' class='search-result-component-name truncate'>" + part_one + "<span class='search-keyword <?php echo $theme; ?>-text'>"+ keyword +"</span>"+ part_two + " (" + object.user_info[item].user_username +") </a>";	
							
							var srvn = "<h6 class='search-result-vendor-name grey-text darken-3'> Phone: " + object.user_info[item].user_phone + "</h6>";
							var srci = "<h6 class='search-result-component-id grey-text darken-3'> Email: " + object.user_info[item].user_email + "</h6>";
							
							$("#search-modal-result").append(srw);
								$("#srw-" + rcount).append(sriw);
									$("#sriw-" + rcount).append(sri);
								$("#srw-" + rcount).append(srd);
									$("#srd-" + rcount).append(srcn);
									$("#srd-" + rcount).append(srvn);
									$("#srd-" + rcount).append(srci);
									if(st == "student") {
										var sruc = "<h6 class='search-result-component-id grey-text darken-3'> Course: " + object.user_info[item].course_name + "</h6>";
										$("#srd-" + rcount).append(sruc);
									}
									else
										$("#srd-" + rcount).append("<h6 class='search-result-component-id grey-text darken-3'> Faculty </h6>");
							rcount++;
						}
					} 
					else
						Materialize.toast('Error fetching data from server',3000);
				});	
			}
			
		</script>
	</body>
</html>

