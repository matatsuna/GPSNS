<?php
require("../init.php");
// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

$lat = floatval($_REQUEST["lat"]);
$lng = floatval($_REQUEST["lng"]);

$tmp_name = $_FILES["img"]["tmp_name"];
$name = basename($_FILES["img"]["name"]);
move_uploaded_file($tmp_name, "img/$name");

$query = "INSERT INTO gpsns_table(name,lat,lng) VALUES('$name',$lat,$lng)";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/json");
echo json_encode(array("status"=>"ok"));

?>