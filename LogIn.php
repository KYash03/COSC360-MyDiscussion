<?php
require_once 'db_connection.php';
$pdo=openCon();
session_start();
// login checks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $login_sql = "SELECT userID, password FROM user WHERE username =  ?";
    $stmt = $pdo -> prepare($login_sql);
    $stmt -> execute([$username]);
    $user_result= $stmt-> fetch();

    if (!$user_result)
        echo "Username does not exist";
    else if ($password === $user_result['password']) {

        //fetch userID

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userID']= $user_result['userID'];

        header("location:Home-merged.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}

//signup email check & posting data to database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'sign-up') {
    $name = trim($_POST['name']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $signup_sql1 = "SELECT COUNT(email) AS email_count FROM user WHERE email = ?";
    $stmt = $pdo->prepare($signup_sql1);
    $stmt->execute([$email]);
    $email_result = $stmt->fetch();

    if ($email_result['email_count'] > 0) {
        echo "This email is already used.";
    } else {
        // Inserting new user data into the database
        $signup_sql2 = "INSERT INTO user (firstName, lastName, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($signup_sql2);
        $success = $stmt->execute([$name, $lastname, $email, $username, $password]); 

        if ($success) {
            echo "Signup successful!";
        } else {
            echo "Unexpected error, please try again.";
        }
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
       
        <a href="Home-merged.php"><h1>Talks@UBC</h1></a>

    </header>
    <main>
        <div id = "login"> 
            <form  id="login-form" method ="post" action ="#">
                <fieldset>
                    <input type="hidden" name="action" value="login"/>
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
                    <input type="hidden" name="action" value="sign-up"/>
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