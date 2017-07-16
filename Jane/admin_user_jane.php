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
    <title>MIT Inventory</title>
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

  <?php
  require_once('config.php');

  $info = mysqli_query($mysqli, "select * from course");

  $course_array = array();
  while ($row = mysqli_fetch_array($info)) {
      $course_array[] = $row['course_name'];
  }
  ?>

  <!-- Modal -->
  <!-- Modal 1 -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <!-- Modal Body -->
              <div class="modal-body">
                  <form name="courseForm" id="courseForm" action = "admin_import_user.php" method = "POST" enctype = "multipart/form-data">
                      <!--
                          <ul class="dropdown-menu" role="menu">
                              <li>
                              -->
                                      <select name="coursename" id="coursename" class="form-control">
                                          <?php
                                          for($i=0; $i < count($course_array); $i++) {
                                              echo "<option value='$course_array[$i]'>$course_array[$i]</option>";
                                          }
                                          ?>
                                      </select>
                              <!--
                                </li>
                          </ul>
                          -->
              </div>
                <div class="container-fluid">

                          <input type = "file" name = "csv" />
                </div>
				<br>
              <!-- Modal Footer -->

              <div class="modal-footer">
                  <div class="row col-md-12">
                      <div class="col-md-6">
                          <input type = "submit" name="submit" class="btn btn-primary pull-left"/>
                      </div>
                      <div class="col-md-6">
                          <button type="button" class="btn btn-default pull-right"
                                  data-dismiss="modal">
                              Close
                          </button>
                      </div>
                  </div>
              </div>
                    </form>
                
          </div>
      </div>
  </div>
<!--- modal end--->

  <script>
      $(document).ready(function() {
          $('input[type="radio"]').click(function() {
              if($(this).attr('id') == 'student') {
                  $('#show-me').show();
              }
              else {
                  $('#show-me').hide();
              }
          });
      });

  </script>

  <!-- Modal 2 -->
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <form name="courseForm2" id="courseForm2" action = "admin_import_one_user.php" method = "POST" enctype = "multipart/form-data">
          <div class="modal-content">
              <!-- Modal Body -->
              <div class="modal-body">
                  <!-- Modal Body -->
                 <div class="form-group">
                     <label class="radio-inline"><input type="radio" name="radio" id="student" value="student">Student</label>
                     <label class="radio-inline"><input type="radio" name="radio" id="faculty" value="faculty">Faculty</label>
                  </div>

                 <div id="show-me" style='display:none'>
                     <select name="coursename" id="coursename" class="form-control">
                         <?php
                         for($i=0; $i < count($course_array); $i++) {
                             echo "<option value='$course_array[$i]'>$course_array[$i]</option>";
                         }
                         ?>
                     </select>
                     <br>
                 </div>

                 <div>
                     <div class="form-group">
                         <label for="user_name">Name:</label>
                         <input type="text" class="form-control" name="user_name" id="user_name">
                     </div>
                     <div class="form-group">
                         <label for="user_username">Username:</label>
                         <input type="text" class="form-control" name="user_username" id="user_username">
                     </div>
                 </div>
              </div>

              <!-- Modal Footer -->

              <div class="modal-footer">
                  <div class="row col-md-12">
                      <div class="col-md-6">
                          <input type = "submit" name="submit" class="btn btn-primary pull-left"/>
                      </div>
                      <div class="col-md-6">
                          <button type="button" class="btn btn-default pull-right"
                                  data-dismiss="modal">
                              Close
                          </button>
                      </div>
                  </div>
              </div>
          </div>
              </form>
      </div>
  </div>
  <!--- modal end--->
  <!-- end modal 2 -->

<div class="jumbotron">
    <div class="container">
        <div class="row">
			<div class="col-md-6">
				<img id="page-picture-id" src="mit_logo.png"  height="auto" width="80">
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
        <li><a href="admin_component.php">Component</a></li>
		<li class="active"><a href="admin_user.php">User</a></li>
        <li><a href="admin_reservation.php">Reservation</a></li>
<li><a href="admin_course.php">Course</a></li>
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
	<div class="col-sm-6">
        <a href="#" id="myBtn" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
            <span class="glyphicon glyphicon-import"></span> Import CSV
        </a>

        <a href="#" id="myBtn2" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal2">
            <span class="glyphicon glyphicon-import"></span> Import one user
        </a>

		<a href="" type="button" class="btn btn-info">
			<span class="glyphicon glyphicon-export"></span> Export CSV
		</a>

		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#filter-panel">
            <span class="glyphicon glyphicon-cog"></span> Advanced Search
        </button>
	</div>
	</div>
</div>
<br>

<div class="container-fluid bootstrap snippet">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list">
                            <thead>
                                <tr>
                                <th><span>User</span></th>
                                <th><span>Course</span></th>
                                <th><span>Email</span></th>
								<th><span>Phone number</span></th>
                                <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $info = mysqli_query($mysqli, "select user_username, user_password, user_name, user_email, user_phone, user_image, student_course from user join student on user.user_username = student.student_username");
                            // it's not listing the Faculty
                            while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
                                $user_username = $row['user_username'];
                                $user_password = $row['user_password'];
                                $user_name = $row['user_name'];
                                $user_email = $row['user_email'];
                                $user_phone = $row['user_phone'];
                                $user_image = $row['user_image'];
                                $student_course = $row['student_course'];
                            echo "
                                    <tr>
                                        <td>
                                            <img src='$user_image' alt=''>
                                            <span class='user-link'>$user_name</span>
                                            <span class='user-subhead'>$user_username</span>
                                        </td>
                                        <td>$student_course</td>

                                        <td>
                                            $user_email
                                        </td>
                                        <td>
                                            $user_phone
                                        </td>
                                        <td style='width: 20%;'>
                                            <a href='admin_delete_user.php?myUser={$user_username}' onclick='return checkDelete()' class='table-link'>
                                                <button type='button' class='btn btn-danger btn-sm'>
                                                <span class='glyphicon glyphicon-trash'></span> delete
                                                </button>
                                            </a>
                                        </td>
                                    </tr>";
                                }
                            // TODO: put all in array and list them after
                            $info = mysqli_query($mysqli, "select user_username, user_password, user_name, user_email, user_phone, user_image from user join faculty on user.user_username = faculty.faculty_username");
                            // it's not listing the student
                            while($row=mysqli_fetch_array($info,MYSQLI_ASSOC)) {
                                $user_username = $row['user_username'];
                                $user_password = $row['user_password'];
                                $user_name = $row['user_name'];
                                $user_email = $row['user_email'];
                                $user_phone = $row['user_phone'];
                                $user_image = $row['user_image'];
                                $student_course = "Faculty";
                                echo "
                                    <tr>
                                        <td>
                                            <img src='$user_image' alt=''>
                                            <span class='user-link'>$user_name</span>
                                            <span class='user-subhead'>$user_username</span>
                                        </td>
                                        <td>$student_course</td>

                                        <td>
                                            $user_email
                                        </td>
                                        <td>
                                            $user_phone
                                        </td>
                                        <td style='width: 20%;'>
                                            <a href='admin_delete_user.php?myUser={$user_username}' onclick='return checkDelete()' class='table-link'>
                                                <button type='button' class='btn btn-danger btn-sm'>
                                                <span class='glyphicon glyphicon-trash'></span> delete
                                                </button>
                                            </a>
                                        </td>
                                    </tr>";
                            }

                            mysqli_close($mysqli);
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
