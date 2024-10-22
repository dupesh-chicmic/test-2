<?php
include 'Database.php';
class UpdateUser {
    public $con;
    public function __construct() {
        $this->con =  Database::connectDB(); 
    }
    
    public function fetch($id){
        $sql = "SELECT * FROM users WHERE id = '$id'";
        // echo $id;die;
        $result = $this->con->query($sql);
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        }
    }

    public function update() {
            $id = $_POST['updateid'] ?? '';
            // echo $id;die;
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $trimphone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $trimpassword = trim($_POST['password'] ?? '');

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
            if (empty($this->error)) {
                // echo $id;die;
                $sql_update = "UPDATE users SET username = '$_POST[username]', email = '$_POST[email]', phone = '$_POST[phone]', status = '$_POST[status]', password = '$_POST[password]' WHERE id='$id'";
                $result = $this->con->query($sql_update);
                // print_r($result);
                if($result === TRUE){
                    
                    // die('vdsjsbca');
                    header('location: index.php');
                }
            } else{
                $this->error['database'] = "Database error: " . $this->con->error;
            }
    }
}

$updation = new UpdateUser();
$id = isset($_GET['updateid']) ? $_GET['updateid'] : 'id not found';

try {
    $row = $updation->fetch($id);
} catch (Exception $th) {
    print_r($th);
    die;
}

if (isset($_POST['update'])) {
    $response = $updation->update();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Page</title>
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
        <h1 class="text-center mt-2 mb-5">Update Form</h1>
        <form action="UpdateUser.php" method="POST" class="mt-5" id="form">
        <input type="hidden" name="updateid" value="<?= $id ?>">
            <div class="row mt-3">
                <div class="col">
                    <input type="text" name="username" value="<?= $row['username'] ?? '' ?>" placeholder="User Name" class="form-control">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="email" id="email" name="email" value="<?= $row['email'] ?? '' ?>" placeholder="Email" class="form-control">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="tel" name="phone" value="<?= $row['phone'] ?? '' ?>" placeholder="Phone" class="form-control">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <label for="status">Choose Status:</label>
                    <select id="status" name="status" class="form-control">
                      <option value="1" <?= (isset($row['status']) && $row['status'] == 1) ? 'selected' : '' ?>>Active</option>
                      <option value="0" <?= (isset($row['status']) && $row['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <input type="password" name="password"  value="<?= $row['password'] ?? ''?>" id="password" placeholder="Password" class="form-control">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <input class="btn btn-primary w-100" type="submit" name="update" value="Update">
                </div>
            </div>
        </form>
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
                    status:{
                        required: true
                    },
                    password:{
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
                    status:{
                        required: 'Status is required'
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