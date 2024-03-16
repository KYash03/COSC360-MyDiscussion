<?php
require_once 'path/to/config/db_config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // we will have to add database code here to check if the username and password are valid
    if ($username === "admin" && $password === "password") {
        $_SESSION['loggedin'] = true;
        echo "Logged in successfully";
        exit();
    } else {
        echo "Invalid username or password.";
    }
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
       
        <a href="Home.html"><h1>Talks@UBC</h1></a>

    </header>
    <main>
        <div id = "login"> 
            <form  id="login-form" method ="post" action ="#">
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

        <div id = "signup">
            <form id="signup-form" method ="post" action ="#">
                <fieldset>
                    <legend>Sign Up</legend>
                    <p>
                        <label>First Name : </label>
                        <input type ="text" name = "name" required minlength="2" maxlength="20"/>
                    </p>
                    <p>
                        <label>Last Name : </label>
                        <input type ="text" name = "lastname" required minlength="2" maxlength="20"/>
                    </p>
                    <p>
                        <label>Email : </label>
                        <input type ="email" name = "email" required/>
                    </p>
                    <p>
                    <label>Username : </label>
                    <input type ="text" name = "username" required minlength="4" maxlength="20"/>
                    </p>
                    <p>
                        <label>Password : </label>
                        <input type ="password" name = "password" required minlength="8" maxlength="20"/>
                    </p>
                    <p>
                        <label>By checking this box, I accept the software license</label>
                        <input type = "checkbox" name = "accept">
                    </p>
                    <input type ="submit"/>
                </fieldset>
            </form>
        </div>
    </main>
</body>
</html>