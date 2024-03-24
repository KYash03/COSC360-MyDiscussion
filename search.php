<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../db_connection.php';

$pdo = OpenCon();

// Retrieve the search query from GET parameters
$searchQuery = isset($_GET['searchQuery']) ? "%" . $_GET['searchQuery'] . "%" : '';
$searchQuery = $pdo->quote($searchQuery); // Properly quote the search term

// The SQL query to fetch posts matching the search term from either the title or content
// Correctly integrate the quoted search query
$sql = "SELECT * FROM posts WHERE postTitle LIKE $searchQuery OR postContent LIKE $searchQuery";

// Prepare and execute the query to avoid direct execution
$stmt = $pdo->prepare($sql); 
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
if ($results) {
    echo "<div class='search-results'>";
    foreach ($results as $row) {
        echo "<div class='post'>";
        echo "<h2>" . htmlspecialchars($row['postTitle']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['postContent']) . "</p>";
        echo "<p>Posted on: " . htmlspecialchars($row['postDate']) . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No results found for your search.";
}
?>