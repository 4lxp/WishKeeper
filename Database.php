<?php
$servernameDB = "";
$usernameDB = "";
$passwordDB = "";
$dbnameDB = "";

// Create connection
$conn = new mysqli($servernameDB, $usernameDB, $passwordDB, $dbnameDB);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
