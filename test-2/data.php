<?php

$table = 'users';
 

$primaryKey = 'id';

$columns = array(
    array(
        'db' => 'id', 
        'dt' => 0,
        'formatter' => function($id) {
            return '
                <input type="checkbox" class="check" userId='.$id.'>
            ';
        }
    ),
    array( 'db' => 'id', 'dt' => 1 ),
    array( 'db' => 'username', 'dt' => 2 ),
    array( 'db' => 'email',  'dt' => 3 ),
    array( 'db' => 'phone',   'dt' => 4 ),
    array( 'db' => 'password',   'dt' => 5 ),
    // array( 'db' => 'status',   'dt' => 5 ),
    array(
        'db' => 'status',
        'dt' => 6,
        'formatter' => function($status) {
            return $status == 1 ? 'Active' : 'Inactive';
        }
    ),
    array(
        'db' => 'id', 
        'dt' => 7,
        'formatter' => function($id) {
            return '
                <a href=UpdateUser.php?updateid='.$id.'><button data-id="' . $id . '">Update</button></a>
                <a href=DeleteUser.php?deleteid='.$id.'><button data-id="' . $id . '">Delete</button></a>
                <a href=ToggleStatus.php?statusid='.$id.'><button data-id="' . $id . '">Change Status</button></a>
            ';
        }
    )
);
 
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'test-2',
    'host' => 'localhost'
);
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);


