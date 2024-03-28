<?php
require_once 'db_connection.php';
$pdo = OpenCon();
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

// Helper function to delete existing profile pictures with different formats
function deleteExistingProfilePictures($directory, $baseFileName, $currentExtension) {
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    foreach ($imageExtensions as $extension) {
        if ($extension !== $currentExtension) {
            $oldFilePath = $directory . $baseFileName . '.' . $extension;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // Delete the old image
            }
        }
    }
}

// Process the profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile-pic"])) {
    $uploadDir = 'uploads/'; // Ensure this directory exists and is writable
    $fileTmpPath = $_FILES["profile-pic"]["tmp_name"];
    $fileSize = $_FILES["profile-pic"]["size"];
    $fileType = $_FILES["profile-pic"]["type"];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];

    if (in_array($fileType, $allowedMimeTypes)) {
        // Sanitize the file name to avoid any security issues
        $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["profile-pic"]["name"]));
        // Extract file extension
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        // Create a new file name using the userID only
        $newFileName = $userID . '.' . $fileExtension;
        $destination = $uploadDir . $newFileName;

        // Delete any existing profile pictures with different formats
        deleteExistingProfilePictures($uploadDir, (string)$userID, $fileExtension);

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $sql = "UPDATE user SET picture = ? WHERE userID = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$destination, $userID])) {
                echo "Profile picture updated successfully.";
            } else {
                echo "There was an error updating your profile picture.";
            }
        } else {
            echo "There was an error moving the uploaded file.";
        }
    } else {
        echo "Only image files (JPEG, PNG, GIF, BMP, WEBP) are allowed.";
    }
}

// Fetch the current profile picture
$sql = 'SELECT picture FROM user WHERE userID = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch();
$picturePath = $user['picture'] ?? 'public/user-profile.png'; // Provide a default picture path if none is set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Talks@UBC</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <div class="container">
        <nav>
            <a href="Home-merged.php"><h1>Talks@UBC</h1></a>
            <ul>
                <li><a href="Home-merged.php">Home</a></li>
                <li><a href="LogOut.php">Log Out</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header>
                <input type="search" placeholder="Search">
                <button>Search</button>
            </header>
            <main>
            <div class="profile">
            <img src="<?= htmlspecialchars($picturePath) ?>" alt="user-img" class="user-img">
            <h2><?= htmlspecialchars($username) ?></h2>
            <div class="photo-upload">
                <form method="post" enctype="multipart/form-data">
                    <p>
                        <label>Upload a profile picture:</label>
                        <input type="file" name="profile-pic" required>
                    </p>
                    <p>
                        <input type="submit" value="Upload Picture">
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
