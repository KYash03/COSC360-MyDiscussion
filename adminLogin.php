<?php
require_once 'db_connection.php';
session_start();
// login checks

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = openCon();
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $login_sql = "SELECT adminPass FROM admin WHERE adminUser =  ?";
    $stmt = $pdo -> prepare($login_sql);
    $stmt -> execute([$username]);
    $user_result= $stmt-> fetch();

    if (!$user_result)
        echo "Username does not exist";
    else if ($password === $user_result['adminPass']){
        $_SESSION['loggedin'] = true;
        $_SESSION['admin'] = true;
        header("location:http://localhost/COSC360-MyDiscussion/Home-merged.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
    $pdo = null;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="css/login-createpost.css">
</head>

<body>
    <header>
       
        <a href="Home-merged.php"><h1>Talks@UBC</h1></a>

    </header>
    <main>
        <div id = "admin"> 
            <form  id="admin-form" method ="post" action ="#">
                <fieldset>
                    <legend>Log In</legend>
                    <p>
                    <label>Username : </label>
                    <input type ="text" name = "username" required minlength="4" maxlength="20"/>
                    </p>
                    <p>
                        <label>Password : </label>
                        <input type ="password" name = "password" required minlength="8" maxlength="20"/>
                    </p>
                    <input type ="submit"/>
                </fieldset>
            </form>
        </div>
    </main>
</body>
</html>