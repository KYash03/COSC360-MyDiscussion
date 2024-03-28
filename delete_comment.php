<?php
session_start();
require_once 'db_connection.php';

if(isset($_GET['commentID'], $_GET['postID']) && (isset($_SESSION['loggedin']) && $_SESSION['loggedin'])) {
    $commentID = $_GET['commentID'];
    $postID = $_GET['postID']; 
    $pdo = OpenCon();


    $delete_sql = 'DELETE FROM comments WHERE commentID = ?';
    
    try {
        $stmt = $pdo->prepare($delete_sql);
        $stmt->execute([$commentID]);
        
        header("Location: post.php?postID=" . $postID);
        exit();
    } catch(PDOException $e) {
        echo "Error deleting comment: " . $e->getMessage();
    }
    
    $pdo = null;
} else {
    echo "Unauthorized request.";
}
?>
