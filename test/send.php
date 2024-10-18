backup.php

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



SEPARATE FILES

connect.php

<?php
$con = new mysqli("localhost", "root", "", "test");



data.php

<?php

$table = 'users';
 

$primaryKey = 'id';
// $file = 'http://localhost/test/uploads/';

$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'username', 'dt' => 1 ),
    array( 'db' => 'email',  'dt' => 2 ),
    array( 'db' => 'phone',   'dt' => 3 ),
    array( 'db' => 'password',   'dt' => 4 ),
    // array( 'db' => 'file',   'dt' => 5 )
    array( 'db' => 'file',   'dt' => 5, 'formatter' => function($filename){
            return '<img src="' . 'http://localhost/test/uploads/' . $filename . '" style="width:50px; height:auto;" />';
        }
    )
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




error.php

<?php
$uri = 'http://' . $_SERVER['HTTP_HOST'] . 'test/view.php';
if($uri != 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']){

    $_SESSION['flag']=[];
}




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




logout.php

<?php
session_start();
include 'error.php';
header('location:login.php');




register.php

<?php
session_start();
include 'error.php';
$error = [];
include 'connect.php';

if (isset($_POST['register'])) {
    if (empty($_POST['username'])) {
        array_push($error, "username");
    }
    if (empty($_POST['email'])) {
        array_push($error, "email");
    }
    if (empty($_POST['phone'])) {
        array_push($error, "phone");
    }
    if (empty($_POST['password'])) {
        array_push($error, "password");
    }
    if (empty($_POST['confirmpassword'])) {
        array_push($error, "confirmpassword");
    }

    $flag = 1;
    $dir = 'uploads/';
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $tempName = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFilename = time() . '_' . basename($fileName);
        $targetFile = $dir . $newFilename;
        
        $fileSize = $_FILES['image']['size'];
        $check = getimagesize($tempName);
    
        if ($check !== false) {
            if ($fileType !== "png" && $fileType !== "jpg" && $fileType !== "jpeg") {
                array_push($error, "File must be PNG, JPG, or JPEG");
                $flag = 0;
            }
            if ($fileSize > 15000000) {
                array_push($error, "File size is too large");
                $flag = 0;
            }
        } else {
            array_push($error, "File is not an actual image");
            $flag = 0;
        }

        if ($flag == 1) {
            if (move_uploaded_file($tempName, $targetFile)) {
            } else {
                array_push($error, "File upload failed");
            }
        }
    } else {
        array_push($error, "File is required");
    }

    if (!empty($error)) {
        print_r($error);
    } else {
        $sql = "INSERT INTO `users` (username, email, phone, password, file) VALUES ('$_POST[username]', '$_POST[email]', '$_POST[phone]', 
'$_POST[password]', '$newFilename')";
        
        $result = $con->query($sql);
        if ($result === TRUE) {
            $message = [
                'status' => 'success',
                'message' => 'Registration successful'
            ];
        } else {
            $message = [
                'status' => 'error',
                'message' => 'User not registered'
            ];
        }
        echo json_encode($message);
        die;
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
        <input type="file" name="image">
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
                digits: true,
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
                digits: 'Phone number must contain only digits',
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
            // let formData = $('#form').serialize();
            let formData = new FormData(form);
            console.log(formData);
            $.ajax({
                url: "register.php",
                data: formData,
                method: "post",
                contentType: false,
                processData: false,
                success: function(success){
                        let response = JSON.parse(success);
                        alert(response.message); 
                        // window.location.replace("login.php");
                        if (response.status == 'success') {
                        window.location.href = "login.php";
                    }
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



sampleform.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container w-50 mt-5 border border-dark p-5 pt-3">
        <h1 class="text-center mt-2 mb-5">Fill details:</h1>
        <form action="" method="POST" class="mt-5">
            <div class="row">
                <div class="col">
                    <input type="file" name="file">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="text" name="firstname" placeholder="First Name" class="form-control">
                </div>
                <div class="col">
                    <input type="text" name="lastname" placeholder="Last Name" class="form-control">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="tel" name="phone" placeholder="Phone" class="form-control">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="password" placeholder="Password" class="form-control">
                </div>
            </div>
        </form>
    </div>
</body>
</html>




ssp.class.php

<?php

/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */


// Please Remove below 4 lines as this is use in Datatatables test environment for your local or live environment please remove it or else it will not work
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}


class SSP {
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	static function data_output ( $columns, $data )
	{
		$out = array();

		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();

			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];

				// Is there a formatter?
				if ( isset( $column['formatter'] ) ) {
                    if(empty($column['db'])){
                        $row[ $column['dt'] ] = $column['formatter']( $data[$i] );
                    }
                    else{
                        $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                    }
				}
				else {
                    if(!empty($column['db'])){
                        $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                    }
                    else{
                        $row[ $column['dt'] ] = "";
                    }
				}
			}

			$out[] = $row;
		}

		return $out;
	}


	/**
	 * Database connection
	 *
	 * Obtain an PHP PDO connection from a connection details array
	 *
	 *  @param  array $conn SQL connection details. The array should have
	 *    the following properties
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 *  @return resource PDO connection
	 */
	static function db ( $conn )
	{
		if ( is_array( $conn ) ) {
			return self::sql_connect( $conn );
		}

		return $conn;
	}


	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	static function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	static function order ( $request, $columns )
	{
		$order = '';

		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = self::pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';

					$orderBy[] = '`'.$column['db'].'` '.$dir;
				}
			}

			if ( count( $orderBy ) ) {
				$order = 'ORDER BY '.implode(', ', $orderBy);
			}
		}

		return $order;
	}


	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	static function filter ( $request, $columns, &$bindings )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = self::pluck( $columns, 'dt' );

		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) {
					if(!empty($column['db'])){
						$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
						$globalSearch[] = "`".$column['db']."` LIKE ".$binding;
					}
				}
			}
		}

		// Individual column filtering
		if ( isset( $request['columns'] ) ) {
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				$str = $requestColumn['search']['value'];

				if ( $requestColumn['searchable'] == 'true' &&
				 $str != '' ) {
					if(!empty($column['db'])){
						$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
						$columnSearch[] = "`".$column['db']."` LIKE ".$binding;
					}
				}
			}
		}

		// Combine the filters into a single string
		$where = '';

		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}

		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
			$where = 'WHERE '.$where;
		}

		return $where;
	}


	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
	static function simple ( $request, $conn, $table, $primaryKey, $columns )
	{
		$bindings = array();
		$db = self::db( $conn );

		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings );

		// Main query to actually get the data
		$data = self::sql_exec( $db, $bindings,
			"SELECT `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);

		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`
			 $where"
		);
		$recordsFiltered = $resFilterLength[0][0];

		// Total data set length
		$resTotalLength = self::sql_exec( $db,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`"
		);
		$recordsTotal = $resTotalLength[0][0];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}


	/**
	 * The difference between this method and the `simple` one, is that you can
	 * apply additional `where` conditions to the SQL queries. These can be in
	 * one of two forms:
	 *
	 * * 'Result condition' - This is applied to the result set, but not the
	 *   overall paging information query - i.e. it will not effect the number
	 *   of records that a user sees they can have access to. This should be
	 *   used when you want apply a filtering condition that the user has sent.
	 * * 'All condition' - This is applied to all queries that are made and
	 *   reduces the number of records that the user can access. This should be
	 *   used in conditions where you don't want the user to ever have access to
	 *   particular records (for example, restricting by a login id).
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @param  string $whereResult WHERE condition to apply to the result set
	 *  @param  string $whereAll WHERE condition to apply to all queries
	 *  @return array          Server-side processing response array
	 */
	static function complex ( $request, $conn, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null )
	{
		$bindings = array();
		$db = self::db( $conn );
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';

		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings );

		$whereResult = self::_flatten( $whereResult );
		$whereAll = self::_flatten( $whereAll );

		if ( $whereResult ) {
			$where = $where ?
				$where .' AND '.$whereResult :
				'WHERE '.$whereResult;
		}

		if ( $whereAll ) {
			$where = $where ?
				$where .' AND '.$whereAll :
				'WHERE '.$whereAll;

			$whereAllSql = 'WHERE '.$whereAll;
		}

		// Main query to actually get the data
		$data = self::sql_exec( $db, $bindings,
			"SELECT `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);

		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`
			 $where"
		);
		$recordsFiltered = $resFilterLength[0][0];

		// Total data set length
		$resTotalLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table` ".
			$whereAllSql
		);
		$recordsTotal = $resTotalLength[0][0];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}


	/**
	 * Connect to the database
	 *
	 * @param  array $sql_details SQL server connection details array, with the
	 *   properties:
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 * @return resource Database connection handle
	 */
	static function sql_connect ( $sql_details )
	{
		try {
			$db = @new PDO(
				"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
				$sql_details['user'],
				$sql_details['pass'],
				array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (PDOException $e) {
			self::fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}

		return $db;
	}


	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	static function sql_exec ( $db, $bindings, $sql=null )
	{
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}

		$stmt = $db->prepare( $sql );
		//echo $sql;

		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];
				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
			}
		}

		// Execute
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			self::fatal( "An SQL error occurred: ".$e->getMessage() );
		}

		// Return all
		return $stmt->fetchAll( PDO::FETCH_BOTH );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	static function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );

		exit(0);
	}

	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	static function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );

		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);

		return $key;
	}


	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	static function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            if(empty($a[$i][$prop])){
                continue;
			}
			//removing the $out array index confuses the filter method in doing proper binding,
			//adding it ensures that the array data are mapped correctly
			$out[$i] = $a[$i][$prop];
		}

		return $out;
	}


	/**
	 * Return a string from an array or a string
	 *
	 * @param  array|string $a Array to join
	 * @param  string $join Glue for the concatenation
	 * @return string Joined string
	 */
	static function _flatten ( $a, $join = ' AND ' )
	{
		if ( ! $a ) {
			return '';
		}
		else if ( $a && is_array($a) ) {
			return implode( $join, $a );
		}
		return $a;
	}
}




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
            <th>file</th>
        </tr>
    </thead>
    <tfoot>
    <tr>
            <td>id</td>
            <td>username</td>
            <td>email</td>
            <td>phone</td>
            <td>password</td>
            <td>file</td>
        </tr>
    </tfoot>
</table>

<script>
    let table = new DataTable('#myTable', {
        ajax: 'data.php',
        processing: true,
        search: true,
        serverSide: true,
    });
</script>

</body>
</html>