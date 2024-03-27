<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../db_connection.php';

$pdo = OpenCon();

// Retrieve the search query from GET parameters
$searchQuery = isset($_GET['searchQuery']) ? "%" . $_GET['searchQuery'] . "%" : '';
$searchQuery = $pdo->quote($searchQuery);

// Adjust your SQL query as needed to fetch additional fields like category name and username
$sql = "SELECT p.*, u.username, c.categoryName FROM posts p 
        INNER JOIN user u ON p.userID = u.userID 
        INNER JOIN category c ON p.categoryID = c.categoryID 
        WHERE postTitle LIKE $searchQuery OR postContent LIKE $searchQuery";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ensure the path to your CSS file is correct
echo '<link rel="stylesheet" href="../css/home.css">';

// Display the results
if ($results) {
    echo "<div class='search-results'>";
    foreach ($results as $row) {
        echo "<div class='post'>";
        echo "<img src='public/delete.png' width = '32' height = '32' alt='Delete' class='delete-icon' onclick='deletePost(" . $row['postID'] . ")' style='cursor:pointer;'>";
        echo '<h2><a href="post.php?postID=' . $row['postID'] . '" class="postTitle">' . htmlspecialchars($row['postTitle']) . '</a></h2>';
        echo '<span class="category">' . htmlspecialchars($row["categoryName"]) . '</span>';
        echo "<p>" . htmlspecialchars($row['postContent']) . "</p>";
        echo "<p class='username'>Posted by: " . htmlspecialchars($row['username']) . "</p>";
        echo "<span class='post-date'>" . htmlspecialchars($row['postDate']) . "</span>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No results found for your search.";
}
?>
