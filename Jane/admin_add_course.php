<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 8/12/2016
 * Time: 10:46 AM
 */

if ($_POST) {
    require_once('config.php');

// Check connection
    if($mysqli === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

// Escape user inputs for security
    $course_name = mysqli_real_escape_string($mysqli, $_POST['coursename']);


// Attempt insert query execution
    $sql = "INSERT INTO course (course_name) VALUES ('$course_name')";

    if(mysqli_query($mysqli, $sql)){
        echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('Course added successfully');
        window.location.replace(\"admin_component.php\");
    </SCRIPT>";
    } else{
//    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
        echo "<SCRIPT type='text/javascript'> //not showing me this
        alert('There is error with entered data');
        window.location.replace(\"admin_component.php\");
    </SCRIPT>";
    }

// Close connection
    mysqli_close($mysqli);

    $message = 'This is a message.';
    exit();
}
?>