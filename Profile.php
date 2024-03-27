<?php
require_once 'db_connection.php';
session_start();
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Details - Talks@UBC</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <div class="container">
        <nav>
            <a href = "Home.php"><h1>Talks@UBC</h1></a>
            <ul>
                <li><a href="Home-merged.php">Home</a></li>
                <li><a href="LogOut.php">Log Out</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header>
                <input type="search" placeholder="  Search">
                <button>Search</button>
            </header>
            <main>
                <div class="profile">
                    <img src="public/user-profile.png" alt="user-img" class="user-img">
                    <h2><?php echo $username?></h2>
                    <div class="bio">
                        USER'S BIO
                    </div>
                    <div class ="photo-upload">
                        <form method="post">
                            <p>
                                <label>Upload a profile picture</label>
                            </p>
                            <p>
                                <input type="file" name="profile-pic"/>
                            </p>
                        </form>

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