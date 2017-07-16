<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 9/8/2016
 * Time: 11:09 AM
 */

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

require_once('../config.php');

if(isset($_POST['submit'])) {

    $reserve_comp_id = $_GET['myID'];
    $date = $_POST['date'];
    $number_of_days = $_POST['days_number'];
    // current_user
    $permit = 0; // after that the admin is approving it
    $date_today = date("yy-m-d");
    /*
    echo "Today : " . $date_today;
    echo "User : " . $current_user;
    echo "Component ID : " . $reserve_comp_id;
    echo "When user want it : " . $date;
    echo "How long does he/she want it : " . $number_of_days;
    if($permit)
        echo "Current permit : true";
    else
        echo "Current permit : false";
    */
    $insert_sql = "INSERT INTO `borrowed`(`borrowed_user`, `borrowed_component_id`, `borrowed_date`, `borrowed_whenUserWantIt`, `borrowed_howLongUserNeedIt`, `borrowed_permit`) 
VALUES ('$current_user','$reserve_comp_id',now(),'$date','$number_of_days','0')";
    
    mysqli_query($mysqli, "UPDATE component SET component_available='0' WHERE component_id='$reserve_comp_id'");


    if ($mysqli->query($insert_sql) === TRUE) {
          echo "<script>
          alert('Your reservation is done');
          window.location.href='user_reservation.php';
          </script>";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $mysqli->error;
    }

}


?>	