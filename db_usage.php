<?php
$servername = "INSERT_DATABASE_HOSTNAME";
$username = "INSERT_DATABASE_USERNAME";
$password = "INSERT_DATABASE_PASSWORD";
$dbname = "evusage";

// Create connection
$conn = mysqli_connect($servername,$username,$password,"$dbname");
// Check connection
if (!$conn) {
  die("Connection failed: " .mysql_errno());
}
?>