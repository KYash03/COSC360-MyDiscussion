<?php
require_once 'path/to/db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use the openCon function from the db_connection file
    $pdo = OpenCon();

    // Prepare an insert statement
    $sql = "INSERT INTO posts (title, content) VALUES (:title, :content)";
    
    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        
        // Bind the parameters
        $stmt->bindParam(':title', $_POST['postTitle'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $_POST['postContent'], PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();
        
        echo "Post created successfully.";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $pdo = null;
}
?>
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
                    <input type="submit"/>

                </fieldset>


            </form>
        </div>
    </main>

    

</body>

</html>