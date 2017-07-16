<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 8/18/2016
 * Time: 2:50 PM
 */

$myID = $_GET['myID'];

require_once('config.php');

$info = mysqli_query($mysqli, "DELETE FROM component WHERE component_id = $myID");

mysqli_close($mysqli);

header('Location: admin_component.php');

?>