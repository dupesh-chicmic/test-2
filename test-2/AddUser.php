<?php
include 'Database.php';
class AddUser {
    public $con;
    public function __construct() {
        $this->con =  Database::connectDB(); 
    }
    public $error = [];
    
    public function register() {
        try {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $trimphone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $trimpassword = trim($_POST['password'] ?? '');
            $confirmpassword = $_POST['confirmpassword'] ?? '';

            if (empty($username)) {
                $this->error[] = "username";
            }
            if (empty($email)) {
                $this->error[] = "email";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error[] = "invalid email";
            }
            if (empty($phone)){
                $this->error[] = "phone";
            }
            if (preg_replace('/\D/', '', $phone) !== $phone){
                $this->error[] = "invalid phone number";
            }
            if ($phone !== $trimphone) {
                $this->error[] = "spacephone";
            }
            if (empty($password)) {
                $this->error[] = "password";
            }
            if ($password !== $trimpassword) {
                $this->error[] = "spaces";
            }
            if (strlen($password) < 6) {
                $this->error[] = "validpassword";
            }
            if ($password !== $confirmpassword) {
                $this->error[] = "password mismatch";
            }

            if (empty($this->error)) {
                $sql = "INSERT INTO users (username, email, phone, status, password) VALUES ('$_POST[username]', '$_POST[email]', '$_POST[phone]', '$_POST[status]', '$_POST[password]')";
                $result = $this->con->query($sql);
                if($result === TRUE){
                    header('location: index.php');
                }
            } else{
                $this->error['database'] = "Database error: " . $this->con->error;
            }
        } catch (Exception $e) {
            $this->error[] = "An error occurred while registering: " . $e->getMessage();
            return $this->error;
        }
    }
}

$response = [];

if (isset($_POST['register'])) {
    $registration = new AddUser();
    $response = $registration->register();
    print_r($response);die;
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
    .error, span {
        color: red;
    }
</style>
<body class="bg-dark">
    <div class="container w-50 mt-5 border border-dark p-5 pt-3 rounded bg-light">
        <h1 class="text-center mt-2 mb-5">Registration Form</h1>
        <form action="AddUser.php" method="POST" class="mt-5" id="form">
            <div class="row mt-3">
                <div class="col">
                    <input type="text" name="username" placeholder="User Name" class="form-control">
                    <?php if (isset($response['username'])): ?>
                        <span class="error"><?= $response['username'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                    <?php if (isset($response['email'])): ?>
                        <span class="error"><?= $response['email'] ?></span>
                    <?php 
                    elseif (isset($response['invalid email'])): ?>
                        <span class="error"><?= $response['invalid email'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="tel" name="phone" placeholder="Phone" class="form-control">
                    <?php if (isset($response['phone'])): ?>
                        <span class="error"><?= $response['phone'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label for="status">Choose Status:</label>
                    <select id="status" name="status">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                    <?php if (isset($response['password'])): ?>
                        <span class="error"><?= $response['password'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control">
                    <?php if (isset($response['confirmpassword'])): ?>
                        <span class="error"><?= $response['confirmpassword'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <input class="btn btn-primary w-100" type="submit" name="register" value="Register">
                </div>
            </div>
            <div class="row">
                <div class="col">
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            $('#form').validate({
                rules: {
                    username: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    confirmpassword: {
                        required: true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    username: {
                        required: 'Username is required'
                    },
                    email: {
                        required: 'Email is required',
                        email: 'Please enter a valid email'
                    },
                    phone: {
                        required: 'Phone number is required',
                        digits: 'Phone number must contain only digits',
                        minlength: 'Length must be equal to 10',
                        maxlength: 'Length must be equal to 10'
                    },
                    password: {
                        required: 'Password is required',
                        minlength: 'Password must be at least 6 characters long'
                    },
                    confirmpassword: {
                        required: 'Password confirmation is required',
                        equalTo: 'Both passwords do not match'
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
