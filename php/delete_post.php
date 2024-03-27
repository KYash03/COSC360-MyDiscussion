<?php
session_start();
require_once '../db_connection.php'; // Adjust the path as needed.
$pdo = OpenCon();

// Assuming you've properly set the $isUserLoggedIn and $isUserAdmin variables elsewhere
$isUserLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
$isUserAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];
$loggedInUserId = $_SESSION['userID'] ?? null; // Adjust this to match how you're storing user IDs in your session.

if (isset($_GET['postID']) && $isUserLoggedIn) {
    $postID = $_GET['postID'];

    // First, check if the current user is the author of the post or an admin
    $checkSql = "SELECT userID FROM posts WHERE postID = :postID";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $checkStmt->execute();
    $post = $checkStmt->fetch();

    if ($post) {
        $isAuthor = $loggedInUserId == $post['userID'];

        if ($isAuthor || $isUserAdmin) {
            // The user is either the author or an admin, proceed with deletion
            $sql = "DELETE FROM posts WHERE postID = :postID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) {
                // echo "<script>alert('Post deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error deleting post.');</script>";
            }
        } else {
            echo "<script>alert('Unauthorized access.');</script>";
        }
    } else {
        echo "<script>alert('Post not found.');</script>";
    }
} else {
    echo "<script>alert('Unauthorized access.');</script>";
}

// echo "<script>window.location.href = '../Home-merged.php';</script>"; // Redirect back to the homepage
exit();
?>
