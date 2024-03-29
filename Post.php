<?php

session_start();
$isUserLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
$isUserAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];
$comments = [];
$postDetails = [];
$breadcrumbs = ['<li><a href="Home-merged.php">Home</a></li>'];

if (isset($_GET['postID'])) {
    $postID = $_GET['postID'];

    require_once 'db_connection.php';
    $pdo = OpenCon();

    //Fetch post details

    $fetch_post_info_sql = 'SELECT p.postTitle, p.postContent, p.postDate, u.username, c.categoryName
    FROM posts p
    INNER JOIN user u ON p.userID = u.userID
    INNER JOIN category c ON p.categoryID = c.categoryID
    WHERE p.postID = ?';

    try {
        $stmt = $pdo->prepare($fetch_post_info_sql);
        $stmt->execute([$postID]);
        $postDetails = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch and store post info
    } catch(PDOException $e) {
        echo "Error fetching comments: " . $e->getMessage();
    }

    if (isset($postDetails['categoryName'])) {
        $breadcrumbs[] = '<li><a href="category.php?category=' . urlencode($postDetails['categoryName']) . '">' . htmlspecialchars($postDetails['categoryName']) . '</a></li>';
    }

    // Always add the current post to the breadcrumbs
    if (isset($postDetails['postTitle'])) {
        $breadcrumbs[] = '<li>' . htmlspecialchars($postDetails['postTitle']) . '</li>';
    }
    

    //Fetch comments

    $fetch_comments_sql = 'SELECT c.commentID,c.comment, c.commentDate,c.userID, u.username
    FROM comments c
    INNER JOIN user u ON c.userID = u.userID
    WHERE c.postID = ?';

    try {
        $stmt = $pdo->prepare($fetch_comments_sql);
        $stmt->execute([$postID]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch and store comments
    } catch(PDOException $e) {
        echo "Error fetching comments: " . $e->getMessage();
    }




    // commenting action 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        
        $post_sql = "INSERT INTO comments (postID,userID,comment,commentDate) VALUES (?,?,?,?)";
        $userID = $_SESSION['userID'];

        $comment = $_POST['comment'];
        

        $commentDate = date("Y-m-d");
        try {
            $stmt = $pdo->prepare($post_sql);
            if($stmt->execute([$postID, $userID,$comment,$commentDate])){
                header("location: post.php?postID=" . $postID );
                exit();
            }
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close the connection
        $pdo = null;
    }
} else {
    echo "Error: Post ID not specified.";
}
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
                <input type="search" placeholder="  Search">
                <button>Search</button>
            </header>
            <main>
            <div class="breadcrumbs-container">
                <nav id='breadcrumb' aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <?php echo implode('', $breadcrumbs); ?>
                    </ol>
                </nav>
            </div>
                <div class="post">
                <?php 
                    if($isUserAdmin){
                        echo "<a href='php/delete_post.php' class='delete-icon'><img src='public/delete.png' alt='Delete' width='32' height='32'/>
                        </a>";
                    }
                    ?>
                    <h2><?php echo htmlspecialchars($postDetails['postTitle']); ?></h2>

                    <span><?php echo htmlspecialchars($postDetails['categoryName']);?></span>
                    <p><?php echo htmlspecialchars($postDetails['postContent']); ?></p>
                </div>
                <div class="comments-section">
                    <h3>Comments</h3>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <p><strong><?php echo htmlspecialchars($comment['username']); ?> :  </strong>
                            <?php echo htmlspecialchars($comment['comment']);?>
                            </p>
                            <span class = "comment-date"> <?php echo htmlspecialchars($comment['commentDate']); ?></span>
                            <p>
                            <?php if ($isUserLoggedIn && ($isUserAdmin || $_SESSION['userID'] == $comment['userID'])): ?>
                            <a href="delete_comment.php?commentID="<?php echo htmlspecialchars($comment['commentID']); ?>&postID=<?php echo htmlspecialchars($postID); ?> class="delete-comment-link">Delete</a>
                            <?php endif; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    <div class="add-comment">
                        <form method ="post" id ="post-comment" action = "#">
                            <fieldset>
                                <textarea id ="comment" name ='comment' placeholder="Add a comment..."></textarea>
                                <input type="submit" value="Post Comment">
                            </fieldset>
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