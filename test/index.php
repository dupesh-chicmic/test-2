<?php
session_start();
include 'error.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-dark">
<div class="container w-100">
    <div class="container inner-container d-flex flex-column align-items-center mt-5">
        <div class="row">
            <div class="col p-5">
                <a href="login.php" class="ms-5"><button class="btn btn-primary">Login</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col p-5 ms-5">
                <a href="register.php"><button class="btn btn-primary">Register</button></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>