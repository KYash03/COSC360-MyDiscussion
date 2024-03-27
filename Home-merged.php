<?php
session_start(); // Start the session.
$isUserLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
$isUserAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="<?php echo $isUserLoggedIn ? 'css/home-loggedin.css' : 'css/home.css'; ?>">
</head>
<body>
<div class="container">
    <nav>
        <h1>Talks@UBC</h1>
        <ul>
            <li><a href="Home.php">Home</a></li>
            <?php if ($isUserLoggedIn): ?>
                <li><a href="Profile.php">Profile</a></li>
                <li><a href="Logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="LogIn.php">Login</a></li>
                <li><a href="adminLogin.php">Admin Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="main-content">
        <header>
            <form onsubmit="performSearch(event)">
                <input type="search" id="searchQuery" name="searchQuery" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
            <?php 
            if($isUserLoggedIn){
                echo '<a href="CreatePost.php">
                <button id="new-post-btn">New Post</button>
                </a>';
            }
            ?>
        </header>
        <main>
            <?php
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            require_once 'db_connection.php';
            $pdo = OpenCon();
            
            $sql = 'SELECT p.postID, p.postTitle, p.postContent, p.postDate, u.username, c.categoryName
            FROM posts p
            INNER JOIN user u ON p.userID = u.userID
            INNER JOIN category c ON p.categoryID = c.categoryID
            ORDER BY p.postDate DESC 
            LIMIT 20';
            

            foreach ($pdo->query($sql) as $row) {

                echo "<div class='post'>";
                //or is userLogged in & userID matches.
                $isUserAdmin = TRUE; //THIS  SHOULD BE REMOVED IN THE ACTUAL IMPLEMENTATION.

                // if ($isUserAdmin) {
                //     echo  "<a href='php/delete_post.php' class='delete-icon'><img src='public/delete.png' alt='Delete' width='32' height='32'/>
                //     </a>";}

                if ($isUserAdmin) {
                    echo "<img src='public/delete.png' alt='Delete' class='delete-icon' onclick='deletePost(" . $row['postID'] . ")' style='cursor:pointer;'>";
                }

                echo '<h2><a href="post.php?postID=' . $row['postID'] . '" class= "postTitle">' . htmlspecialchars($row['postTitle']) . '</a></h2>';
                echo '<span class = "category" >'. $row["categoryName"] . '</span>';

                echo "<p>" . htmlspecialchars($row['postContent']) . "</p>";
                echo "<p class='username'>Posted by: " . htmlspecialchars($row['username']) . "</p>";
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

<script>
function performSearch(event) {
    event.preventDefault(); // Prevent the form from submitting through the browser
    var searchQuery = document.getElementById('searchQuery').value;

    // Perform an AJAX request to search.php
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "php/search.php?searchQuery=" + encodeURIComponent(searchQuery), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Replace the content of the 'main' section with the search results
            document.querySelector('main').innerHTML = xhr.responseText;
        } else {
            // Handle request failure
            console.error("Request failed.  Returned status of " + xhr.status);
        }
    };
    xhr.send();
}

function deletePost(postID) {
    if (confirm("Are you sure you want to delete this post?")) {
        fetch(`php/delete_post.php?postID=${postID}`, { method: 'GET'})
            .then(response => response.text())
            .then(data => {
                alert(data);
                window.location.reload(); // Reload to update the list of posts
            })
            .catch(error => console.error('Error:', error));
    }
}
</script>
</body>
</html>


