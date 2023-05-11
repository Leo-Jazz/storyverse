<?php

$servername = "sql203.epizy.com";
$username = "epiz_34019416";
$password = "r0p73ea4QBdLI4";
$dbname = "epiz_34019416_stories_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>
