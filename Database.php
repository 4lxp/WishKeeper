<?php
$servernameDB = "mysql.hostinger.it";
$usernameDB = "u115956527_4lxp";
$passwordDB = "Shglq0EzPFrp";
$dbnameDB = "u115956527_wish";

// Create connection
$conn = new mysqli($servernameDB, $usernameDB, $passwordDB, $dbnameDB);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
