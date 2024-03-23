<?php
$posts=[];

//require_once 'path/to/db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = OpenCon();

    //need to add a join so we can access username, posts table only have userID

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
            <li><a href="Home-loggedin.html">Home</a></li>
            <li><a href="Logout.php">Logout</a></li>
            <li><a href="Profile.html">Profile</a></li>
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
                        
                        <p class="username">Posted by: <?php echo htmlspecialchars($post['username']); ?></p>
                        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p><?php echo htmlspecialchars($post['content']); ?></p>
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
