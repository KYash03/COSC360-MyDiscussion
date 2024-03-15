<?php
$servername = "localhost"; // This might be different if your database is hosted on another server
$username = "86471588"; // Your username
$password = "86471588"; // Your password
$dbname = "db_86471588"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
