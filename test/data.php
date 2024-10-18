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
