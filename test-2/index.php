<?php
include 'Database.php';
$con = new Database();
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
    <a href="AddUser.php"><button>Add User</button></a>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th><input type="checkbox" id="selectall"></th>
            <th>id</th>
            <th>username</th>
            <th>email</th>
            <th>phone</th>
            <th>password</th>
            <th>status</th>
            <th>operation</th>
        </tr>
    </thead>
    <!-- <tfoot>
    <tr>
            <td>id</td>
            <td>username</td>
            <td>email</td>
            <td>phone</td>
            <td>password</td>
            <td>file</td>
        </tr>
    </tfoot> -->
</table>
<button id="deleteSelected">Delete selected rows</button>

<script>
    let table = new DataTable('#myTable', {
        ajax: 'data.php',
        processing: true,
        search: true,
        serverSide: true,
        "columnDefs": [ {
        "targets": 0,
        "orderable": false
        } ]
    });

    $('#selectall').on('click', function() {
            $('.check').prop('checked', this.checked);
    });
    $('.check')is(:checked){
        console.log($(this));
        
    }



</script>

</body>
</html>
