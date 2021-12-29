<?php

require_once 'db_connection.php';

session_start();

// redirect user to login page if not logged in
if(!isset($_SESSION['user'])) {
    header("location: index.php");
} 

$user_id = $_SESSION['user'];
if (!empty($_SESSION['user_pic'])) {
    $user_pic = $_SESSION['user_pic'];
} 
else {
    $user_pic = "User have not uploaded any pic yet";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filepond User Picture</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">
</head>
<body>
    <div class="container mt-3">
        <div class="jumbotron">
            <h1 class="display-6 text-uppercase">Hello, <?php echo $user_id; ?></h1>
            <div class="d-flex">
                <p class="lead flex-grow-1">Please edit your profile picture below.</p>
                <p class="lead"><a class="text-danger text-decoration-none" href="logout.php">Logout</a></p>
            </div>
            <hr class="my-4">
        </div>
    </div>   
</body>
</html>