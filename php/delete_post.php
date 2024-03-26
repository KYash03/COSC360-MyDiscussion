<?php
// Assuming session_start() is called earlier in your application to support user sessions
session_start();

require_once '../db_connection.php'; // Adjust path as needed
$pdo = OpenCon();

// Check if the user is logged in and the request has the necessary parameter
if (isset($_SESSION['user_id']) && isset($_GET['post_id'])) {
    $userId = $_SESSION['user_id']; // Assuming you store user ID in session
    $postId = $_GET['post_id'];

    // Optional: Verify that the user has permission to delete the post
    // This might involve checking that the user is the author of the post or has admin privileges

    // SQL to delete the post
    $sql = "DELETE FROM posts WHERE postID = :postId AND userID = :userId"; // Adjust column names as needed
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':postId' => $postId, ':userId' => $userId]);

    if ($stmt->rowCount() > 0) {
        echo "Post deleted successfully.";
    } else {
        echo "Error deleting post or permission denied.";
    }
} else {
    echo "Unauthorized request.";
}

// Redirect back to Home.php or another page as appropriate
header('Location: Home.php');
 exit();
?>
