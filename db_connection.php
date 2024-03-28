
<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "49046584";
    $dbpass = "49046584";
    $dbname = "db_49046584";
    
    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function CloseCon($conn)
{
    // PDO connections are automatically closed when a script ends, but you can close it by setting it to null
    $conn = null;
}
?>