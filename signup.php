<?php

require_once 'db_connection.php';

if(isset($_REQUEST['sign_up'])) // Checking if sign up form submitted
{ 

    $username = strip_tags($_REQUEST['username']); // Get username
    $password = strip_tags($_REQUEST['password']); // Get password

    if(empty($username)) {
        $error[] = "Please enter username"; // check username field is not blank
    }
    else if(empty($password)) {
        $error[] = "Please enter password"; // check password field is not blank
    }
    else {
        try {
            $check_user = $conn->prepare("SELECT username FROM `user_list` WHERE username=:username"); // SQL select query for user check

            $data = array('username' => $username); // Data for SQL query
            $check_user->execute($data); // Execute SQL Query

            $row = $check_user->fetch(PDO::FETCH_ASSOC); // Fetch Data from SQL

            if ($row) {
                $error[] = "Sorry username already exists!"; // check if user already exists
            }

            else if (!isset($error)) { // Check if no error than continue to add user
                $en_pass = password_hash($password, PASSWORD_DEFAULT); // password encryption is important

                $save_user = $conn->prepare("INSERT INTO `user_list` (username,password) VALUES (:uname,:upass)"); // Create new user SQL query

                $newData = array(':uname' => $username, ':upass' => $en_pass); // New user data to insert into SQL

                if ($save_user->execute($newData)) {
                    $successMsg = "Sign up completed please go to login page!"; // Succsess message
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage(); // Sql error response if any
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center my-3">CREATE ACCOUNT</h2>
        <div class="user-form">
            <form action="" method="post">
                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                    <label for="username">Username</label>
                </div>

                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" id="password" placeholder="Enter password" name="password">
                    <label for="pwd">Password</label>
                    </div> 
                <div class="d-grid">
                    <input type="submit" class="btn btn-danger mb-2 btn-block alert-link" name="sign_up" value="SIGN UP">
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
                    Already have an account?
                    <a class="alert-link text-secondary" href="index.php">Login</a>
                </p>	
            </div>
        </div>
    </div>
</body>
</html>
