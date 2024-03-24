<?php
require_once 'db_connection.php';

$categories = [];

// Always fetch categories to ensure the form is up to date.
try {
    $pdo = OpenCon();
    $category_sql = "SELECT categoryID, categoryName FROM category ORDER BY categoryID";
    $stmt = $pdo->query($category_sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = OpenCon();

    
    $post_sql = "INSERT INTO posts (postTitle,postContent,categoryID,postDate,userID) VALUES (?,?,?,?,?)";
    
    try {
        // Prepare the statement
        $stmt = $pdo->prepare($post_sql);

        $userID = $_SESSION['userID'];

        $postTitle = $_POST['postTitle'];
        $postContent = $_POST['postContent'];
        $categoryID= $_POST['category'];
        $postDate = date("Y-m-d");
        $stmt->execute([$postTitle, $postContent,$categoryID,$postDate,$userID]);

        
        echo "Post created successfully.";
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
    <link rel="stylesheet" href="css/login-createpost.css">
    <script src = "js/form-validation2.js"></script>
    <title>Create a Post</title>
</head>

<body>
   
    <header>
        <a href="Home.php"><h1>Talks@UBC</h1></a>

    </header>
    <main>
        <div id="createpost">
            <form method="post" id="posting-form" action ="#">
                <fieldset>
                    <legend>Create Post</legend> 
                    <p>
                    <label>Title:</label>
                    </p>
                    <p>
                    <input type="text" id="postTitle" name="postTitle" required maxlength="">
                    </p>
                    <p>
                    </p>
                    <p>
                    <textarea id="postContent" name="postContent" rows="8" required></textarea>
                    </p>
                    <label for="category">Category:</label>
                        <select id="category" name="category" size="1" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['categoryID']); ?>"><?= htmlspecialchars($category['categoryName']); ?></option>
                        <?php endforeach; ?>
                        </select>
                    <input type="submit"/>

                </fieldset>


            </form>
        </div>
    </main>

    

</body>

</html>