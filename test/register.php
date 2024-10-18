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



