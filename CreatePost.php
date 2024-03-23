<?php
require_once 'path/to/db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = OpenCon();

    
    $post_sql = "INSERT INTO posts (postTitle,postContent,categoryID) VALUES (?,?,?)";
    
    try {
        // Prepare the statement
        $stmt = $pdo->prepare($post_sql);
        //Add statement for postDate as well
        $postTitle = $_POST['postTitle'];
        $postContent = $_POST['postContent'];
        $categoryID= $_POST['category']
        $stmt->execute([$postTitle, $postContent,$categoryID]);

        
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
        <a href="Home.html"><h1>Talks@UBC</h1></a>

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
                        <option value="1">News & Current Events</option>
                        <option value="2">Technology & Science</option>
                        <option value="3">Entertainment & Media</option>
                        <option value="4">Gaming</option>
                        <option value="5">Lifestyle & Health</option>
                        <option value="6">Arts & Creativity</option>
                        <option value="7">Education & Careers</option>
                        <option value="8">Hobbies & Interests</option>
                        <option value="9">Sports & Fitness</option>
                        <option value="10">Community & Social</option>
                        </select>
                    <input type="submit"/>

                </fieldset>


            </form>
        </div>
    </main>

    

</body>

</html>