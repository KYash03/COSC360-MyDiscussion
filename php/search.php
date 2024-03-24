<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once '../db_connection.php';

$pdo = OpenCon();
// Retrieve the search query from GET parameters
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

// Protect against SQL injection (Server side security) and ensure special characters are handled properly
$searchQuery = $pdo->quote("%$searchQuery%");

// The SQL query to fetch posts matching the search term from either the title or content
$sql = "SELECT * FROM posts WHERE postTitle LIKE $searchQuery OR postContent LIKE $searchQuery";

// Execute the query and fetch results
$stmt = $pdo->query($sql); // Ensure that $pdo is your PDO database connection variable
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
if ($results) {
    echo "<div class='search-results'>";
    foreach ($results as $row) {
        echo "<div class='post'>";
        echo "<h2>" . htmlspecialchars($row['postTitle']) . "</h2>";
        // If you have a postContent column or similar, echo it here
        echo "<p>" . htmlspecialchars($row['postContent']) ?? '' . "</p>";
        echo "<p>Posted on: " . htmlspecialchars($row['postDate']) . "</p>";
        // Add more post details as necessary
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No results found for your search.";
}
?>
