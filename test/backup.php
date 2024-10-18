connect.php

<?php
$con = new mysqli("localhost", "root", "", "test");



error.php

<?php
$uri = 'http://' . $_SERVER['HTTP_HOST'] . 'test/view.php';
if($uri != 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']){

    $_SESSION['flag']=[];
}



logout.php

<?php
session_start();
include 'error.php';
header('location:login.php');



index.php

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



register.php

<?php
session_start();
include 'error.php';
$error = [];
include 'connect.php';
if(isset($_POST['register'])){
    if(empty($_POST['username'])){
        array_push($error, "username");
    }
    if(empty($_POST['email'])){
        array_push($error, "email");
    }
    if(empty($_POST['phone'])){
        array_push($error, "phone");
    }
    if(empty($_POST['password'])){
        array_push($error, "password");
    }
    if(empty($_POST['confirmpassword'])){
        array_push($error, "confirmpassword");
    }
    if(!empty($error)){
        print_r($error);
    } else{
        $sql = "INSERT into `users` (username, email, phone, password) VALUES ('$_POST[username]', '$_POST[email]', '$_POST[phone]', '$_POST[password]')";
        $result = $con->query($sql);
        if($result === TRUE){
            $message = [
                'status' => 'success',
                'message' => 'Registration successful'
            ];
        } else{
            $message = [
                'status' => 'error',
                'message' => 'User not registered'
            ];
        }
        echo json_encode($message);die;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        <h1 class="text-center mt-2 mb-5">Registration Form</h1>
        <form action="register.php" method="POST" class="mt-5" id="form" enctype="multipart/form-data">
        <span><?php   if(isset($unique)){echo $unique;} ?></span>
            <div class="row mt-3">
                <div class="col">
                    <input type="text" name="username" placeholder="User Name" class="form-control">
                    <?php if(in_array("username", $error)) {
                    ?>
                    <span>Username is required</span>
                    <?php
                    } 
                    
                    ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="email" name="email" placeholder="Email" class="form-control">
                    <?php if(in_array("email", $error)) {
                    ?>
                    <span>Email is required</span>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="tel" name="phone" placeholder="Phone" class="form-control">
                    <?php if(in_array("phone", $error)) {
                    ?>
                    <span>Phone is required</span>
                    <?php
                
                    }    
                    ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                    <?php if(in_array("password", $error)) {
                    ?>
                    <span>Password is required</span>
                    <?php
                    }  
                    ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="confirmpassword" placeholder="Confirm Password" 
                    class="form-control">
                    <?php if(in_array("confirmpassword", $error)) {
                    ?>
                    <span>Password is required</span>
                    <?php
                    } 
                    ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                <input class="btn btn-primary w-100" type="submit" name="register" value="Register">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="d-flex justify-content-end mt-3">Already a User ?<a href="login.php">Login</a></p>
                </div>
            </div>
        </form>
    </div>

    
<script>
        $(document).ready(function(){
    $('#form').validate({
        rules:{
            username:{
                required: true,
            },
            email:{
                required: true,
                email: true
            },
            phone:{
                required: true,
                minlength: 10,
                maxlength:10
            },
            password:{
                required: true,
                minlength: 6
            },
            confirmpassword:{
                required: true,
                equalTo: '#password'
            }
        },
        messages:{
            username:{
                required: 'Username is required'
            },
            email:{
                required: 'Email is required',
                email: 'Please enter a valid email'
            },
            phone:{
                required: 'Phone number is required',
                minlength: 'Length must be equal to 10',
                maxlength: 'Length must be equal to 10'

            },
            password:{
                required: 'Password is required',
                minlength: 'Password must be atleast 6 characters long'
            },
            confirmpassword:{
                required: 'Password is required',
                equalTo: 'Both passwords do not match'
            }
        },
        submitHandler: function(form){
            let formData = $('#form').serialize();
            console.log(formData);
            $.ajax({
                url: "register.php",
                data: formData,
                method: "post",
                success: function(success){
                        let response = JSON.parse(success);
                        alert(response.message); 
                        window.location.replace("login.php");
                    },
                error: function(error){
                        let response = JSON.parse(error); 
                        alert(response.message); 
                    }
            });
        }
    }); 
});
</script>
<?php
$error = [];
?>
</body>
</html> 



login.php

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


view.php

<?php 
session_start();
$value = $_SESSION['flag'] ?? [];
if(!in_array("login", $value)){
    header('location:login.php');
}
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
</head>
<body>
    <a href="logout.php"><button>Logout</button></a>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>email</th>
            <th>phone</th>
            <th>password</th>
            <!-- <th>file</th> -->
        </tr>
    </thead>
    <tfoot>
    <tr>
            <td>id</td>
            <td>username</td>
            <td>email</td>
            <td>phone</td>
            <td>password</td>
            <!-- <td>file</td> -->
        </tr>
    </tfoot>
</table>

<script>
    let table = new DataTable('#myTable', {
        ajax: 'data.php',
        processing: true,
        search: true,
        serverSide: true
    });
</script>

</body>
</html>



data.php

<?php

$table = 'users';
 

$primaryKey = 'id';
 

$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'username', 'dt' => 1 ),
    array( 'db' => 'email',  'dt' => 2 ),
    array( 'db' => 'phone',   'dt' => 3 ),
    array( 'db' => 'password',   'dt' => 4 ),
    // array( 'db' => 'file',   'dt' => 5 )
);
 
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'test',
    'host' => 'localhost'
);
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
// 