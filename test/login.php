<?php
session_start();
include 'error.php';
$loginerror = [];
if(isset($_POST['login'])){
    if(empty($_POST['email'])){
        array_push($loginerror, "email");
    }
    if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST['email'])){
        array_push($loginerror, "validemail");
    }
    if(empty($_POST['password'])){
        array_push($loginerror, "password");
    }
    $passlength = strlen($_POST['password']);
    if($passlength<6){
        array_push($inerror, $passlength);
    }
   
    if(!empty($loginerror)){
        header("location: login.php");
    }
}


include 'connect.php';
if(isset($_POST['login'])){
    $mes = "";
    $sql = "SELECT * FROM users WHERE email='$_POST[email]'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    if($_POST['password'] == $row['password']){
        $arrLogin = [];
        header('location:view.php');
        array_push($arrLogin, "login");
        $_SESSION['flag'] = $arrLogin;
    } else{
        $mes = "Invalid credentials";
    }
   
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
</head>
<style>
    .error, span{
        color: red;
    }
</style>
<body  class="bg-dark">
    <div class="container w-50 mt-5 border border-dark p-5 pt-3 rounded bg-light">
        <h1 class="text-center mt-2 mb-5">Login Form</h1>
        <form action="login.php" method="POST" class="mt-5" id="loginform">
            <span><?php   if(isset($mes)){echo $mes;}
            ?></span>
            <div class="row mt-3">
                <div class="col">
                    <input type="email" name="email" placeholder="Email" class="form-control">
                    <?php if(in_array("email", $loginerror)) {
                ?>
            <span>Email is required</span>
            <?php
        }   
        if(in_array("validemail", $loginerror)) {
            ?>
        <span>Invalid email format</span>
        <?php
    }    ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="password" placeholder="Password" class="form-control">
                    <?php if(in_array("password", $loginerror)) {
                ?>
            <span>Password is required</span>
            <?php
        }  if(in_array("passlength", $loginerror)) {
            ?>
        <span>Password must be atleast 6 digits long</span>
        <?php
    }  ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                <input type="submit" class="btn btn-primary w-100" name="login" value="login">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="d-flex justify-content-end mt-3">New User ?<a href="register.php">Register</a></p>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
    $('#loginform').validate({
        rules:{
            email:{
                required: true,
                email: true
            },
            password:{
                required: true,
                minlength: 6
            }
        },
        messages:{
            email:{
                required: 'Email is required',
                email: 'Please enter a valid email'
            },
            password:{
                required: 'Password is required',
                minlength: 'Password must be atleast 6 characters long',
            }
        },
        submitHandler: function(form){
            form.submit();
        }
    });
});
    </script>
    
</body>
</html>


