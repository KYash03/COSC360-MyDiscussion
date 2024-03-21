<?php
function OpenCon()
{
$dbhost = "localhost";
$dbuser = "49046584";
$dbpass = "49046584";
$db = "db_49046584";
$conn = new mysqli($dbhost, $dbuser, $dbpass,$dbname) or die("Connect failed: %s\n". $conn -> error);
return $conn;
}
function CloseCon($conn)
{
$conn -> close();
}
?>