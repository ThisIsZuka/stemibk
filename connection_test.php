<?php
$servername = "db1.telecorp.co.th";
$username = "root";
$password = "@Telecorp2020";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
