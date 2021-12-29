<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class='container mt-3'>
        <div class='alert alert-success text-center'>
            <strong>Logout Successfully...</strong>
        </div>
    </div>
</body>
</html>

<?php

header("refresh:2 index.php");

session_destroy();

?>
