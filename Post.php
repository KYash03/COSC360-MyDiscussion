<?php
session_start();
$isUserLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
$isUserAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Details - Talks@UBC</title>
    <link rel="stylesheet" href="css/post.css">
</head>

<body>
    <div class="container">
        <nav>
            <h1>Talks@UBC</h1>
            <ul>
                <li><a href="Home-merged.php">Home</a></li>
                <li><a href="LogIn.php">Login</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header>
                <input type="search" placeholder="  Search">
                <button>Search</button>
            </header>
            <main>
                <div class="post">
                    <h2>Post Title</h2>
                    <p>This is the content of the post...</p>
                </div>
                <div class="comments-section">
                    <h3>Comments</h3>
                    <div class="comment">
                        <p><strong>User1:</strong> This is a comment.</p>
                    </div>
                    <div class="add-comment">
                        <form id ="post-comment ">
                        <textarea placeholder="Add a comment..."></textarea>
                        <button>Post Comment</button>

                    </div>
                </div>
            </main>
            <footer>
                <p>Talks@UBC</p>
            </footer>
        </div>
    </div>
</body>

</html>