<?php
$posts=[];

require_once 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = OpenCon();

    //need to add a join so we can access username, posts table only have userID
    // $sql = "SELECT posts.postID,posts.postTitle,posts.postDate,user.username,category.categoryName FROM posts LEFT JOIN user ON posts.userID =user.userID  LEFT JOIN categories ON post.categoryID=category.categoryID ORDER BY postDate DESC LIMIT 20;
    $sql = "SELECT * FROM posts ORDER BY postDate DESC LIMIT 20";
    
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
    <title>Homepage - Logged In</title>
    <link rel="stylesheet" href="css/home-loggedin.css">
</head>
<body>
<div class="container">
    <nav>
        <h1>Talks@UBC</h1>
        <ul>
            <li><a href="Home-loggedin.php">Home</a></li>
            <li><a href="Logout.php">Logout</a></li>
            <li><a href="Profile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <header>
            <input type="search" placeholder="Search">
            <button>Search</button>
            <a href="CreatePost.php">
            <button id="new-post-btn">New Post</button>
            </a>
        </header>
        <main>
            <div class="filter-dropdown">Sort by</div>
            <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <h2><?php echo htmlspecialchars($post['postTitle']); ?></h2>
                        <p><?php echo htmlspecialchars($post['postContent']); ?></p>
                        <p class="post-category">Category: <span class="category"><?php echo htmlspecialchars($post['categoryName'])?></span></p>
                        <p class="username">Posted by: <?php echo htmlspecialchars($post['username']); ?></p>
                        <span class = "post-date"> <?php echo htmlspecialchars($post['postDate']); ?></span>
                    </div>
            <?php endforeach; ?>
        </main>
        <footer>
            <p>Talks@UBC</p>
        </footer>
    </div>
</div>
</body>
</html>
