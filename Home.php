<?php
$posts=[];

require_once 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = OpenCon();

    //need to add a join so we can access username, posts table only have userID
    //need to add a join to category table through categoryID

    $sql = "SELECT posts.postID,posts.postTitle,posts.postDate,user.username,category.categoryName FROM posts LEFT JOIN user ON posts.userID =user.userID  LEFT JOIN categories ON post.categoryID=category.categoryID ORDER BY postDate DESC LIMIT 20;";

    
    
    try {
        // Prepare the statement
        $result = $pdo->query($sql);
        while($row = $result->fetch()){
            $posts[] = $row;

        }


        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $pdo = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="container">
        <nav>
            <h1> Talks@UBC </h1>
            <!-- Navigation links go here -->
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="LogIn.html">Login</a></li>
                <li><a href="Profile.html">Profile</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header>
                <form onsubmit="performSearch(event)">
                    <input type="search" id="searchQuery" name="searchQuery" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </header>
            <main>
                <?php

                ini_set('display_errors', 1);
                error_reporting(E_ALL);

                require_once 'db_connection.php'; // Adjust the path as needed
                $pdo = OpenCon(); // Open the connection

                $sql = "SELECT * FROM posts ORDER BY postDate DESC"; // Fetch posts

                foreach ($pdo->query($sql) as $row) {
                    echo "<div class='post'>";
                    echo "<h2>" . htmlspecialchars($row['postTitle']) . "</h2>";
                    echo "<p>" . htmlspecialchars($row['postContent']) . "</p>";
                    echo "<p class='username'>Posted by: UserID " . htmlspecialchars($row['userID']) . "</p>";
                    // echo "<p class='post-category'>Category: <span class='category'>" . getCategoryName($row['categoryID']) . "</span></p>";
                    echo "<span class='post-date'>" . htmlspecialchars($row['postDate']) . "</span>";
                    echo "</div>";
                }
                ?>
            </main>
            <footer>
                <p>Talks@UBC</p>
            </footer>
        </div>
    </div>
</body>
</html>
