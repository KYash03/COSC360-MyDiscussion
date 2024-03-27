
<?php
session_start();
require_once '../db_connection.php'; // Adjust the path as needed.
$pdo = OpenCon();

// $isUserAdmin = TRUE;//REMOVE THIS WHEN NOT TESTING

if (isset($_GET['postID']) && ($isUserLoggedIn || $isUserAdmin)) {
    $postID = $_GET['postID'];

    // Optional: Check if the current user is the author of the post or an admin
    // This might involve a SELECT query to fetch the post's userID and compare with the logged-in user's ID

    $sql = "DELETE FROM posts WHERE postID = :postID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount()) {
        echo "<script>alert('Post deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting post.');</script>";
    }
} else {
    echo "<script>alert('Unauthorized access.');</script>";
}

echo "<script>window.location.href = '../Home.php';</script>"; // Redirect back to the homepage
exit();
?>

