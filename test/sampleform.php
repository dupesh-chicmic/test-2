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