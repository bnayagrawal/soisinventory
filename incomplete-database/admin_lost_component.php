<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 8/23/2016
 * Time: 1:29 PM
 */

$myID = $_GET['myID'];

require_once('config.php');

$update = mysqli_query($mysqli, "UPDATE component SET component_available=0 WHERE component_id=$myID");

$info = mysqli_query($mysqli, "INSERT INTO lost(lost_id) VALUES ('$myID')");

mysqli_close($mysqli);

header('Location: admin_component.php');

?>