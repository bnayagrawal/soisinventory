<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 9/16/2016
 * Time: 6:12 PM
 */

$myID = $_GET['myID'];

require_once('config.php');

$info = mysqli_query($mysqli, "DELETE FROM course WHERE course_id = $myID");

mysqli_close($mysqli);

header('Location: admin_course.php');

?>