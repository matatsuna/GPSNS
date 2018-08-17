<?php
header("Content-type: application/json");

require("../init.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysqli_connect ('mysql', $username, $password);
if (!$connection) {  die('Not connected : ' . mysqli_error());}

// Set the active MySQL database

$db_selected = mysqli_select_db($connection,$database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error());
}

// Select all the rows in the markers table

$query = "SELECT * FROM gpsns_table WHERE 1";
$result = mysqli_query($connection,$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}


// Iterate through the rows, adding XML nodes for each
$json = [];
while ($row = @mysqli_fetch_assoc($result)){
  // echo $row;
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("link", $row['link']);
  // $json[]=array(array("name",$row["name"]),array("lat",$row["lat"]),array("lng",$row["lng"]),array("link",$row["link"]));
}

echo json_encode($json);

?>