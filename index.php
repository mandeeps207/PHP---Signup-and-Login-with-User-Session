<?php

require_once 'db_connection.php';

session_start();

// redirect user to home page if already logged in
if(isset($_SESSION['user'])) {
    header("location: home.php");
} 

if (isset($_REQUEST['log_in'])) { // check if login form is submittted
    $username = strip_tags($_REQUEST['username']); // User name from login form
    $password = strip_tags($_REQUEST['password']); // Password from login form

    if (empty($username)) { // check if username field is not left blank
        $error[] = "Please fill username"; // Error throw for blank username
    }
    else if (empty($password)) { // check if password field is not left blank
        $error[] = "Please fill password"; // Error throw for blank password
    }
    else {
        try {
            $check_user = $conn->prepare("SELECT * FROM `user_list` WHERE username=:username"); // Select user from SQL

            $check_user->execute(array(':username' => $username)); // execute query for username
            $row = $check_user->fetch(PDO::FETCH_ASSOC); // fetch user data from SQL

            if($check_user->rowCount() > 0) {
                if ($row['username'] == $username) { // Check if username match in SQL
                    if (password_verify($password, $row['password'])) { // cross check password match
                        $_SESSION['user'] = $row['username']; // Set user session with his username
                        $_SESSION['user_pic'] = $row['profile_picture_url']; // Set user profit picture url
                        $successMsg = "Login sucess..."; // login success response

                        header('refresh:2; home.php'); // redirect to homepage
                    }
                    else {
                        $error[] = "Password mismatch for user " . $username; // password wrong error response
                    }
                }
                else {
                    $error[] = "Wrong user ID"; // Error response for wrong user id
                }
            }
            else {
                $error[] = "Wrong user ID"; // Error response for wrong user id
            }
        } catch (PDOException $e) {
            $e->getMessage(); // Error response from SQL connection failure
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filepond User Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center my-3">LOGIN TO SYSTEM</h2>
        <div class="user-form">
            <form action="" method="post">
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                    <label for="username">Username</label>
                </div>

                <div class="form-floating mt-3 mb-3">
                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                    <label for="password">Password</label>
                    </div> 
                <div class="d-grid">
                    <input type="submit" class="btn btn-success mb-2 btn-block alert-link" name="log_in" value="LOGIN">
                </div>
            </form>
            <?php
            if(isset($error)) {
                foreach($error as $err) { ?>
                    <div class="alert alert-danger text-center">
                        <strong><?php echo $err; ?></strong>
                    </div>
        <?php   }
            }
            if(isset($successMsg)) { ?>
                <div class="alert alert-success text-center">
                    <strong><?php echo $successMsg; ?></strong>
                </div>
    <?php   } ?> 
            <div class="form-group">
                <p class="text-secondary">
                    Don't have account?
                    <a class="alert-link text-secondary" href="signup.php">Create Account</a>
                </p>	
            </div>
        </div>
    </div>
</body>
</html>
