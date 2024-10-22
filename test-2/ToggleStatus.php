<?php
include 'Database.php';
class ToggleStatus {
    public $con;
    public function __construct() {
        $this->con =  Database::connectDB(); 
    }
    function toggle(){
    $sql = "UPDATE users SET status = NOT status WHERE id='$_GET[statusid]'";
    $result = $this->con->query($sql);
    if($result === TRUE){
    header('location:index.php');
    }
    }
}

$togglestatus = new ToggleStatus;
$togglestatus->toggle();
